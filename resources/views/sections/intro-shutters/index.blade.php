@php /** @var array $data  Normalised by App\Content\Sections\IntroShuttersSection */ @endphp
@push('preload')
    {{-- Decide before first paint whether the intro plays (no flash of the page underneath).
         Skipped for prefers-reduced-motion and ?skipIntro=1, like the React reference.
         Safety: if the intro script never starts, the overlay is removed after 4s. --}}
    <script>
        (function () {
            var d = document.documentElement, q = new URLSearchParams(location.search);
            if (q.get('skipIntro') === '1' || window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
            d.classList.add('mv-intro-active');
            setTimeout(function () { if (!window.__mvIntroStarted) d.classList.remove('mv-intro-active'); }, 4000);
        })();
    </script>
    {{-- Shutter typography from the React reference: Allura (script) + Lora italic. --}}
    <link href="https://fonts.googleapis.com/css2?family=Allura&family=Lora:ital,wght@1,400&display=swap" rel="stylesheet">
@endpush
@push('section-assets')
    @vite(['resources/css/sections/intro-shutters.css', 'resources/js/sections/intro-shutters.js'])
@endpush
{{--
    OPENING SCENE — Signature two-panel French conservatory shutters.
    Ported from React components/ConservatoryShutters.tsx (classes and copy kept).
--}}
<div id="conservatory-shutters" class="fixed inset-0 z-[100] flex overflow-hidden" data-shutter-phase="closed" aria-hidden="true">
    {{-- Left Conservatory Shutter Panel --}}
    <div id="shutter-left" class="w-1/2 h-full bg-[#22122B] border-r border-[#D8C7A5]/30 flex flex-col justify-between p-6 sm:p-14 select-none">
        <span class="shutter-script text-3xl sm:text-4xl text-[#D8C7A5] shutter-fade">{{ $data['left_script'] }}</span>

        <div class="my-auto text-right pr-3 sm:pr-10 shutter-fade">
            <span class="text-[11px] sm:text-xs uppercase tracking-[0.3em] text-[#8FAF78] block mb-2">{{ $data['left_kicker'] }}</span>
            <span class="shutter-serif text-2xl sm:text-4xl lg:text-5xl text-[#F7F4ED] italic leading-tight block">{{ $data['left_tagline'] }}</span>
        </div>

        <span class="text-[10px] sm:text-[11px] uppercase tracking-[0.25em] text-[#F7F4ED]/55 shutter-fade">{{ $data['left_footer'] }}</span>
    </div>

    {{-- Right Conservatory Shutter Panel --}}
    <div id="shutter-right" class="w-1/2 h-full bg-[#22122B] flex flex-col justify-between p-6 sm:p-14 select-none">
        <span class="text-[10px] sm:text-xs uppercase tracking-[0.25em] text-[#D8C7A5] text-right shutter-fade">{{ $data['right_top'] }}</span>

        <div class="my-auto pl-3 sm:pl-10 shutter-fade">
            <span class="text-[11px] sm:text-xs uppercase tracking-[0.3em] text-[#C98268] block mb-2">{{ $data['right_kicker'] }}</span>
            <span class="shutter-serif text-2xl sm:text-4xl lg:text-5xl text-[#D8C7A5] italic leading-tight block">{{ $data['right_tagline'] }}</span>
        </div>

        <span class="text-[10px] sm:text-[11px] uppercase tracking-[0.25em] text-[#F7F4ED]/55 text-right shutter-fade">{{ $data['right_footer'] }}</span>
    </div>
</div>

{{-- Skip Intro (visible while shutters are closed/parting). Outside the aria-hidden overlay so it stays accessible. --}}
<button id="skip-intro-btn" type="button" aria-label="Skip Intro"
        class="fixed bottom-6 left-1/2 -translate-x-1/2 z-[110] px-5 py-2.5 rounded-full bg-[#F7F4ED]/15 hover:bg-[#F7F4ED] text-[#F7F4ED] hover:text-[#3B2348] border border-[#D8C7A5]/45 backdrop-blur-md text-xs font-medium tracking-wider uppercase transition-colors cursor-pointer focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#D8C7A5]">
    {{ $data['skip_label'] }}
</button>
