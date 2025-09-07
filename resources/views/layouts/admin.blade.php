<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>{{ $title ?? 'Admin Dashboard' }} - Winners Chapel International, Newport</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('assets/images/lfww_logo.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/lfww_logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('assets/images/lfww_logo.png') }}">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Open+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <!-- Toastr CSS -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
  @livewireStyles
  <style>
    :root {
      --primary-color: #e74c3c;
      --secondary-color: #c0392b;
      --accent-color: #e74c3c;
      --light-bg: #f8f9fa;
      --text-dark: #333;
      --navy-dark: #2c3e50;
      --white: #ffffff;
      --gray-100: #f8f9fa;
      --gray-200: #e9ecef;
      --gray-300: #dee2e6;
      --gray-400: #ced4da;
      --gray-500: #adb5bd;
      --gray-600: #6c757d;
      --gray-700: #495057;
      --gray-800: #343a40;
      --gray-900: #212529;
    }

    * {
      box-sizing: border-box;
    }

    body {
      font-family: 'Open Sans', sans-serif;
      background-color: var(--light-bg);
      overflow-x: hidden;
      margin: 0;
      padding: 0;
      color: var(--text-dark);
      font-size: 14px;
      line-height: 1.5;
    }

    /* Header Styles */
    .admin-header {
      background: linear-gradient(135deg, var(--navy-dark) 0%, var(--primary-color) 100%);
      height: 70px;
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      z-index: 1060;
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0 20px;
      box-shadow: 0 2px 20px rgba(0,0,0,0.15);
      backdrop-filter: blur(10px);
    }

    .brand-section {
      display: flex;
      align-items: center;
      color: white;
      text-decoration: none;
    }

    .brand-logo {
      width: 45px;
      height: 45px;
      margin-right: 12px;
      border-radius: 8px;
      object-fit: contain;
    }

    .brand-text {
      font-family: 'Playfair Display', serif;
      font-weight: 600;
      font-size: 1.4rem;
      color: white;
      margin: 0;
      line-height: 1.2;
    }

    .brand-subtitle {
      font-size: 0.75rem;
      opacity: 0.8;
      font-weight: 400;
    }

    /* Sidebar Styles */
    .sidebar {
      position: fixed;
      top: 70px;
      left: 0;
      width: 280px;
      height: calc(100vh - 70px);
      background: linear-gradient(180deg, var(--white) 0%, var(--gray-100) 100%);
      border-right: 1px solid var(--gray-200);
      z-index: 1050;
      transform: translateX(-100%);
      transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      box-shadow: 4px 0 20px rgba(0,0,0,0.08);
      overflow-y: auto;
      overflow-x: hidden;
    }

    .sidebar::-webkit-scrollbar {
      width: 4px;
    }

    .sidebar::-webkit-scrollbar-track {
      background: transparent;
    }

    .sidebar::-webkit-scrollbar-thumb {
      background: var(--gray-300);
      border-radius: 2px;
    }

    .sidebar.show {
      transform: translateX(0);
    }

    .sidebar-nav {
      padding: 20px 0;
    }

    .nav-section {
      margin-bottom: 32px;
    }

    .nav-section-title {
      font-size: 0.75rem;
      font-weight: 600;
      color: var(--gray-500);
      text-transform: uppercase;
      letter-spacing: 0.5px;
      padding: 0 24px 8px;
      margin-bottom: 8px;
    }

    .nav-item {
      margin: 2px 16px;
    }

    .nav-link {
      color: var(--text-dark);
      text-decoration: none;
      padding: 12px 20px;
      display: flex;
      align-items: center;
      border-radius: 12px;
      transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
      font-weight: 500;
      position: relative;
      overflow: hidden;
    }

    .nav-link:hover {
      background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
      color: white;
      transform: translateX(4px);
      box-shadow: 0 4px 12px rgba(231, 76, 60, 0.25);
    }

    .nav-link.active {
      background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
      color: white;
      box-shadow: 0 4px 12px rgba(231, 76, 60, 0.25);
    }

    .nav-link i {
      margin-right: 16px;
      width: 20px;
      text-align: center;
      font-size: 1.1rem;
    }

    .nav-link span {
      flex: 1;
      font-size: 0.9rem;
    }

    .badge {
      background: var(--primary-color);
      color: white;
      border-radius: 12px;
      padding: 2px 8px;
      font-size: 0.7rem;
      font-weight: 600;
    }

    /* Main Content */
    .main-content {
      margin-left: 0;
      margin-top: 70px;
      min-height: calc(100vh - 70px);
      transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .content-wrapper {
      padding: 32px;
    }

    .page-header {
      margin-bottom: 32px;
    }

    .page-title {
      font-family: 'Playfair Display', serif;
      font-size: 2.25rem;
      font-weight: 600;
      color: var(--navy-dark);
      margin: 0 0 8px 0;
      line-height: 1.2;
    }

    .page-subtitle {
      color: var(--gray-600);
      font-size: 1rem;
      margin: 0;
    }

    /* User Dropdown */
    .user-dropdown {
      position: relative;
    }

    .user-info {
      display: flex;
      align-items: center;
      padding: 8px 16px;
      border-radius: 50px;
      background: rgba(255,255,255,0.1);
      backdrop-filter: blur(10px);
      border: 1px solid rgba(255,255,255,0.2);
      color: white;
      text-decoration: none;
      transition: all 0.2s ease;
      cursor: pointer;
    }

    .user-info:hover {
      background: rgba(255,255,255,0.2);
      transform: translateY(-1px);
    }

    .user-avatar {
      width: 36px;
      height: 36px;
      border-radius: 50%;
      background: linear-gradient(135deg, rgba(255,255,255,0.2), rgba(255,255,255,0.1));
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: 600;
      font-size: 0.9rem;
      margin-right: 12px;
      border: 2px solid rgba(255,255,255,0.3);
    }

    .user-details {
      display: flex;
      flex-direction: column;
      margin-right: 8px;
    }

    .user-name {
      font-weight: 600;
      font-size: 0.9rem;
      line-height: 1;
      margin-bottom: 2px;
    }

    .user-role {
      font-size: 0.75rem;
      opacity: 0.8;
      line-height: 1;
    }

    .dropdown-menu {
      border: none;
      box-shadow: 0 10px 40px rgba(0,0,0,0.15);
      border-radius: 12px;
      padding: 8px;
      margin-top: 8px;
    }

    .dropdown-item {
      border-radius: 8px;
      padding: 12px 16px;
      font-size: 0.9rem;
      transition: all 0.2s ease;
    }

    .dropdown-item:hover {
      background: var(--light-bg);
      color: var(--text-dark);
    }

    .dropdown-divider {
      margin: 8px 0;
      border-color: var(--gray-200);
    }

    /* Mobile Toggle - Bootstrap Navbar Toggler Style */
    .navbar-toggler {
      padding: 0.25rem 0.5rem;
      font-size: 1rem;
      line-height: 1;
      background-color: rgba(255,255,255,0.1);
      border: 1px solid rgba(255,255,255,0.2);
      border-radius: 0.375rem;
      transition: all 0.2s ease;
      display: none;
    }

    .navbar-toggler:hover {
      background-color: rgba(255,255,255,0.2);
    }

    .navbar-toggler:focus {
      text-decoration: none;
      outline: 0;
      box-shadow: 0 0 0 0.25rem rgba(255, 255, 255, 0.25);
    }

    .navbar-toggler-icon {
      display: inline-block;
      width: 1.5em;
      height: 1.5em;
      vertical-align: middle;
      background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28255, 255, 255, 1%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
      background-repeat: no-repeat;
      background-position: center;
      background-size: 100%;
    }

    .sidebar-overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.6);
      z-index: 1045;
      opacity: 0;
      visibility: hidden;
      transition: opacity 0.3s ease, visibility 0.3s ease;
      backdrop-filter: blur(2px);
      pointer-events: none;
    }

    .sidebar-overlay.show {
      opacity: 1;
      visibility: visible;
      pointer-events: all;
    }

    /* Responsive Design */
    @media (min-width: 992px) {
      .sidebar {
        position: fixed;
        transform: translateX(0);
        z-index: 1030;
      }
      .main-content {
        margin-left: 280px;
      }
      .sidebar-overlay {
        display: none !important;
      }
      .navbar-toggler {
        display: none !important;
      }
    }

    @media (max-width: 991px) {
      .navbar-toggler {
        display: block;
      }
      .brand-text {
        font-size: 1.2rem;
      }
      .content-wrapper {
        padding: 24px 16px;
      }
      .page-title {
        font-size: 1.75rem;
      }
      .sidebar {
        z-index: 1060;
        box-shadow: 8px 0 30px rgba(0,0,0,0.15);
      }

      /* Prevent body scroll when sidebar is open on mobile */
      body.sidebar-open {
        overflow: hidden;
      }
    }    @media (max-width: 576px) {
      .admin-header {
        padding: 0 16px;
      }
      .brand-text {
        font-size: 1rem;
      }
      .user-details {
        display: none;
      }
      .content-wrapper {
        padding: 20px 12px;
      }
      .sidebar {
        width: 100vw;
        max-width: 320px;
      }
    }

    /* Utilities */
    .btn-primary-custom {
      background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
      border: none;
      color: white;
      transition: all 0.2s ease;
    }

    .btn-primary-custom:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 20px rgba(231, 76, 60, 0.3);
      color: white;
    }

    .card {
      border: none;
      border-radius: 16px;
      box-shadow: 0 4px 20px rgba(0,0,0,0.08);
      transition: all 0.2s ease;
    }

    .card:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 30px rgba(0,0,0,0.12);
    }

    /* Toastr Custom Styling */
    .toast-top-right {
      top: 60px; /* Account for fixed header height */
      right: 12px;
    }

    #toast-container > .toast {
      border-radius: 12px;
      box-shadow: 0 8px 25px rgba(0,0,0,0.15);
      backdrop-filter: blur(10px);
    }

    #toast-container > .toast-success {
      background-color: green;
    }

    #toast-container > .toast-error {
      background-color: red;
    }

    #toast-container > .toast-info {
      background-color: blue;
    }

    #toast-container > .toast-warning {
      background-color: orange;
    }

    @media (max-width: 576px) {
      .toast-top-right {
        top: 90px;
        right: 8px;
        left: 8px;
        width: auto !important;
      }

      #toast-container > .toast {
        margin: 0 0 8px 0;
        width: 100% !important;
      }
    }

    /* Bootstrap Pagination Custom Styling */
    .pagination {
      margin-bottom: 0;
    }

    .page-link {
      color: var(--primary-color);
      border: 1px solid var(--gray-300);
      border-radius: 8px !important;
      margin: 0 2px;
      font-size: 0.875rem;
      font-weight: 500;
      transition: all 0.2s ease;
    }

    .page-link:hover {
      color: white;
      background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
      border-color: var(--primary-color);
      transform: translateY(-1px);
      box-shadow: 0 4px 8px rgba(231, 76, 60, 0.25);
    }

    .page-link:focus {
      box-shadow: 0 0 0 0.25rem rgba(231, 76, 60, 0.25);
      border-color: var(--primary-color);
    }

    .page-item.active .page-link {
      background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
      border-color: var(--primary-color);
      color: white;
      box-shadow: 0 4px 8px rgba(231, 76, 60, 0.25);
    }

    .page-item.disabled .page-link {
      color: var(--gray-500);
      background-color: var(--gray-200);
      border-color: var(--gray-300);
    }

    /* Pagination responsive */
    @media (max-width: 576px) {
      .pagination {
        flex-wrap: wrap;
        justify-content: center;
      }

      .page-link {
        font-size: 0.8rem;
        padding: 0.375rem 0.5rem;
        margin: 1px;
      }
    }

    /* Livewire/Custom modal backdrop that must sit above fixed header */
    .admin-modal-backdrop {
      background-color: rgba(0, 0, 0, 0.5);
      z-index: 9999;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
    }
  </style>
