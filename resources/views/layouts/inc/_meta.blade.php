{{-- Open Graph / Facebook --}}
<meta property="og:type" content="website">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:title" content="{{ $title ?? config('app.name', 'WCI Newport') }}">
<meta property="og:description" content="@yield('description', 'Winners Chapel International Newport - Liberating the World through the Preaching of the Word of Faith')">
<meta property="og:image" content="@yield('og_image', asset('assets/images/lfww_logo.png'))">
<meta property="og:site_name" content="{{ config('app.name', 'WCI Newport') }}">

{{-- Twitter --}}
<meta property="twitter:card" content="summary_large_image">
<meta property="twitter:url" content="{{ url()->current() }}">
<meta property="twitter:title" content="{{ $title ?? config('app.name', 'WCI Newport') }}">
<meta property="twitter:description" content="@yield('description', 'Winners Chapel International Newport - Liberating the World through the Preaching of the Word of Faith')">
<meta property="twitter:image" content="@yield('og_image', asset('assets/images/lfww_logo.png'))">
