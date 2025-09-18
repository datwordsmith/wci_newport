<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('description', 'Winners Chapel International Newport - Liberating the World through the Preaching of the Word of Faith')">
    <title>{{ $title.' - Winners Chapel International, Newport' }}</title>

    @include('layouts.inc._meta')

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('assets/images/lfww_logo.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/lfww_logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('assets/images/lfww_logo.png') }}">

    <link rel="preload" as="image" href="{{ asset('assets/images/hero_005.webp') }}" type="image/webp">
    <link rel="preload" as="image" href="{{ asset('assets/images/church.webp') }}" type="image/webp">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Open+Sans:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    <!-- Toastr CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
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
                <div class="col-md-8 text-center py-3">
                    <h4 class="serif-font">{{$title}}</h4>
                    <p class="small">@yield('description')</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Yield Content -->
    @yield('content')
    {{ $slot ?? '' }}

    <!-- Footer -->
    @include('layouts.inc._footer')

    <!-- Cookie Consent Banner -->
    @include('layouts.inc._cookies')

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        // Configure Toastr options
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };

        // Listen for Livewire events
        document.addEventListener('DOMContentLoaded', function() {
            // Success messages
            window.addEventListener('toastr-success', event => {
                toastr.success(event.detail.message || event.detail[0] || 'Success!');
            });

            // Error messages
            window.addEventListener('toastr-error', event => {
                toastr.error(event.detail.message || event.detail[0] || 'Something went wrong!');
            });

            // Info messages
            window.addEventListener('toastr-info', event => {
                toastr.info(event.detail.message || event.detail[0] || 'Information');
            });

            // Warning messages
            window.addEventListener('toastr-warning', event => {
                toastr.warning(event.detail.message || event.detail[0] || 'Warning!');
            });
        });
    </script>

    <script>
        // Function to handle offcanvas closing and navigation
        function closeOffcanvasAndNavigate(url) {
            // Get offcanvas element
            const offcanvasElement = document.getElementById('offcanvasNavbar');
            if (offcanvasElement) {
                // Get Bootstrap's offcanvas instance
                const offcanvasInstance = bootstrap.Offcanvas.getInstance(offcanvasElement);
                if (offcanvasInstance) {
                    // Hide the offcanvas
                    offcanvasInstance.hide();
                    // Listen for hidden.bs.offcanvas event
                    offcanvasElement.addEventListener('hidden.bs.offcanvas', function handler() {
                        // Navigate after the offcanvas is hidden
                        window.location.href = url;
                        // Remove the event listener to prevent memory leaks
                        offcanvasElement.removeEventListener('hidden.bs.offcanvas', handler);
                    });
                } else {
                    // If no instance is found, just navigate
                    window.location.href = url;
                }
            } else {
                // If offcanvas element not found, just navigate
                window.location.href = url;
            }
            // Prevent default link behavior
            return false;
        }
    </script>

    @livewireScripts
    <script>
        // Handle offcanvas navigation links properly
        document.addEventListener('DOMContentLoaded', function() {
            const offcanvasLinks = document.querySelectorAll('.offcanvas a[data-bs-dismiss="offcanvas"]');

            offcanvasLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    // Get the href attribute before preventing default
                    const href = this.getAttribute('href');

                    // Allow Bootstrap to handle the offcanvas dismiss first
                    setTimeout(function() {
                        // Navigate to the link after a slight delay
                        window.location.href = href;
                    }, 150);
                });
            });
        });

        // Smooth scrolling for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                // Skip if this is an offcanvas dismiss button or other Bootstrap functionality
                if (this.hasAttribute('data-bs-dismiss') || this.hasAttribute('data-bs-toggle')) {
                    return; // Let Bootstrap handle it
                }

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
