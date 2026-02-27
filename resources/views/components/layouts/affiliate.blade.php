<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'RentUs | Partner Dashboard' }}</title>
    
    <!-- Favicon icon -->
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/rentus.svg') }}">
    
    <link href="{{ asset('vendor/bootstrap-select/css/bootstrap-select.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/owl-carousel/owl.carousel.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('vendor/nouislider/nouislider.min.css') }}">
    
    <!-- Style css -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    
    <style>
        :root {
            --primary: #eab308;
            --primary-hover: #ca8a04;
            --accent: #eab308;
        }
        .brand-logo {
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            width: 100%;
            height: 100%;
            padding: 10px !important;
        }
        .logo-full {
            max-width: 180px;
            max-height: 50px;
            object-fit: contain;
        }
        
        /* Logo Scaling and Transition */
        .brand-logo img {
            transition: all 0.3s ease-in-out;
        }

        /* Shrink logo when sidebar is collapsed (mini) */
        #main-wrapper.menu-toggle .nav-header .brand-logo img {
            height: 35px !important;
            width: auto !important;
        }

        /* Full size when sidebar is NOT collapsed (expanded) */
        #main-wrapper:not(.menu-toggle) .nav-header .brand-logo img {
            height: 50px !important;
            width: auto !important;
        }

        /* Card Customization (iOS Style) */
        [data-theme-version="dark"] .card,
        [data-theme-version="dark"] .card-body,
        .card,
        .card-body {
            background-color: #ffffff !important;
            color: #0f172a !important;
            border-radius: 1.25rem !important;
            box-shadow: 0 0.25rem 0.5rem rgba(0, 0, 0, 0.05) !important;
            border: 1px solid rgba(0, 0, 0, 0.05) !important;
            transition: none !important;
            transform: none !important;
        }

        /* Ensure content area is light */
        [data-theme-version="dark"] .content-body,
        .content-body {
            background-color: #f8f9fa !important;
        }

        [data-theme-version="dark"] .card-title,
        [data-theme-version="dark"] .card-header,
        .card-title,
        .card-header {
            background-color: #ffffff !important;
            color: #0f172a !important;
            border-bottom: none !important;
            border-radius: 1.25rem 1.25rem 0 0 !important;
        }

        .card:hover {
            transform: none !important;
            box-shadow: 0 0.25rem 0.5rem rgba(0, 0, 0, 0.05) !important;
        }

        /* Sidebar Logout Positioning */
        .dlabnav-scroll {
            height: calc(100vh - 80px) !important;
            display: flex !important;
            flex-direction: column !important;
        }

        .sidebar-footer {
            margin-top: auto !important;
            padding: 1.5rem !important;
        }

        .logout-btn {
            border-radius: 0.75rem !important;
            font-weight: 500 !important;
            padding: 0.75rem !important;
            transition: all 0.2s ease !important;
        }

        .logout-btn:hover {
            background-color: #ff5e5e !important;
            color: white !important;
            border-color: #ff5e5e !important;
        }

        /* Hide text when sidebar is collapsed */
        [data-sidebar-style="compact"] .logout-btn span,
        [data-sidebar-style="mini"] .logout-btn span {
            display: none !important;
        }

        [data-sidebar-style="compact"] .logout-btn,
        [data-sidebar-style="mini"] .logout-btn {
            padding: 0.75rem 0 !important;
            width: 45px !important;
            margin: 0 auto !important;
        }

        /* Sidebar Active State Fix */
        .dlabnav .metismenu > li.mm-active > a {
            background-color: rgba(234, 179, 8, 0.15) !important;
            color: var(--primary) !important;
            border-radius: 0 0 1.5rem 0 !important;
            margin: 0;
        }
        
        .dlabnav .metismenu > li.mm-active > a i {
            color: var(--primary) !important;
        }

        .dlabnav .metismenu > li > a {
            transition: all 0.2s ease;
        }
    </style>
    {{ $styles ?? '' }}
</head>
<body data-theme-version="light">
    <div id="preloader">
        <div class="lds-ripple">
            <div></div>
            <div></div>
        </div>
    </div>

    <div id="main-wrapper">
        <x-admin.navbar />
        <x-affiliate.sidebar />
		
        <!-- Content body start -->
        <div class="content-body default-height">
            <div class="container-fluid">
                {{ $slot }}
            </div>
        </div>
        <!-- Content body end -->

        <!-- Footer start -->
        <div class="footer">
            <div class="copyright">
                <p>Copyright © Designed &amp; Developed by Intracode 2026</p>
            </div>
        </div>
        <!-- Footer end -->
    </div>

    <!-- Scripts -->
    <script src="{{ asset('vendor/global/global.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap-select/js/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('vendor/apexchart/apexchart.js') }}"></script>
    <script src="{{ asset('js/custom.min.js') }}"></script>
    <script src="{{ asset('js/dlabnav-init.js') }}"></script>
    {{ $scripts ?? '' }}
</body>
</html>
