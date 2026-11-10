@php
    /*
     * THE inquiry modal. Rendered once per page by the site layout.
     *
     * WEBSITE-WIDE RULE: any CTA whose destination is a form opens this modal
     * (never scrolls to a form). Mark it with data-inquiry="<intent>" (canonical
     * key or alias, see config/missionvilla.php → inquiries), optionally
     * data-inquiry-source="<section>" and data-inquiry-suite="private|shared",
     * and give it a tel: href as the no-JavaScript fallback.
     *
     * The fields come from the shared form (components/inquiry/form), the same
     * one the inline card in Section 07 renders. The heading, lede and submit
     * label follow the selected intent.
     *
     * Honesty rules (docs/INTEGRATION_PLAN.md):
     *  - store=false        → the form never posts and says "design preview, nothing was sent".
     *  - not connected      → the form posts and saves locally; the confirmation says it was
     *                         saved but NOT sent to Mission Villa's team.
     *  - destination wired  → confirmation says received (still not "delivered").
     */
    $site = config('missionvilla');
    $intents = $site['inquiries']['intents'];
    $copy = collect($intents)->map(fn ($i) => ['title' => $i['title'], 'lede' => $i['lede'], 'submit' => $i['submit']])->all();
    $first = array_key_first($intents);
@endphp
<dialog
  class="inquiry"
  id="inquiry-dialog"
  aria-labelledby="inquiry-title"
  aria-describedby="inquiry-lede"
  data-inquiry-dialog
  data-copy='@json($copy)'
  data-aliases='@json($site['inquiries']['intent_aliases'])'
>
  <div class="inquiry__card" data-inquiry-scope>
    <header class="inquiry__head">
      <div>
        <p class="inquiry__kicker">{{ $site['name'] }}</p>
        <h2 class="inquiry__title" id="inquiry-title" data-inquiry-title>{{ $copy[$first]['title'] }}</h2>
        <p class="inquiry__lede" id="inquiry-lede" data-inquiry-lede>{{ $copy[$first]['lede'] }}</p>
      </div>
      <button type="button" class="inquiry__close" data-inquiry-close aria-label="Close">
        @include('partials.icon', ['name' => 'x', 'class' => 'mv-icon', 'stroke' => 1.8])
      </button>
    </header>

    <div class="inquiry__body">
      <x-inquiry.form instance="modal" :intent="$first" />
    </div>
  </div>
</dialog>
