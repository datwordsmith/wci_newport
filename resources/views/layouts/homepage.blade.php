<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('description', 'Winners Chapel International Newport - Liberating the World through the Preaching of the Word of Faith')">
    <title>{{ $title ?? 'Winners Chapel International, Newport - Welcome Home' }}</title>

    @include('layouts.inc._meta')

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('assets/images/lfww_logo.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/lfww_logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('assets/images/lfww_logo.png') }}">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Open+Sans:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <style>

    </style>
</head>
<body>
    <!-- Top Navigation -->
    @include('layouts.inc._topnav')

    <!-- Main Navigation -->
    @include('layouts.inc._nav')


    <!-- Hero Section -->
    <section id="home" class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                @hasSection('hero-service-info')
                    <!-- Two-column layout when service exists -->
                    <div class="col-md-8">
                        <div class="hero-content animate-fade-in">
                            <!-- Show upcoming service info -->
                            @yield('hero-service-info')

                            <div class="mt-4">
                                <!-- Show dynamic service button -->
                                @yield('hero-service-button')
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="hero-poster text-center">
                            @yield('hero-service-poster')
                        </div>
                    </div>
                @else
                    <!-- Single column layout when no service -->
                    <div class="col-md-8">
                        <div class="hero-content animate-fade-in">
                            <!-- Show default church info when no upcoming service -->
                            <h3 class="serif-font">Winners Chapel International<br>Newport</h3>
                            <p>Liberating the World through the Preaching of the Word of Faith</p>

                            <div class="mt-4">
                                <!-- Default button when no service info -->
                                <a href="#services" class="btn btn-primary-custom me-3">Join us every Sunday | <small>10AM</small></a>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="mt-2">
                    <!-- Default button when no service info -->
                    <a href="#services" class="btn btn-primary-custom me-3">Join us every Sunday | <small>10AM</small></a>
                </div>
            </div>
        </div>
    </section>

    <!-- Action Cards Section -->
    @yield('action-cards')


    <!-- About Section -->
    <section id="about" class="about-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 mb-4 mb-md-0">
                    <div class="about-image">
                        <img src="{{ asset('assets/images/church.jpg') }}" alt="Welcome to Church" class="img-fluid rounded shadow" />
                    </div>
                </div>
                <div class="col-md-6">
                    <h2 class="serif-font mb-4">A Place of Liberation and Faith</h2>
                    <p class="lead mb-4">We are commissioned to liberate the world from all oppressions through the preaching of the Word of Faith. Here, broken destinies are restored and the infirmed receive healing.</p>
                    <p>Our ministry is built on the divine mandate to bring liberation to mankind in all facets of human existence. Through the Word of Faith, we witness testimonies of breakthrough, healing, prosperity, and spiritual transformation.</p>
                    <p>Whether you're seeking freedom from life's challenges, spiritual growth, or divine purpose, you'll find a community dedicated to triumphant living through faith. The Word of Faith is working like fire for liberation across the nations.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Programs Section -->
    @yield('programmes')

    <!-- Events Section -->
    @yield('events')

    <!-- Testimonies Hero Section -->
    <section class="testimonies-hero">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <i class="fas fa-heart testimonies-icon mb-4"></i>
                    <h2 class="serif-font mb-4">Share Your Story of Faith</h2>
                    <p class="lead mb-4">God is working miracles in our midst everyday. Your testimony could be the encouragement someone needs to believe.</p>
                    <div class="row g-3 justify-content-center">
                        <div class="col-md-5">
                            <a href="{{ route('testimonies') }}" class="btn btn-outline-light btn-md w-100">
                                <i class="fas fa-book-open me-2"></i>Read Testimonies
                            </a>
                        </div>
                        <div class="col-md-5">
                            <a href="{{ route('testimonies.create') }}" class="btn btn-primary-custom btn-md w-100 py-2">
                                <i class="fas fa-microphone me-2"></i>Share Your Testimony
                            </a>
                        </div>
                    </div>
                    <div class="mt-4">
                        <div id="testimonyVerses" class="carousel slide" data-bs-ride="carousel" data-bs-interval="4000">
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <p class="testimonies-verse mb-2">
                                        <i class="fas fa-quote-left me-2"></i>
                                        "Let the redeemed of the LORD tell their story—those he redeemed from the lands of the enemy."
                                    </p>
                                    <small class="verse-reference">- Psalm 107:2</small>
                                </div>
                                <div class="carousel-item">
                                    <p class="testimonies-verse mb-2">
                                        <i class="fas fa-quote-left me-2"></i>
                                        "Go home to your own people and tell them how much the Lord has done for you, and how he has had mercy on you."
                                    </p>
                                    <small class="verse-reference">- Mark 5:19</small>
                                </div>
                                <div class="carousel-item">
                                    <p class="testimonies-verse mb-2">
                                        <i class="fas fa-quote-left me-2"></i>
                                        "Come and hear, all you who fear God; let me tell you what he has done for me."
                                    </p>
                                    <small class="verse-reference">- Psalm 66:16</small>
                                </div>
                                <div class="carousel-item">
                                    <p class="testimonies-verse mb-2">
                                        <i class="fas fa-quote-left me-2"></i>
                                        "Always be prepared to give an answer to everyone who asks you to give the reason for the hope that you have."
                                    </p>
                                    <small class="verse-reference">- 1 Peter 3:15</small>
                                </div>
                            </div>
                            <div class="carousel-indicators testimony-indicators">
                                <button type="button" data-bs-target="#testimonyVerses" data-bs-slide-to="0" class="active" aria-label="Verse 1"></button>
                                <button type="button" data-bs-target="#testimonyVerses" data-bs-slide-to="1" aria-label="Verse 2"></button>
                                <button type="button" data-bs-target="#testimonyVerses" data-bs-slide-to="2" aria-label="Verse 3"></button>
                                <button type="button" data-bs-target="#testimonyVerses" data-bs-slide-to="3" aria-label="Verse 4"></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="get-in-touch">
        <div class="container">
                <div class="text-center my-5">
                    <h2 class="serif-font">Get In Touch</h2>
                    <p class="lead">We'd love to hear from you and welcome you to church</p>
                </div>
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="contact-card text-center">
                            <div class="contact-icon mx-auto">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <p>Winners Chapel Int'l<br>Church Rd, Newport<br>NP19 7EJ</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="contact-card text-center">
                            <div class="contact-icon mx-auto">
                                <i class="fas fa-address-card"></i>
                            </div>
                            <p><i class="fas fa-phone me-2"></i>07901 024213<br>
                            <i class="fas fa-envelope me-2"></i>hello@winnerschapelnewport.org.uk</p>
                        </div>
                    </div>
                </div>
                <div class="row mt-5">
                    <div class="col-lg-12 text-center">
                        <div class="social-links mb-3">
                            <a href="https://www.facebook.com/61553737660932" aria-label="Facebook" target="_blank"><i class="fab fa-facebook-f"></i></a>
                            <a href="https://x.com/wcinewport" aria-label="Twitter" target="_blank"><i class="fab fa-twitter"></i></a>
                            <a href="https://www.instagram.com/wcinewport/" aria-label="Instagram" target="_blank"><i class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                </div>
        </div>
    </section>

    @yield('content')

    <!-- Footer -->
    @include('layouts.inc._footer')

    <!-- Cookie Consent Banner -->
    @include('layouts.inc._cookies')

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
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
</body>
</html>
