<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'RentUs | Admin Dashboard' }}</title>
    
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
        
        /* Navigation Styles from Welcome Page */
        .nav-links li a {
            position: relative;
            padding-bottom: 4px;
            transition: color 0.3s ease;
        }

        .nav-links li a::after {
            content: '';
            position: absolute;
            bottom: 0; left: 0;
            width: 0; height: 2px;
            background: var(--accent);
            transition: width 0.3s ease;
        }

        .nav-links li a:hover::after {
            width: 100%;
        }
        
        .nav-links li a:hover {
            color: var(--accent) !important;
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

        /* Ensure entire page and content area is white */
        body,
        #main-wrapper,
        [data-theme-version="dark"] .content-body,
        .content-body {
            background-color: #f8fafc !important; /* Slightly off-white for contrast */
        }

        /* Card Customization (iOS Style) - NO GRADIENTS */
        [data-theme-version="dark"] .card,
        [data-theme-version="dark"] .card-body,
        .card,
        .card-body {
            background: #ffffff !important;
            color: #0f172a !important;
            border-radius: 1.25rem !important;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05), 0 1px 2px rgba(0, 0, 0, 0.03) !important;
            border: 1px solid #f1f5f9 !important;
            transition: transform 0.2s ease, box-shadow 0.2s ease !important;
        }

        .card:hover {
            transform: translateY(-2px) !important;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03) !important;
        }

        /* Override any background gradients in cards or common elements */
        .card, .card-header, .btn, .badge, .progress-bar {
            background-image: none !important;
        }

        [data-theme-version="dark"] .card-title,
        [data-theme-version="dark"] .card-header,
        .card-title,
        .card-header {
            background-color: #ffffff !important;
            color: #0f172a !important;
            border-bottom: none !important; /* Removed divider */
            border-radius: 1.25rem 1.25rem 0 0 !important;
            padding: 1.25rem 1.5rem 0.5rem 1.5rem !important; /* Reduced bottom padding */
        }

        .footer {
            background-color: transparent !important;
            border-top: none !important;
        }

        /* Sidebar refinements */
        .dlabnav {
            background-color: #ffffff !important;
            box-shadow: 4px 0 10px rgba(0,0,0,0.02) !important;
        }

        /* Sidebar Active State Fix */
        .dlabnav .metismenu > li.mm-active > a {
            background-color: rgba(234, 179, 8, 0.1) !important;
            color: #854d0e !important; /* Darker yellow for contrast */
            border-radius: 0 2rem 2rem 0 !important;
            margin-right: 1rem;
            font-weight: 600;
        }
        
        .dlabnav .metismenu > li.mm-active > a i {
            color: var(--primary) !important;
        }

        /* Stats Typography */
        .fs-32 { font-size: 2rem !important; }
        .font-w700 { font-weight: 700 !important; }
        .text-success { color: #10b981 !important; }
        .text-warning { color: #f59e0b !important; }
        .text-danger { color: #ef4444 !important; }

        .dlabnav .metismenu > li > a {
            transition: all 0.2s ease;
        }
    </style>
    {{ $styles ?? '' }}
</head>
<body data-theme-version="light">
    <script>
        // Force light mode by clearing cookies and preventing JS overrides
        document.cookie = "version=light; path=/";
        localStorage.removeItem('version');
    </script>
    <div id="preloader">
        <div class="lds-ripple">
            <div></div>
            <div></div>
        </div>
    </div>

    <div id="main-wrapper">
        <x-admin.navbar />
        <x-admin.sidebar />
		
        <!-- Content body start -->
        <div class="content-body default-height">
            <div class="container-fluid">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="me-2"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        <strong>Success!</strong> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show">
                        <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="me-2"><polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2"></polygon><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                        <strong>Error!</strong> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"></button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show">
                        <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="me-2"><polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2"></polygon><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                        <strong>Error!</strong> Please check the form below for errors.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"></button>
                    </div>
                @endif
                
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
