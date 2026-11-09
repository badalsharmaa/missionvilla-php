@props(['seo' => [], 'headerVariant' => 'overlay'])
@php
    $site = config('missionvilla');
    $title = $seo['title'] ?? $site['name'];
    $description = $seo['description'] ?? '';
    $ogImage = isset($seo['og_image']) ? url($seo['og_image']) : null;
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    @if ($description)
        <meta name="description" content="{{ $description }}">
    @endif
    <link rel="canonical" href="{{ url()->current() }}">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="{{ $site['name'] }}">
    <meta property="og:title" content="{{ $title }}">
    @if ($description)
        <meta property="og:description" content="{{ $description }}">
    @endif
    @if ($ogImage)
        <meta property="og:image" content="{{ $ogImage }}">
    @endif
    <meta name="theme-color" content="#180F17">
    <link rel="icon" type="image/webp" href="{{ asset('images/brand/mission-villa-mark-160.webp') }}">

    {{-- Approved typography: Newsreader + Plus Jakarta Sans (same request as the approved hero prototype). --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Newsreader:ital,opsz,wght@0,6..72,400;0,6..72,500;0,6..72,600;1,6..72,400;1,6..72,500&family=Plus+Jakarta+Sans:wght@400;500;600&display=swap" rel="stylesheet">

    @stack('preload')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('section-assets')
</head>
<body class="site-body">
    <a href="#main" class="skip-link">Skip to main content</a>

    <x-site.header :variant="$headerVariant" />

    <main id="main" tabindex="-1">
        {{ $slot }}
    </main>
</body>
</html>
