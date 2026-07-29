{{-- Open Graph / Facebook / WhatsApp --}}
<meta property="og:type" content="website">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:title" content="{{ $title ?? config('app.name', 'WCI Newport') }}">
<meta property="og:description" content="{{ $description ?? 'Winners Chapel International Newport - Liberating the World through the Preaching of the Word of Faith' }}">
<meta property="og:image" content="{{ $og_image ?? asset('assets/images/lfww_logo.png') }}">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<meta property="og:image:type" content="image/jpeg">
<meta property="og:site_name" content="{{ config('app.name', 'WCI Newport') }}">

{{-- WhatsApp / Schema.org Fallback --}}
<meta itemprop="name" content="{{ $title ?? config('app.name', 'WCI Newport') }}">
<meta itemprop="description" content="{{ $description ?? 'Winners Chapel International Newport - Liberating the World through the Preaching of the Word of Faith' }}">
<meta itemprop="image" content="{{ $og_image ?? asset('assets/images/lfww_logo.png') }}">

{{-- Twitter --}}
<meta property="twitter:card" content="summary_large_image">
<meta property="twitter:url" content="{{ url()->current() }}">
<meta property="twitter:title" content="{{ $title ?? config('app.name', 'WCI Newport') }}">
<meta property="twitter:description" content="{{ $description ?? 'Winners Chapel International Newport - Liberating the World through the Preaching of the Word of Faith' }}">
<meta property="twitter:image" content="{{ $og_image ?? asset('assets/images/lfww_logo.png') }}">
