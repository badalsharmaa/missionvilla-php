{{--
    Generic page renderer: outputs each enabled, registered section in order.
    New approved sections need only a schema + view; this file never changes.
--}}
<x-layouts.site :seo="$page->seo">
    @foreach ($page->enabledSections() as $section)
        @include($registry->get($section->type)::view(), ['section' => $section, 'data' => $section->data])
    @endforeach
</x-layouts.site>
