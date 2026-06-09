<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'RentUs' }}</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&family=Arvo:wght@400;700&family=Bebas+Neue&display=swap" rel="stylesheet">
    <!-- FAVICONS ICON -->
    <link rel="shortcut icon" type="image/svg+xml" href="{{ asset('images/rentus.svg') }}">
    <!-- Style css -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <style>
        :root {
            --accent: #eab308;
            --glass-bg: rgba(255, 255, 255, 0.6);
            --glass-border: rgba(0, 0, 0, 0.08);
            --glass-blur: blur(12px);
        }

        body {
            font-family: 'Outfit', sans-serif !important;
            background-color: #fdfdfd;
            color: #0f172a;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
        }

        .public-header {
            background: #0a0a0a;
            padding: 1rem 5%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 2rem;
            flex-wrap: nowrap;
            width: 100%;
        }

        .public-footer {
            background: #ffffff;
            color: #475569;
            border-top: 1px solid rgba(0,0,0,0.08);
            text-align: center;
            padding: 3rem 5%;
            margin-top: auto;
            width: 100%;
        }

        /* Isolate public pages from admin dark-theme CSS */
        .public-page .card,
        .public-page .card-body,
        .public-page .card-header,
        .public-page .card-footer {
            background-color: #ffffff !important;
            color: #0f172a !important;
        }

        /* Pricing card accent override */
        .public-page .pricing-card,
        .public-page .pricing-card .card-body {
            background-color: #ffffff !important;
            color: #0f172a !important;
        }

        /* Prevent global CSS from stretching cards in columns */
        .card {
            height: auto !important;
        }

        /* Button for use on dark backgrounds (navbar) */
        .btn-outline-light {
            border: 1.5px solid rgba(255,255,255,0.5) !important;
            color: #fff !important;
            border-radius: 50px;
            padding: 0.5rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            white-space: nowrap;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: transparent;
        }

        .btn-outline-light:hover {
            background: var(--accent);
            border-color: var(--accent) !important;
            color: #000 !important;
        }

        /* Button for use on light backgrounds (cards, page body) */
        .btn-outline-dark {
            border: 1.5px solid #0f172a !important;
            color: #0f172a !important;
            border-radius: 50px;
            padding: 0.5rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            white-space: nowrap;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: transparent;
        }

        .btn-outline-dark:hover {
            background: var(--accent);
            border-color: var(--accent) !important;
            color: #000 !important;
        }



        main {
            flex-grow: 1;
        }



        {{ $styles ?? '' }}
    </style>
</head>
<body data-theme-version="light">
    <header class="public-header">
        <a href="{{ url('/') }}">
            <img src="{{ asset('images/rentus.png') }}" alt="RentUs Logo" style="height: 40px;">
        </a>
        <div class="d-flex gap-2">
            @auth
                <a href="{{ route('dashboard') }}" class="btn-outline-light">My Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="btn-outline-light">Log In</a>
            @endauth
        </div>
    </header>

    <main class="public-page">
        {{ $slot }}
    </main>

    <footer class="public-footer">
        <p>&copy; {{ date('Y') }} RentUS. All rights reserved.</p>
    </footer>

    <!-- Scripts -->
    <!-- Bootstrap 5 is bundled inside global.min.js; we need it for modals & carousels -->
    <script src="{{ asset('vendor/global/global.min.js') }}"></script>
    <script>
        // Force light theme immediately after global.min.js runs,
        // preventing dlabSettings from applying any stored dark theme from admin sessions.
        document.body.setAttribute('data-theme-version', 'light');
        // Also intercept dlabSettings so it can't re-apply dark theme later
        if (typeof dlabSettings !== 'undefined') {
            var _orig = dlabSettings.prototype.manageVersion;
            dlabSettings.prototype.manageVersion = function() {
                this.version = 'light';
                _orig.call(this);
            };
        }
    </script>
    {{ $scripts ?? '' }}
</body>
</html>