</head>
<body>
  <!-- Header -->
  <header class="admin-header">
    <div class="brand-section">
      <button class="navbar-toggler d-lg-none me-3" type="button" onclick="toggleSidebar()" aria-controls="sidebar" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <a href="{{ route('admin.dashboard') }}" class="brand-section text-decoration-none">
        <img src="{{ asset('assets/images/lfww_logo.png') }}" alt="Logo" class="brand-logo" />
        <div>
          <div class="brand-text">WCI Newport</div>
          <div class="brand-subtitle">Admin Dashboard</div>
        </div>
      </a>
    </div>

    <div class="user-dropdown dropdown">
      <a href="#" class="user-info" data-bs-toggle="dropdown" aria-expanded="false">
        <div class="user-avatar">
          {{ strtoupper(substr(auth()->user()->firstname ?? 'U', 0, 1) . substr(auth()->user()->surname ?? 'U', 0, 1)) }}
        </div>
        <div class="user-details">
          <div class="user-name">{{ auth()->user()->firstname ?? 'User' }} {{ auth()->user()->surname ?? '' }}</div>
          <div class="user-role">Administrator</div>
        </div>
        <i class="fas fa-chevron-down"></i>
      </a>
      <ul class="dropdown-menu dropdown-menu-end">
        <li><a class="dropdown-item" href="{{ route('admin.profile') }}"><i class="fas fa-user me-2"></i>My Profile</a></li>
        <!--<li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i>Settings</a></li>-->
        <li><hr class="dropdown-divider"></li>
        <li>
          <form method="POST" action="{{ route('logout') }}" class="d-inline">
            @csrf
            <button type="submit" class="dropdown-item"><i class="fas fa-sign-out-alt me-2"></i>Logout</button>
          </form>
        </li>
      </ul>
    </div>
  </header>

  <!-- Sidebar Overlay -->
  <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

  <!-- Sidebar -->
  <aside class="sidebar" id="sidebar">
    <nav class="sidebar-nav">
      <!-- Dashboard Section -->
      <div class="nav-section">
        <div class="nav-section-title">Dashboard</div>
        <div class="nav-item">
          <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="fas fa-tachometer-alt"></i>
            <span>Overview</span>
          </a>
        </div>
      </div>

      <!-- Content Management -->
      <div class="nav-section">
        <div class="nav-section-title">Content Management</div>
        <div class="nav-item">
          <a href="{{ route('admin.sunday_service') }}" class="nav-link {{ request()->routeIs('admin.sunday_service') ? 'active' : '' }}">
            <i class="fas fa-calendar-alt"></i>
            <span>Sunday Services</span>
          </a>
        </div>
        <div class="nav-item">
          <a href="{{ route('admin.events') }}" class="nav-link {{ request()->routeIs('admin.events') ? 'active' : '' }}">
            <i class="fas fa-newspaper"></i>
            <span>News & Events</span>
          </a>
        </div>
        <div class="nav-item">
          <a href="{{ route('admin.wsf') }}" class="nav-link {{ request()->routeIs('admin.wsf') ? 'active' : '' }}">
            <i class="fas fa-users"></i>
            <span>WSF</span>
          </a>
        </div>
        <div class="nav-item">
          <a href="{{ route('admin.testimonies.manage') }}" class="nav-link {{ request()->routeIs('admin.testimonies*') ? 'active' : '' }}">
            <i class="fas fa-microphone"></i>
            <span>Testimonies</span>
          </a>
        </div>
      </div>

      <!-- User Management -->
      <div class="nav-section">
        <div class="nav-section-title">Users & Members</div>
        <div class="nav-item">
          <a href="{{ route('admin.users.manage') }}" class="nav-link {{ request()->routeIs('admin.users*') ? 'active' : '' }}">
            <i class="fas fa-users"></i>
            <span>Manage Users</span>
          </a>
        </div>
        <!--
        <div class="nav-item">
          <a href="#" class="nav-link">
            <i class="fas fa-user-plus"></i>
            <span>Add Member</span>
          </a>
        </div>
        <div class="nav-item">
          <a href="#" class="nav-link">
            <i class="fas fa-user-cog"></i>
            <span>Roles & Permissions</span>
          </a>
        </div>
        -->
      </div>

      <!-- Church Management -->
      <!--
      <div class="nav-section">
        <div class="nav-section-title">Church Operations</div>
        <div class="nav-item">
          <a href="#" class="nav-link">
            <i class="fas fa-calendar-week"></i>
            <span>Service Schedule</span>
          </a>
        </div>
        <div class="nav-item">
          <a href="#" class="nav-link">
            <i class="fas fa-donate"></i>
            <span>Donations</span>
          </a>
        </div>
        <div class="nav-item">
          <a href="#" class="nav-link">
            <i class="fas fa-envelope"></i>
            <span>Communications</span>
          </a>
        </div>
      </div>
      -->

      <!-- System -->
      <!--
      <div class="nav-section">
        <div class="nav-section-title">System</div>
        <div class="nav-item">
          <a href="#" class="nav-link">
            <i class="fas fa-cog"></i>
            <span>Settings</span>
          </a>
        </div>
        <div class="nav-item">
          <a href="#" class="nav-link">
            <i class="fas fa-chart-bar"></i>
            <span>Analytics</span>
          </a>
        </div>
      </div>
      -->
    </nav>
  </aside>

  <!-- Main Content -->
  <main class="main-content">
    <div class="content-wrapper">

      @hasSection('page-header')
        <div class="page-header">
          <h1 class="page-title">@yield('title', $title ?? 'Dashboard')</h1>
          <p class="page-subtitle">@yield('subtitle', $subtitle ?? 'Welcome back to your admin dashboard')</p>
        </div>
      @endif

      @isset($slot)
        {{ $slot }}
      @else
        @yield('content')
      @endisset
      @yield('content')
    </div>
  </main>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
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

  @livewireScripts

  <script>
    function toggleSidebar() {
      const sidebar = document.getElementById('sidebar');
      const overlay = document.getElementById('sidebarOverlay');
      const body = document.body;

      const isOpen = sidebar.classList.contains('show');

      if (isOpen) {
        closeSidebar();
      } else {
        openSidebar();
      }
    }

    function openSidebar() {
      const sidebar = document.getElementById('sidebar');
      const overlay = document.getElementById('sidebarOverlay');
      const body = document.body;

      sidebar.classList.add('show');
      overlay.classList.add('show');
      body.classList.add('sidebar-open');
    }

    function closeSidebar() {
      const sidebar = document.getElementById('sidebar');
      const overlay = document.getElementById('sidebarOverlay');
      const body = document.body;

      sidebar.classList.remove('show');
      overlay.classList.remove('show');
      body.classList.remove('sidebar-open');
    }

    // Close sidebar when clicking on overlay
    document.addEventListener('DOMContentLoaded', function() {
      const overlay = document.getElementById('sidebarOverlay');
      const sidebar = document.getElementById('sidebar');

      // Click overlay to close
      overlay.addEventListener('click', function(e) {
        if (e.target === overlay) {
          closeSidebar();
        }
      });

      // Click outside sidebar to close (additional safety)
      document.addEventListener('click', function(e) {
        if (window.innerWidth < 992) {
          const isClickInsideSidebar = sidebar.contains(e.target);
          const isClickOnToggle = e.target.closest('.navbar-toggler');
          const isSidebarOpen = sidebar.classList.contains('show');

          if (isSidebarOpen && !isClickInsideSidebar && !isClickOnToggle) {
            closeSidebar();
          }
        }
      });      // Auto-close sidebar on route change for mobile
      const navLinks = document.querySelectorAll('.sidebar .nav-link');
      navLinks.forEach(link => {
        link.addEventListener('click', function() {
          if (window.innerWidth < 992) {
            setTimeout(() => closeSidebar(), 150);
          }
        });
      });

      // Handle escape key
      document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && window.innerWidth < 992) {
          const isSidebarOpen = sidebar.classList.contains('show');
          if (isSidebarOpen) {
            closeSidebar();
          }
        }
      });
    });

    // Handle window resize
    window.addEventListener('resize', function() {
      if (window.innerWidth >= 992) {
        closeSidebar();
      }
    });

    // Prevent scroll when touch-moving on overlay
    document.addEventListener('touchmove', function(e) {
      const overlay = document.getElementById('sidebarOverlay');
      if (overlay.classList.contains('show') && e.target === overlay) {
        e.preventDefault();
      }
    }, { passive: false });
  </script>

  @stack('scripts')
</body>
</html>
