/**
 * Homepage section 03 · Life at Mission Villa: chapter selector + video player.
 *
 * - Three chapters share ONE <video>. Picking a chapter pauses playback, swaps
 *   sources, captions and poster, updates the info card, and fades once.
 * - Everything is user-initiated: no autoplay, no scroll triggers, no cycling.
 * - Videos use preload="none", so nothing is downloaded until Play is pressed.
 * - Chapters whose film is not on disk yet get no sources at all (the server
 *   omits them) and show an honest "film in production" notice over the poster.
 * - Without JavaScript the first chapter keeps native browser controls.
 *
 * Media contract: docs/SECTION_03_VIDEO_CONTRACT.md
 */
const SEEK_STEP = 5;
const SEEK_STEP_LONG = 10;
const HIDE_CONTROLS_MS = 2600;
const SPINNER_DELAY_MS = 250;

const clock = (s) => {
  if (!Number.isFinite(s) || s < 0) s = 0;
  const t = Math.floor(s);
  return `${Math.floor(t / 60)}:${String(t % 60).padStart(2, '0')}`;
};

function initLifeGallery(root) {
  let data;
  try {
    data = JSON.parse(root.querySelector('[data-life-data]')?.textContent || '');
  } catch {
    return; // Leave the server-rendered first chapter (native controls) in place.
  }
  const chapters = data.chapters || [];
  if (chapters.length === 0) return;

  const $ = (sel) => root.querySelector(sel);
  const tabs = [...root.querySelectorAll('[data-life-tab]')];
  const tablist = $('[data-life-tablist]');
  const panel = $('[data-life-panel]');
  const player = $('[data-life-player]');
  const stage = $('[data-life-stage]');
  const video = $('[data-life-video]');
  const posterImg = $('[data-life-poster-img]');
  const posterMobile = $('[data-life-poster-mobile]');
  const badge = $('[data-life-badge]');
  const bigPlay = player.querySelector('.life-player__bigplay');
  const notice = $('[data-life-notice]');
  const noticeTitle = $('[data-life-notice-title]');
  const noticeDetail = $('[data-life-notice-detail]');
  const retryBtn = player.querySelector('[data-life-action="retry"]');
  const controls = $('[data-life-controls]');
  const seek = $('[data-life-seek]');
  const volume = $('[data-life-volume]');
  const muteBtn = player.querySelector('[data-life-action="mute"]');
  const ccBtn = $('[data-life-cc]');
  const fsBtn = $('[data-life-fs]');
  const currentEl = $('[data-life-current]');
  const durationEl = $('[data-life-duration]');
  const live = $('[data-life-live]');
  const infoItems = [...root.querySelectorAll('[data-life-info-item]')];
  if (!player || !video || !stage || tabs.length !== chapters.length) return;

  const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)');
  const saveData = Boolean(navigator.connection?.saveData) || window.matchMedia('(prefers-reduced-data: reduce)').matches;
  const desktop = window.matchMedia('(min-width: 1100px)');
  const fadeMs = () => (reducedMotion.matches ? 0 : 220);

  const canFullscreen = Boolean(document.fullscreenEnabled && player.requestFullscreen) || typeof video.webkitEnterFullscreen === 'function';

  let current = 0;
  let captionsOn = false;
  let seeking = false;
  let hideTimer = 0;
  let spinnerTimer = 0;
  let switchTimer = 0;
  let lastPointer = 'mouse';
  let pendingResume = 0;
  const positions = new Map(); // chapter index -> last playback position (seconds)

  // ---- helpers -----------------------------------------------------------
  const chapter = () => chapters[current];
  const announce = (msg) => { if (live) { live.textContent = ''; requestAnimationFrame(() => { live.textContent = msg; }); } };

  function setState(state) {
    player.dataset.state = state;
    const c = chapter();
    const showBig = c.available && (state === 'idle' || state === 'paused' || state === 'ended');
    bigPlay.hidden = !showBig;
    bigPlay.setAttribute('aria-label', `${state === 'ended' ? 'Replay' : 'Play'} video: ${c.title}`);
    const toggle = controls.querySelector('[data-life-action="toggle"]');
    toggle.setAttribute('aria-label', state === 'playing' || state === 'loading' ? 'Pause' : state === 'ended' ? 'Replay' : 'Play');
    controls.hidden = !c.available || state === 'error';
    if (state !== 'playing') showControls(false);
  }

  function setLoading(on) {
    clearTimeout(spinnerTimer);
    if (on) spinnerTimer = setTimeout(() => { player.dataset.loading = 'true'; }, SPINNER_DELAY_MS);
    else player.dataset.loading = 'false';
  }

  function showNotice(kind) {
    const isError = kind === 'error';
    notice.hidden = false;
    noticeTitle.textContent = isError ? 'This film couldn’t be loaded' : data.labels.unavailable;
    noticeDetail.textContent = isError ? 'Please check your connection and try again.' : data.labels.unavailable_detail;
    retryBtn.hidden = !isError;
  }

  // ---- controls visibility -------------------------------------------------
  function showControls(autoHide = true) {
    player.dataset.controls = 'visible';
    clearTimeout(hideTimer);
    if (autoHide && player.dataset.state === 'playing') {
      hideTimer = setTimeout(() => {
        if (player.dataset.state === 'playing' && !controls.contains(document.activeElement) && !controls.matches(':hover') && !seeking) {
          player.dataset.controls = 'hidden';
        }
      }, HIDE_CONTROLS_MS);
    }
  }

  // ---- source selection ----------------------------------------------------
  function pickSource(sources) {
    if (sources.length <= 1) return sources[0];
    const want = saveData ? 0 : stage.clientWidth * Math.min(window.devicePixelRatio || 1, 2);
    const sized = sources.map((s) => ({ ...s, w: s.width || 1920 })).sort((a, b) => a.w - b.w);
    return sized.find((s) => s.w >= want) || sized[sized.length - 1];
  }

  // Chrome starts downloading on video.load() even with preload="none" while a
  // <source> is attached, so sources (and caption tracks) are attached only when
  // the visitor presses Play. With nothing attached, load() just resets the element.
  function clearMedia() {
    video.pause();
    video.querySelectorAll('source, track').forEach((el) => el.remove());
    video.removeAttribute('src');
    video.load();
  }

  function attachMedia() {
    const c = chapter();
    if (!c.available || video.querySelector('source')) return;
    const src = pickSource(c.sources);
    const source = document.createElement('source');
    source.src = src.src;
    source.type = src.type;
    source.addEventListener('error', onSourceError);
    video.append(source);
    c.captions.forEach((t) => {
      const track = document.createElement('track');
      track.kind = t.kind;
      track.src = t.src;
      track.srclang = t.srclang;
      track.label = t.label;
      // Lift cues that use default placement clear of the control bar.
      track.addEventListener('load', () => {
        [...(track.track.cues || [])].forEach((cue) => { if (cue.line === 'auto') cue.line = -3; });
      });
      video.append(track);
    });
    applyCaptions();
  }

  function applyCaptions() {
    // 'disabled' (not 'hidden') so a caption file is fetched only once captions are wanted.
    [...video.textTracks].forEach((track, i) => {
      track.mode = captionsOn && i === 0 ? 'showing' : 'disabled';
    });
    ccBtn.setAttribute('aria-pressed', String(captionsOn));
    ccBtn.setAttribute('aria-label', captionsOn ? 'Turn captions off' : 'Turn captions on');
  }

  function updateTime() {
    const d = Number.isFinite(video.duration) && video.duration > 0 ? video.duration : (chapter().duration || 0);
    const t = video.currentTime || 0;
    currentEl.textContent = clock(t);
    durationEl.textContent = clock(d);
    if (!seeking) seek.value = d ? String(Math.round((t / d) * 1000)) : '0';
    seek.style.setProperty('--lv-progress', `${d ? (t / d) * 100 : 0}%`);
    seek.setAttribute('aria-valuetext', `${clock(t)} of ${clock(d)}`);
  }

  function updateBuffer() {
    const d = video.duration;
    if (!Number.isFinite(d) || d <= 0 || video.buffered.length === 0) return;
    const end = video.buffered.end(video.buffered.length - 1);
    seek.style.setProperty('--lv-buffer', `${(end / d) * 100}%`);
  }

  // ---- chapter rendering ---------------------------------------------------
  function render(index) {
    const prev = current;
    if (player.dataset.started === 'true' && video.currentTime > 0 && !video.ended) positions.set(prev, video.currentTime);
    current = index;
    const c = chapter();

    tabs.forEach((tab, i) => {
      const on = i === index;
      tab.setAttribute('aria-selected', String(on));
      tab.tabIndex = on ? 0 : -1;
    });
    panel.setAttribute('aria-labelledby', tabs[index].id);
    infoItems.forEach((item, i) => {
      const on = i === index;
      item.toggleAttribute('data-active', on);
      item.inert = !on;
      if (on) item.removeAttribute('aria-hidden'); else item.setAttribute('aria-hidden', 'true');
    });

    // Poster
    posterImg.src = c.poster.src;
    posterImg.alt = c.poster.alt;
    posterImg.style.objectPosition = c.poster.position || '50% 50%';
    if (posterMobile) posterMobile.srcset = c.poster.srcMobile || c.poster.src;
    badge.textContent = c.provenanceLabel;
    player.setAttribute('aria-label', `Video player: ${c.title}`);
    player.dataset.started = 'false';
    player.dataset.hasAudio = String(c.hasAudio !== false);
    player.dataset.hasCaptions = String(c.captions.length > 0);
    setLoading(false);

    clearMedia();
    seek.value = '0';
    seek.disabled = true;
    seek.style.setProperty('--lv-buffer', '0%');
    pendingResume = positions.get(index) || 0;

    if (c.available) {
      video.poster = c.poster.src;
      video.hidden = false;
      applyCaptions();
      notice.hidden = true;
      setState('idle');
    } else {
      video.hidden = true;
      video.removeAttribute('poster');
      showNotice('unavailable');
      setState('unavailable');
    }
    updateTime();
  }

  function selectChapter(index, { focus = false } = {}) {
    if (focus) tabs[index].focus();
    if (index === current) return;
    clearTimeout(switchTimer);

    const ms = fadeMs();
    if (!ms) { render(index); return; }
    video.pause();
    player.classList.add('is-switching');
    // Info card fades through CSS (outgoing out, incoming in) as soon as data-active moves.
    infoItems.forEach((item, i) => item.toggleAttribute('data-active', i === index));
    switchTimer = setTimeout(() => {
      render(index);
      requestAnimationFrame(() => player.classList.remove('is-switching'));
    }, ms);
  }

  // ---- playback ------------------------------------------------------------
  function play() {
    if (!chapter().available) return;
    player.dataset.started = 'true';
    attachMedia();
    if (video.ended) video.currentTime = 0;
    setState('loading');
    setLoading(true);
    const p = video.play();
    if (p && typeof p.catch === 'function') {
      p.catch((err) => {
        setLoading(false);
        if (err && err.name === 'AbortError') return; // a chapter switch interrupted it
        if (player.dataset.state !== 'error') setState(video.currentTime > 0 ? 'paused' : 'idle');
        if (video.currentTime === 0) player.dataset.started = 'false';
      });
    }
  }

  function togglePlay() {
    if (!chapter().available || player.dataset.state === 'error') return;
    if (video.paused || video.ended) play(); else video.pause();
  }

  function seekBy(delta) {
    if (!Number.isFinite(video.duration)) return;
    video.currentTime = Math.min(Math.max(0, video.currentTime + delta), video.duration);
    updateTime();
    showControls();
  }

  function setVolume(v) {
    video.volume = Math.min(1, Math.max(0, v));
    video.muted = video.volume === 0;
  }

  function toggleFullscreen() {
    if (document.fullscreenElement) {
      document.exitFullscreen?.();
    } else if (document.fullscreenEnabled && player.requestFullscreen) {
      player.requestFullscreen().catch(() => {});
    } else if (typeof video.webkitEnterFullscreen === 'function' && chapter().available) {
      // iOS Safari: element fullscreen is unavailable; use the native video presentation.
      if (player.dataset.started !== 'true') play();
      try { video.webkitEnterFullscreen(); } catch { /* not ready yet */ }
    }
  }

  function onSourceError() {
    setLoading(false);
    setState('error');
    showNotice('error');
    announce('This film couldn’t be loaded.');
  }

  // ---- video events ----------------------------------------------------------
  video.addEventListener('loadedmetadata', () => {
    seek.disabled = false;
    if (pendingResume > 0 && pendingResume < video.duration - 1) video.currentTime = pendingResume;
    pendingResume = 0;
    applyCaptions();
    updateTime();
  });
  video.addEventListener('durationchange', updateTime);
  video.addEventListener('timeupdate', updateTime);
  video.addEventListener('progress', updateBuffer);
  video.addEventListener('waiting', () => setLoading(true));
  video.addEventListener('playing', () => { setLoading(false); setState('playing'); showControls(); });
  video.addEventListener('canplay', () => setLoading(false));
  video.addEventListener('pause', () => {
    if (video.ended || player.dataset.state === 'error' || player.dataset.state === 'unavailable') return;
    setLoading(false);
    if (player.dataset.started === 'true') setState('paused');
  });
  video.addEventListener('ended', () => { setLoading(false); setState('ended'); });
  video.addEventListener('error', () => { if (video.error) onSourceError(); });
  video.addEventListener('volumechange', () => {
    const muted = video.muted || video.volume === 0;
    player.dataset.muted = String(muted);
    muteBtn.setAttribute('aria-pressed', String(muted));
    muteBtn.setAttribute('aria-label', muted ? 'Unmute' : 'Mute');
    volume.value = String(Math.round((muted ? 0 : video.volume) * 100));
    volume.style.setProperty('--lv-progress', `${volume.value}%`);
  });

  // ---- control wiring --------------------------------------------------------
  player.addEventListener('click', (e) => {
    const action = e.target.closest('[data-life-action]')?.dataset.lifeAction;
    if (action === 'toggle') { togglePlay(); return; }
    if (action === 'mute') { if (video.muted || video.volume === 0) { video.muted = false; if (video.volume === 0) video.volume = 0.6; } else { video.muted = true; } return; }
    if (action === 'captions') { captionsOn = !captionsOn; applyCaptions(); return; }
    if (action === 'fullscreen') { toggleFullscreen(); return; }
    if (action === 'retry') { notice.hidden = true; render(current); play(); return; }

    // Clicks on the picture itself (not on a control).
    if (e.target.closest('.life-player__controls, .life-player__notice, button, input')) return;
    if (!chapter().available || player.dataset.state === 'error') return;
    if (lastPointer === 'touch' && player.dataset.state === 'playing') {
      // Touch: first tap reveals the controls, a second tap hides them.
      if (player.dataset.controls === 'hidden') showControls(); else player.dataset.controls = 'hidden';
      return;
    }
    togglePlay();
  });
  stage.addEventListener('dblclick', (e) => {
    if (lastPointer !== 'mouse' || e.target.closest('.life-player__controls, button, input')) return;
    if (chapter().available) toggleFullscreen();
  });
  player.addEventListener('pointerdown', (e) => { lastPointer = e.pointerType || 'mouse'; });
  stage.addEventListener('pointermove', (e) => { if (e.pointerType === 'mouse') showControls(); });
  stage.addEventListener('pointerleave', (e) => {
    if (e.pointerType !== 'mouse' || player.dataset.state !== 'playing') return;
    clearTimeout(hideTimer);
    hideTimer = setTimeout(() => {
      if (player.dataset.state === 'playing' && !controls.contains(document.activeElement)) player.dataset.controls = 'hidden';
    }, 700);
  });
  player.addEventListener('focusin', () => showControls());

  seek.addEventListener('input', () => {
    if (!Number.isFinite(video.duration)) return;
    seeking = true;
    video.currentTime = (Number(seek.value) / 1000) * video.duration;
    updateTime();
    showControls();
  });
  seek.addEventListener('change', () => { seeking = false; showControls(); });
  seek.addEventListener('pointerup', () => { seeking = false; });

  volume.addEventListener('input', () => { setVolume(Number(volume.value) / 100); showControls(); });

  // Keyboard shortcuts while focus is inside the player.
  player.addEventListener('keydown', (e) => {
    if (e.altKey || e.ctrlKey || e.metaKey) return;
    const onRange = e.target instanceof HTMLInputElement && e.target.type === 'range';
    const onButton = e.target.closest('button');
    const key = e.key.length === 1 ? e.key.toLowerCase() : e.key;
    let handled = true;
    switch (key) {
      case ' ':
      case 'k':
        if (onButton && key === ' ') { handled = false; break; }
        togglePlay();
        break;
      case 'ArrowLeft': if (onRange) { handled = false; break; } seekBy(-SEEK_STEP); break;
      case 'ArrowRight': if (onRange) { handled = false; break; } seekBy(SEEK_STEP); break;
      case 'j': seekBy(-SEEK_STEP_LONG); break;
      case 'l': seekBy(SEEK_STEP_LONG); break;
      case 'ArrowUp': if (onRange) { handled = false; break; } setVolume((video.muted ? 0 : video.volume) + 0.1); break;
      case 'ArrowDown': if (onRange) { handled = false; break; } setVolume(video.volume - 0.1); break;
      case 'm': muteBtn.click(); break;
      case 'c': if (chapter().captions.length) { captionsOn = !captionsOn; applyCaptions(); } break;
      case 'f': toggleFullscreen(); break;
      case 'Home': if (onRange) { handled = false; break; } if (Number.isFinite(video.duration)) { video.currentTime = 0; } break;
      case 'End': if (onRange) { handled = false; break; } if (Number.isFinite(video.duration)) { video.currentTime = video.duration; } break;
      default: handled = false;
    }
    if (handled) { e.preventDefault(); showControls(); }
  });

  document.addEventListener('fullscreenchange', () => {
    const on = document.fullscreenElement === player;
    player.dataset.fullscreen = String(on);
    fsBtn.setAttribute('aria-label', on ? 'Exit full screen' : 'Enter full screen');
  });
  fsBtn.hidden = !canFullscreen;

  // ---- chapter selector ------------------------------------------------------
  tabs.forEach((tab, i) => {
    tab.addEventListener('click', () => selectChapter(i));
    // Warm the poster cache on intent (skipped when the visitor asked to save data).
    const warm = () => { if (!saveData && chapters[i].poster.src) { const img = new Image(); img.src = chapters[i].poster.src; } };
    tab.addEventListener('pointerenter', warm, { once: true });
    tab.addEventListener('focus', warm, { once: true });
  });
  tablist.addEventListener('keydown', (e) => {
    const keys = { ArrowDown: 1, ArrowRight: 1, ArrowUp: -1, ArrowLeft: -1 };
    let next = null;
    if (e.key in keys) next = (current + keys[e.key] + tabs.length) % tabs.length;
    else if (e.key === 'Home') next = 0;
    else if (e.key === 'End') next = tabs.length - 1;
    if (next === null) return;
    e.preventDefault();
    selectChapter(next, { focus: true });
  });
  const syncOrientation = () => tablist.setAttribute('aria-orientation', desktop.matches ? 'vertical' : 'horizontal');
  syncOrientation();
  desktop.addEventListener?.('change', syncOrientation);

  // ---- conversion links ----------------------------------------------------------
  // Visit links are [data-inquiry] links (the shared inquiry modal opens them); pause the film first.
  root.querySelectorAll('[data-life-visit]').forEach((link) => {
    link.addEventListener('click', () => video.pause());
  });
  const guide = root.querySelector('[data-life-guide]');
  if (guide && document.getElementById('careChatBackdrop')) {
    guide.hidden = false;
    guide.addEventListener('click', () => video.pause());
  }

  // ---- enhance: replace native controls with the custom bar --------------------
  video.removeAttribute('controls');
  player.dataset.controls = 'visible';
  player.dataset.muted = 'false';
  player.dataset.loading = 'false';
  player.dataset.fullscreen = 'false';
  render(0);
  current = 0;
}

function boot() {
  document.querySelectorAll('[data-life-gallery]').forEach(initLifeGallery);
}

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', boot);
} else {
  boot();
}
