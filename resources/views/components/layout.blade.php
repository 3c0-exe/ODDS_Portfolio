@php
    $seoPages = config('seo.pages');
    $seoRoute = request()->route()?->getName();
    $seoPage = $seoPages[$seoRoute] ?? $seoPages['portfolio.index'];
    $seoBase = rtrim(config('seo.url'), '/');
    $seoCanonical = isset($seoPages[$seoRoute]) ? $seoBase . route($seoRoute, [], false) : null;
    $seoImage = $seoBase . config('seo.image');
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ $seoPage['description'] }}">
    <title>{{ $seoPage['title'] }}</title>
    @if($seoCanonical)
        <link rel="canonical" href="{{ $seoCanonical }}">
        <meta property="og:url" content="{{ $seoCanonical }}">
    @endif
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="{{ config('seo.site_name') }}">
    <meta property="og:title" content="{{ $seoPage['title'] }}">
    <meta property="og:description" content="{{ $seoPage['description'] }}">
    <meta property="og:image" content="{{ $seoImage }}">
    <meta property="og:image:type" content="image/png">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:alt" content="{{ config('seo.image_alt') }}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $seoPage['title'] }}">
    <meta name="twitter:description" content="{{ $seoPage['description'] }}">
    <meta name="twitter:image" content="{{ $seoImage }}">
    <meta name="twitter:image:alt" content="{{ config('seo.image_alt') }}">
    <script>
        if ('scrollRestoration' in history) {
            history.scrollRestoration = 'manual';
        }
        window.scrollTo(0, 0);
        if (window.location.hash) {
            history.replaceState(null, document.title, window.location.pathname + window.location.search);
        }
    </script>
    <link rel="icon" type="image/svg+xml" href="{{ asset('assets/img/ODDS_logo.svg') }}">
    <link rel="alternate icon" href="{{ asset('assets/img/ODDS_logo.svg') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:ital,wght@0,300..800;1,300..800&family=Krona+One&family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&family=Rokkitt:wght@700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body>
    @include('components.navbar')
    <div id="smooth-wrapper">
        <div id="smooth-content">
            <main>{{ $slot }}</main>
        </div>
    </div>
    @stack('modals')
    <x-contact-modal />
    @stack('scripts')
</body>
</html>
