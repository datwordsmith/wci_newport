<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('description', 'Winners Chapel International Newport - Liberating the World through the Preaching of the Word of Faith')">
    <title>{{ $title.' - Winners Chapel International, Newport' }}</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('assets/images/lfww_logo.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/lfww_logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('assets/images/lfww_logo.png') }}">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Open+Sans:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    @livewireStyles
    <style>

    </style>
</head>
<body>
    <!-- Top Navigation -->
    @include('layouts.inc._topnav')

    <!-- Main Navigation -->
    @include('layouts.inc._nav')


    <!-- Hero Section -->
    <section class="about-hero">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 text-center">
                    <h1 class="serif-font mt-5">{{$title}}</h1>
                    <p>@yield('description')</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Yield Content -->
    @yield('content')

    <!-- Footer -->
    @include('layouts.inc._footer')

    <!-- Cookie Consent Banner -->
    @include('layouts.inc._cookies')

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    @livewireScripts
    <script>
        // Smooth scrolling for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Add scroll effect to navbar
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 100) {
                navbar.classList.add('shadow-lg');
            } else {
                navbar.classList.remove('shadow-lg');
            }
        });

        // Animate elements on scroll
        function animateOnScroll() {
            const elements = document.querySelectorAll('.value-card, .event-card, .contact-card');
            const windowHeight = window.innerHeight;

            elements.forEach(element => {
                const elementTop = element.getBoundingClientRect().top;
                if (elementTop < windowHeight * 0.8) {
                    element.style.opacity = '1';
                    element.style.transform = 'translateY(0)';
                }
            });
        }

        // Set initial styles for animation
        document.querySelectorAll('.value-card, .event-card, .contact-card').forEach(element => {
            element.style.opacity = '0';
            element.style.transform = 'translateY(30px)';
            element.style.transition = 'all 0.6s ease';
        });

        window.addEventListener('scroll', animateOnScroll);
        window.addEventListener('load', animateOnScroll);

        // Cookie Consent Functions
        function acceptCookies() {
            localStorage.setItem('cookieConsent', 'accepted');
            document.getElementById('cookieConsent').style.display = 'none';
        }

        function declineCookies() {
            localStorage.setItem('cookieConsent', 'declined');
            document.getElementById('cookieConsent').style.display = 'none';
        }

        // Check if user has already made a choice
        window.addEventListener('load', function() {
            const cookieConsent = localStorage.getItem('cookieConsent');
            if (cookieConsent) {
                document.getElementById('cookieConsent').style.display = 'none';
            } else {
                // Show banner after 2 seconds
                setTimeout(function() {
                    document.getElementById('cookieConsent').style.display = 'block';
                }, 2000);
            }
        });
    </script>
    @stack('scripts')

    <!-- Global Modals -->
    @stack('modals')
</body>
</html>
