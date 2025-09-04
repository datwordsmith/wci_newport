<nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top shadow main-nav">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="#">
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
                    <li class="nav-item"><a class="nav-link fw-semibold nav-link-custom {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}" onclick="closeOffcanvasAndNavigate('{{ route('about') }}')">About Us</a></li>
                    <li class="nav-item"><a class="nav-link fw-semibold nav-link-custom {{ request()->routeIs('events') ? 'active' : '' }}" href="{{ route('events') }}" onclick="closeOffcanvasAndNavigate('{{ route('events') }}')">Events</a></li>
                    <li class="nav-item"><a class="nav-link fw-semibold nav-link-custom {{ request()->routeIs('wsf') ? 'active' : '' }}" href="{{ route('wsf') }}" onclick="closeOffcanvasAndNavigate('{{ route('wsf') }}')">WSF</a></li>
                    <li class="nav-item"><a class="nav-link fw-semibold nav-link-custom {{ request()->routeIs('service_units') ? 'active' : '' }}" href="{{ route('service_units') }}" onclick="closeOffcanvasAndNavigate('{{ route('service_units') }}')">Service Units</a></li>
                    <li class="nav-item"><a class="nav-link fw-semibold nav-link-custom {{ request()->routeIs('testimonies') ? 'active' : '' }}" href="{{ route('testimonies') }}" onclick="closeOffcanvasAndNavigate('{{ route('testimonies') }}')">Testimonies</a></li>
                    <li class="nav-item"><a class="nav-link fw-semibold nav-link-custom {{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}" onclick="closeOffcanvasAndNavigate('{{ route('contact') }}')">Contact Us</a></li>
                </ul>
                <div class="mt-3 d-grid gap-2">
                    <a href="{{ route('contact') }}" class="btn btn-primary-custom btn-sm" onclick="closeOffcanvasAndNavigate('{{ route('contact') }}')">COVENANT HOUR OF PRAYER</a>
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
                <li class="nav-item"><a class="nav-link fw-semibold nav-link-custom {{ request()->routeIs('testimonies') ? 'active' : '' }}" href="{{ route('testimonies') }}">Testimonies</a></li>
                <li class="nav-item"><a class="nav-link fw-semibold nav-link-custom {{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}">Contact Us</a></li>
            </ul>
            <div class="d-flex gap-2 ms-1">
                <a href="{{ route('contact') }}" class="btn btn-primary-custom btn-sm"><small>COVENANT HOUR<br>MON-SAT 6-7AM</small></a>
            </div>
        </div>
    </div>
</nav>
