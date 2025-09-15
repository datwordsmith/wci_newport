<nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top shadow main-nav">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="{{ route('homepage') }}">
            <img src="{{ asset('assets/images/lfww_logo.png') }}" alt="Logo" height="70" class="me-2">
            <div>
                <div class="brand-title">WINNERS CHAPEL INTERNATIONAL<br/>NEWPORT</div>
            </div>
        </a>
        <!-- Toggle button for offcanvas -->
        <button class="navbar-toggler d-md-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Offcanvas container (mobile only) -->
        <div class="offcanvas offcanvas-end d-md-none" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasNavbarLabel">WCI Newport</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link fw-semibold nav-link-custom {{ request()->routeIs('homepage') ? 'active' : '' }}" href="{{ route('homepage') }}" onclick="closeOffcanvasAndNavigate('{{ route('homepage') }}')">Home</a></li>
                    <li class="nav-item"><a class="nav-link fw-semibold nav-link-custom {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}" onclick="closeOffcanvasAndNavigate('{{ route('about') }}')">About</a></li>
                    <li class="nav-item"><a class="nav-link fw-semibold nav-link-custom {{ request()->routeIs('events') ? 'active' : '' }}" href="{{ route('events') }}" onclick="closeOffcanvasAndNavigate('{{ route('events') }}')">Events</a></li>
                    <li class="nav-item"><a class="nav-link fw-semibold nav-link-custom {{ request()->routeIs('wsf') ? 'active' : '' }}" href="{{ route('wsf') }}" onclick="closeOffcanvasAndNavigate('{{ route('wsf') }}')">WSF</a></li>
                    <li class="nav-item"><a class="nav-link fw-semibold nav-link-custom {{ request()->routeIs('service_units') ? 'active' : '' }}" href="{{ route('service_units') }}" onclick="closeOffcanvasAndNavigate('{{ route('service_units') }}')">Service Units</a></li>
                    <li class="nav-item"><a class="nav-link fw-semibold nav-link-custom {{ request()->routeIs('csr') ? 'active' : '' }}" href="{{ route('csr') }}" onclick="closeOffcanvasAndNavigate('{{ route('csr') }}')">CSR</a></li>
                    <li class="nav-item"><a class="nav-link fw-semibold nav-link-custom {{ request()->routeIs('testimonies') ? 'active' : '' }}" href="{{ route('testimonies') }}" onclick="closeOffcanvasAndNavigate('{{ route('testimonies') }}')">Testimonies</a></li>
                    <li class="nav-item"><a class="nav-link fw-semibold nav-link-custom {{ request()->routeIs('giving') ? 'active' : '' }}" href="{{ route('giving') }}" onclick="closeOffcanvasAndNavigate('{{ route('giving') }}')">Giving</a></li>
                    <li class="nav-item"><a class="nav-link fw-semibold nav-link-custom {{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}" onclick="closeOffcanvasAndNavigate('{{ route('contact') }}')">Contact Us</a></li>
                </ul>
                <div class="mt-3 d-grid gap-2">
                    <a href="https://teams.microsoft.com/dl/launcher/launcher.html?url=%2F_%23%2Fl%2Fmeetup-join%2F19%3Ameeting_YWEzNDNjZGItZTc0OS00Njc2LTgxY2ItMWU4MzE4OGU2OWFj%40thread.v2%2F0%3Fcontext%3D%257b%2522Tid%2522%253a%2522e82b49f6-c0ae-4b2c-8f1a-69a58a5b055e%2522%252c%2522Oid%2522%253a%2522f7f56369-1e3e-4fe9-8427-88286ecb3b86%2522%257d%26anon%3Dtrue&type=meetup-join&deeplinkId=1eb4fa50-030a-4995-b0bb-93c446c1df97&directDl=true&msLaunch=true&enableMobilePage=true&suppressPrompt=true" target="_blank" class="btn btn-primary-custom btn-sm">COVENANT HOUR OF PRAYER</a>
                </div>
            </div>
        </div>

        <!-- Regular menu (desktop only) -->
        <div class="navbar-collapse d-none d-md-flex" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link fw-semibold nav-link-custom {{ request()->routeIs('homepage') ? 'active' : '' }}" href="{{ route('homepage') }}">Home</a></li>
                <li class="nav-item"><a class="nav-link fw-semibold nav-link-custom {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">About Us</a></li>
                <li class="nav-item"><a class="nav-link fw-semibold nav-link-custom {{ request()->routeIs('events') ? 'active' : '' }}" href="{{ route('events') }}">Events</a></li>
                <li class="nav-item"><a class="nav-link fw-semibold nav-link-custom {{ request()->routeIs('wsf') ? 'active' : '' }}" href="{{ route('wsf') }}">WSF</a></li>
                <li class="nav-item"><a class="nav-link fw-semibold nav-link-custom {{ request()->routeIs('service_units') ? 'active' : '' }}" href="{{ route('service_units') }}">Service Units</a></li>
                <li class="nav-item"><a class="nav-link fw-semibold nav-link-custom {{ request()->routeIs('csr') ? 'active' : '' }}" href="{{ route('csr') }}">CSR</a></li>
                <li class="nav-item"><a class="nav-link fw-semibold nav-link-custom {{ request()->routeIs('testimonies') ? 'active' : '' }}" href="{{ route('testimonies') }}">Testimonies</a></li>
                <li class="nav-item"><a class="nav-link fw-semibold nav-link-custom {{ request()->routeIs('giving') ? 'active' : '' }}" href="{{ route('giving') }}">Giving</a></li>
                <li class="nav-item"><a class="nav-link fw-semibold nav-link-custom {{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}">Contact Us</a></li>
            </ul>
            <div class="d-flex gap-2 ms-1">
                <a href="https://teams.microsoft.com/dl/launcher/launcher.html?url=%2F_%23%2Fl%2Fmeetup-join%2F19%3Ameeting_YWEzNDNjZGItZTc0OS00Njc2LTgxY2ItMWU4MzE4OGU2OWFj%40thread.v2%2F0%3Fcontext%3D%257b%2522Tid%2522%253a%2522e82b49f6-c0ae-4b2c-8f1a-69a58a5b055e%2522%252c%2522Oid%2522%253a%2522f7f56369-1e3e-4fe9-8427-88286ecb3b86%2522%257d%26anon%3Dtrue&type=meetup-join&deeplinkId=1eb4fa50-030a-4995-b0bb-93c446c1df97&directDl=true&msLaunch=true&enableMobilePage=true&suppressPrompt=true" target="_blank" class="btn btn-primary-custom btn-sm"><small>COVENANT HOUR<br>MON-SAT 6-7AM</small></a>
            </div>
        </div>
    </div>
</nav>
