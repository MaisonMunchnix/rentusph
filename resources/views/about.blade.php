<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>About Us | RentUs</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&family=Arvo:wght@400;700&family=Bebas+Neue&display=swap" rel="stylesheet">

	<!-- FAVICONS ICON -->
	<link rel="shortcut icon" type="image/svg+xml" href="{{ asset('images/rentus.svg') }}">
	<link href="{{ asset('vendor/bootstrap-select/css/bootstrap-select.min.css') }}" rel="stylesheet">
	<link href="{{ asset('vendor/owl-carousel/owl.carousel.css') }}" rel="stylesheet">
	<link rel="stylesheet" href="{{ asset('vendor/nouislider/nouislider.min.css') }}">
	
	<!-- Style css -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <!-- Custom Landing Page Enhancements -->
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
            letter-spacing: -0.01em;
        }

        h1, h2, h3, h4, h5, h6, 
        .section-title, .car-name, .step-title,
        .btn, .nav-links li a {
            font-family: 'Outfit', sans-serif !important;
        }

        .font-logo-slab {
            font-family: 'Arvo', serif !important;
            font-weight: 700;
        }

        .section-title {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 1rem;
        }

        /* --- Header & Navigation --- */
        .nav-header {
            background-color: #0a0a0a !important;
            width: 250px;
            border: none !important;
            box-shadow: none !important;
        }

        .header {
            background-color: #0a0a0a !important;
            padding-left: 250px;
            border: none !important;
            box-shadow: none !important;
        }

        .header-content {
            padding-left: 0;
        }

        .nav-links li a, 
        .navbar-nav .nav-link {
            color: rgba(255, 255, 255, 0.9) !important;
            transition: color 0.3s ease;
        }

        .nav-links li a:hover, 
        .navbar-nav .nav-link:hover {
            color: var(--accent) !important;
        }

        .header-cta-group {
            display: flex;
            align-items: center;
            gap: 1.25rem;
        }

        .header-cta-group .btn {
            white-space: nowrap;
        }

        .btn {
            padding: 0.6rem 1.75rem !important;
            border-radius: 50px !important;
            font-weight: 600 !important;
            transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1) !important;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-primary {
            background: var(--accent) !important;
            color: #000 !important;
            border: 1.5px solid var(--accent) !important;
            box-shadow: 0 4px 12px rgba(234, 179, 8, 0.2);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(234, 179, 8, 0.3);
            background: #facc15 !important;
        }

        .btn-outline {
            border: 1.5px solid rgba(255, 255, 255, 0.3) !important;
            color: #fff !important;
            background: transparent !important;
        }

        .btn-outline:hover {
            border-color: var(--accent) !important;
            color: #000 !important;
            background: var(--accent) !important;
            transform: translateY(-2px);
        }

        .header-left .nav-links a {
            position: relative;
            padding-bottom: 4px;
        }

        .header-left .nav-links a::after {
            content: '';
            position: absolute;
            bottom: 0; left: 0;
            width: 0; height: 2px;
            background: var(--accent);
            transition: width 0.3s ease;
        }

        .header-left .nav-links a:hover::after {
            width: 100%;
        }

        /* --- About Page Styles --- */
        .about-hero {
            background: linear-gradient(135deg, #0a0a0a 0%, #1a1a2e 100%);
            padding: 5rem 5%;
            text-align: center;
            color: #fff;
        }

        .about-hero .hero-badge {
            display: inline-block;
            background: rgba(234, 179, 8, 0.15);
            border: 1px solid var(--accent);
            color: var(--accent);
            padding: 0.35rem 1.2rem;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 600;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            margin-bottom: 1.5rem;
        }

        .about-hero h1 {
            font-size: clamp(2.5rem, 5vw, 4rem);
            font-weight: 800;
            margin-bottom: 1.25rem;
            line-height: 1.1;
        }

        .about-hero p {
            font-size: 1.15rem;
            color: rgba(255,255,255,0.7);
            max-width: 700px;
            margin: 0 auto;
            line-height: 1.8;
        }

        .about-section {
            padding: 5rem 5%;
        }

        .about-section:nth-child(even) {
            background: #f8fafc;
        }

        .section-label {
            font-size: 0.8rem;
            font-weight: 700;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            color: var(--accent);
            margin-bottom: 0.75rem;
        }

        .section-heading {
            font-size: clamp(1.8rem, 3vw, 2.5rem);
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 1.5rem;
            line-height: 1.2;
        }

        .about-text {
            font-size: 1.2rem;
            color: #475569;
            line-height: 1.9;
        }

        /* Vision / Mission cards */
        .vm-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
            margin-top: 2rem;
        }

        @media (max-width: 768px) {
            .vm-grid { grid-template-columns: 1fr; }
        }

        .vm-card {
            background: #fff;
            border-radius: 16px;
            padding: 2.5rem;
            box-shadow: 0 4px 24px rgba(0,0,0,0.06);
            border-top: 4px solid var(--accent);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .vm-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 32px rgba(0,0,0,0.1);
        }

        .vm-card h3 {
            font-size: 1.4rem;
            font-weight: 800;
            margin-bottom: 1rem;
            color: #0f172a;
        }

        .vm-card p, .vm-card ul {
            font-size: 1.15rem;
            color: #475569;
            line-height: 1.9;
            margin: 0;
            padding-left: 1.25rem;
        }

        /* Core Values */
        .values-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
            margin-top: 2rem;
        }

        @media (max-width: 992px) {
            .values-grid { grid-template-columns: repeat(2, 1fr); }
        }

        @media (max-width: 576px) {
            .values-grid { grid-template-columns: 1fr; }
        }

        .value-card {
            background: #fff;
            border-radius: 16px;
            padding: 2rem;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            display: flex;
            gap: 1rem;
            align-items: flex-start;
        }

        .value-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 28px rgba(0,0,0,0.09);
        }

        .value-letter {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            background: rgba(234, 179, 8, 0.12);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.6rem;
            font-weight: 800;
            color: var(--accent);
            flex-shrink: 0;
        }

        .value-body h4 {
            font-size: 1rem;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 0.4rem;
        }

        .value-body p {
            font-size: 1.05rem;
            color: #64748b;
            line-height: 1.7;
            margin: 0;
        }

        /* Services */
        .services-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 2rem;
            margin-top: 2rem;
        }

        @media (max-width: 768px) {
            .services-grid { grid-template-columns: 1fr; }
        }

        .service-card {
            background: #fff;
            border-radius: 16px;
            padding: 2rem 2.25rem;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
            border-left: 4px solid var(--accent);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .service-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 30px rgba(0,0,0,0.09);
        }

        .service-card-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1.25rem;
        }

        .service-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background: rgba(234, 179, 8, 0.12);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--accent);
            flex-shrink: 0;
        }

        .service-card h3 {
            font-size: 1.1rem;
            font-weight: 800;
            color: #0f172a;
            margin: 0;
        }

        .service-card ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .service-card ul li {
            font-size: 1.05rem;
            color: #475569;
            padding: 0.4rem 0;
            border-bottom: 1px solid #f1f5f9;
            display: flex;
            align-items: flex-start;
            gap: 0.5rem;
        }

        .service-card ul li:last-child {
            border-bottom: none;
        }

        .service-card ul li::before {
            content: '›';
            color: var(--accent);
            font-weight: 700;
            font-size: 1.1rem;
            line-height: 1.4;
            flex-shrink: 0;
        }

        /* Contact bar */
        .contact-bar {
            background: linear-gradient(135deg, #0a0a0a, #1a1a2e);
            color: #fff;
            padding: 3.5rem 5%;
            text-align: center;
        }

        .contact-bar h2 {
            font-size: 2rem;
            font-weight: 800;
            margin-bottom: 1.5rem;
        }

        .contact-items {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 2rem;
        }

        .contact-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 1.1rem;
            color: rgba(255,255,255,0.85);
        }

        .contact-item svg {
            color: var(--accent);
            flex-shrink: 0;
        }

        .contact-item a {
            color: rgba(255,255,255,0.85);
            text-decoration: none;
            transition: color 0.2s;
        }

        .contact-item a:hover { color: var(--accent); }

        /* --- Footer Polish --- */
        footer {
            background-color: #0a0a0a !important;
            color: rgba(255, 255, 255, 0.6);
            padding: 4rem 5% 2rem !important;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 1.5fr 1fr;
            gap: 3rem;
            margin-bottom: 3rem;
        }

        @media (max-width: 900px) {
            .footer-grid {
                grid-template-columns: 1fr 1fr;
            }
        }
        @media (max-width: 600px) {
            .footer-grid {
                grid-template-columns: 1fr;
            }
        }

        .footer-logo {
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
        }
        
        .footer-desc {
            line-height: 1.6;
            margin-bottom: 1.5rem;
            max-width: 500px;
            color: rgba(255, 255, 255, 0.8);
        }

        .footer-heading {
            color: #fff;
            font-family: 'Arvo', serif;
            font-size: 1.2rem;
            margin-bottom: 2rem;
            letter-spacing: 0.02em;
            font-weight: 600;
        }

        .footer-links {
            list-style: none;
            padding-left: 0;
        }

        .footer-links li {
            margin-bottom: 0.75rem;
        }

        .footer-links a {
            color: rgba(255, 255, 255, 0.7);
            transition: all 0.3s ease;
            font-weight: 400;
        }

        .footer-links a:hover {
            color: var(--accent);
            padding-left: 5px;
        }

        .footer-bottom {
            margin-top: 5rem;
            padding-top: 2rem;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
            text-align: center;
            font-size: 0.85rem;
            color: rgba(255, 255, 255, 0.5);
        }

        /* ---- Hero Headline ---- */
        .about-hero-headline {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.1rem;
            margin-bottom: 1.5rem;
            line-height: 1;
        }

        .hero-about-word {
            font-size: clamp(1.4rem, 3vw, 2rem);
            font-weight: 400;
            letter-spacing: 0.35em;
            text-transform: uppercase;
            color: #ffffff;
            text-shadow: 0 0 30px rgba(255,255,255,0.4), 0 2px 8px rgba(0,0,0,0.8);
            opacity: 0.92;
        }

        .hero-brand-name {
            font-size: clamp(3rem, 7vw, 5.5rem);
            font-weight: 800;
            color: var(--accent);
            text-shadow: 0 0 40px rgba(234,179,8,0.5), 0 4px 16px rgba(0,0,0,0.6);
            letter-spacing: -0.02em;
            line-height: 1;
            background: linear-gradient(135deg, #facc15 0%, #eab308 50%, #ca8a04 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* ---- Service Cards (new chip design) ---- */
        .svc-section { background: #f1f5f9 !important; }

        .svc-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.75rem;
            margin-top: 2rem;
        }

        @media (max-width: 768px) {
            .svc-grid { grid-template-columns: 1fr; }
        }

        .svc-card {
            background: #fff;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 4px 24px rgba(0,0,0,0.07);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .svc-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 16px 40px rgba(0,0,0,0.12);
        }

        .svc-card-band {
            background: var(--band, #1a1a2e);
            padding: 1.5rem 1.75rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            position: relative;
        }

        .svc-num {
            font-size: 0.7rem;
            font-weight: 800;
            letter-spacing: 0.1em;
            color: var(--accent);
            background: rgba(234,179,8,0.15);
            border: 1px solid rgba(234,179,8,0.35);
            border-radius: 8px;
            padding: 0.25rem 0.55rem;
            flex-shrink: 0;
        }

        .svc-band-icon {
            color: rgba(255,255,255,0.85);
            flex-shrink: 0;
        }

        .svc-card-band h3 {
            font-size: 1.05rem;
            font-weight: 700;
            color: #fff;
            margin: 0;
            line-height: 1.3;
        }

        .svc-body {
            padding: 1.5rem 1.75rem;
        }

        .svc-chips {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .svc-chip {
            display: inline-block;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            color: #334155;
            border-radius: 50px;
            padding: 0.3rem 0.85rem;
            font-size: 0.82rem;
            font-weight: 500;
            transition: background 0.2s, border-color 0.2s, color 0.2s;
            cursor: default;
        }

        .svc-chip:hover {
            background: rgba(234,179,8,0.1);
            border-color: var(--accent);
            color: #92400e;
        }

    </style>
</head>
<body>

    <!--**********************************
        Nav header start
    ***********************************-->
    <div class="nav-header">
        <a href="{{ url('/') }}" class="brand-logo" style="justify-content: flex-start; padding-left: 1.5rem;">
            <img src="{{ asset('images/rentus.png') }}" alt="RentUs Logo" style="height: 50px; width: auto; object-fit: contain;">
        </a>
    </div>
    <!--**********************************
        Nav header end
    ***********************************-->

    <!--**********************************
        Header start
    ***********************************-->
    <div class="header">
        <div class="header-content">
            <nav class="navbar navbar-expand" style="border: none !important; box-shadow: none !important;">
                <div class="collapse navbar-collapse justify-content-between">
                    <div class="header-left">
                        <ul class="nav-links flex-row d-md-flex d-none" style="list-style: none; gap: 2rem; margin-bottom: 0; padding-left: 1rem;">
                            <li><a href="{{ url('/') }}#fleet" style="font-weight: 600; font-size: 1.1rem;">Our Fleet</a></li>
                            <li><a href="{{ url('/') }}#properties" style="font-weight: 600; font-size: 1.1rem;">Properties</a></li>
                            <li><a href="{{ url('/') }}#how-it-works" style="font-weight: 600; font-size: 1.1rem;">How it Works</a></li>
                            <li><a href="{{ url('/') }}#footer" style="font-weight: 600; font-size: 1.1rem;">Reach Us</a></li>
                            <li><a href="{{ route('public.about') }}" style="font-weight: 600; font-size: 1.1rem;">About Us</a></li>
                        </ul>
                    </div>
                    <div class="header-right d-flex align-items-center">
                        <div class="header-cta-group ms-auto">
                            <a href="{{ route('register.affiliate') }}" class="btn btn-outline btn-sm">Be a Partner</a>
                            <a href="{{ route('register.customer') }}" class="btn btn-primary btn-sm">Register</a>
                            <a href="{{ route('login') }}" class="btn btn-outline btn-sm">Log in</a>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
    </div>
    <!--**********************************
        Header end
    ***********************************-->

    <div style="padding-top: 80px;"></div>

    <!-- Hero Banner -->
    <div class="about-hero">
        <div class="hero-badge">Est. 2020</div>
        <h1 class="about-hero-headline">
            <span class="hero-about-word">About</span>
            <span class="hero-brand-name">RENTUS PH</span>
        </h1>
        <p>A pioneering car and property rental company disrupting the rental industry with an asset-light model — turning idle assets into opportunity.</p>
    </div>

    <!-- Company Overview -->
    <section class="about-section">
        <div class="container-fluid p-0" style="max-width: 1100px; margin: 0 auto;">
            <div class="section-label">Company Overview</div>
            <h2 class="section-heading">Who We Are</h2>
            <p class="about-text">
                RENTUS PH is a pioneering car and property rental company in the Philippines. Started in 2020, the company has been serving customers for over five years and is now relaunching with a bold vision: to disrupt the rental industry and grow into a <strong>multi-million enterprise within the next two years</strong>.
            </p>
            <p class="about-text" style="margin-top: 1rem;">
                What sets RENTUS PH apart is its innovative approach. Instead of relying solely on owned assets, RENTUS PH <strong>manages and rents out idle vehicles and unused properties from private owners</strong>. This asset-light model enables rapid expansion, lowers operational costs, and generates steady passive income for property and vehicle partners.
            </p>
        </div>
    </section>

    <!-- Vision & Mission -->
    <section class="about-section">
        <div class="container-fluid p-0" style="max-width: 1100px; margin: 0 auto;">
            <div class="section-label">Direction & Purpose</div>
            <h2 class="section-heading">Vision &amp; Mission</h2>
            <div class="vm-grid">
                <div class="vm-card">
                    <h3>🎯 Our Vision</h3>
                    <p>To become the Philippines' most trusted, innovative, and customer-focused rental company — empowering individuals, families, and businesses with affordable mobility and housing solutions, while creating income opportunities for asset owners.</p>
                </div>
                <div class="vm-card">
                    <h3>🚀 Our Mission</h3>
                    <ul>
                        <li>To provide convenient, reliable, and affordable rentals that improve everyday living.</li>
                        <li>To maximize the value of underutilized assets by turning them into income-generating opportunities.</li>
                        <li>To deliver exceptional service and build lasting trust with both customers and partners.</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Core Values -->
    <section class="about-section">
        <div class="container-fluid p-0" style="max-width: 1100px; margin: 0 auto;">
            <div class="section-label">What We Stand For</div>
            <h2 class="section-heading">Core Values</h2>
            <div class="values-grid">
                <div class="value-card">
                    <div class="value-letter">R</div>
                    <div class="value-body">
                        <h4>Respect</h4>
                        <p>Valuing clients, partners, and communities by treating everyone with fairness and dignity.</p>
                    </div>
                </div>
                <div class="value-card">
                    <div class="value-letter">E</div>
                    <div class="value-body">
                        <h4>Excellence</h4>
                        <p>Striving for the highest standards in service.</p>
                    </div>
                </div>
                <div class="value-card">
                    <div class="value-letter">N</div>
                    <div class="value-body">
                        <h4>Novelty (Innovation)</h4>
                        <p>Embracing creativity and technology to offer smarter rental solutions.</p>
                    </div>
                </div>
                <div class="value-card">
                    <div class="value-letter">T</div>
                    <div class="value-body">
                        <h4>Transparency (Integrity)</h4>
                        <p>Upholding honesty and openness in all dealings.</p>
                    </div>
                </div>
                <div class="value-card">
                    <div class="value-letter">U</div>
                    <div class="value-body">
                        <h4>Unity (Partnership)</h4>
                        <p>Building win-win relationships with clients, partners, and communities.</p>
                    </div>
                </div>
                <div class="value-card">
                    <div class="value-letter">S</div>
                    <div class="value-body">
                        <h4>Sustainability</h4>
                        <p>Promoting a shared economy and responsible use of resources for lasting impact.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services -->
    <section class="about-section">
        <div class="container-fluid p-0" style="max-width: 1100px; margin: 0 auto;">
            <div class="section-label">What We Offer</div>
            <h2 class="section-heading">Our Services</h2>
            <div class="services-grid">

                <!-- 1. Mobility & Transportation -->
                <div class="service-card">
                    <div class="service-card-header">
                        <div class="service-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
                        </div>
                        <h3>Mobility &amp; Transportation Rentals</h3>
                    </div>
                    <ul>
                        <li>Car Rental Services – Daily/weekly, short &amp; long-term, self-drive &amp; chauffeur-driven, fleet solutions</li>
                        <li>Van &amp; Bus Rentals – Group travel, tours, and corporate transport</li>
                        <li>Luxury &amp; Specialty Vehicle Rentals – SUVs, limousines, sports cars for VIPs and events</li>
                        <li>Logistics Vehicle Rentals – Trucks, pick-ups, and delivery vans for SMEs &amp; e-commerce</li>
                    </ul>
                </div>

                <!-- 2. Real Estate & Space -->
                <div class="service-card">
                    <div class="service-card-header">
                        <div class="service-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                        </div>
                        <h3>Real Estate &amp; Space Rentals</h3>
                    </div>
                    <ul>
                        <li>Residential Rentals – Apartments, houses, condos</li>
                        <li>Commercial Rentals – Offices, function halls, event spaces</li>
                        <li>Vacation Homes &amp; Airbnb Management – For tourists and staycation seekers</li>
                        <li>Student Housing &amp; Dorm Rentals – Near universities and colleges</li>
                        <li>Co-living &amp; Co-working Spaces – Flexible work and living setups</li>
                        <li>Warehouse &amp; Storage Rentals – For SMEs and e-commerce inventory</li>
                        <li>Event &amp; Pop-up Spaces – For bazaars, markets, or brand activations</li>
                    </ul>
                </div>

                <!-- 3. Lifestyle & Leisure -->
                <div class="service-card">
                    <div class="service-card-header">
                        <div class="service-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><path d="M8 14s1.5 2 4 2 4-2 4-2"></path><line x1="9" y1="9" x2="9.01" y2="9"></line><line x1="15" y1="9" x2="15.01" y2="9"></line></svg>
                        </div>
                        <h3>Lifestyle &amp; Leisure Rentals</h3>
                    </div>
                    <ul>
                        <li>Event Equipment – Sound systems, lights, tents, chairs, catering gear</li>
                        <li>Party &amp; Celebration – Costumes, photo booths, party decorations</li>
                        <li>Sports &amp; Fitness – Gym equipment, bicycles, kayaks, surfboards</li>
                        <li>Luxury &amp; Lifestyle Items – Designer dresses, jewelry, luxury handbags</li>
                        <li>Travel &amp; Outdoor Gear – Camping gear, drones, cameras, GoPros</li>
                    </ul>
                </div>

                <!-- 4. Business & Professional -->
                <div class="service-card">
                    <div class="service-card-header">
                        <div class="service-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path></svg>
                        </div>
                        <h3>Business &amp; Professional Rentals</h3>
                    </div>
                    <ul>
                        <li>Office Equipment – Printers, copiers, laptops, projectors</li>
                        <li>Construction &amp; Industrial Equipment – Tools, scaffolding, heavy machinery</li>
                        <li>Medical Equipment – Wheelchairs, hospital beds, oxygen tanks</li>
                        <li>Tech Rentals – VR headsets, gaming consoles, computers for events</li>
                    </ul>
                </div>

            </div>
        </div>
    </section>


    <!-- Footer -->
    <footer>
        <div class="footer-grid">
            <div>
                <a href="{{ url('/') }}" class="brand-logo footer-logo" style="margin-bottom: 1rem; display: block;">
                    <img src="{{ asset('images/rentus.png') }}" alt="RentUs Logo" style="height: 45px; width: auto; object-fit: contain;">
                </a>
                <p class="footer-desc">Cars & Property Rental services. SEC registered to operate Cars, property & other rental services in the Philippines. Started operating as DTI 2019 in Batangas. A community (RENT-US) of rentals! Serving you anywhere you go!</p>
            </div>
            <div>
                <h4 class="footer-heading">Reach Us</h4>
                <ul class="footer-links" style="list-style: none; padding: 0;">
                    <li style="margin-bottom: 1rem; display: flex; align-items: flex-start; gap: 0.75rem;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: var(--accent); position: relative; top: 3px;"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                        <span>09150475208<br>09150475207</span>
                    </li>
                    <li style="margin-bottom: 1rem; display: flex; align-items: flex-start; gap: 0.75rem;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: var(--accent); position: relative; top: 3px;"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                        <span>rentusph@gmail.com</span>
                    </li>
                    <li style="margin-bottom: 1rem; display: flex; align-items: flex-start; gap: 0.75rem;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: var(--accent);"><circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path></svg>
                        <span>www.rentusph.com</span>
                    </li>
                </ul>
                <div style="margin-top: 1.5rem;">
                    <a href="{{ route('register.affiliate') }}" style="color: var(--accent); text-decoration: none; font-weight: 600; display: flex; align-items: center; gap: 0.5rem;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><polyline points="16 11 18 13 22 9"></polyline></svg>
                        Affiliate Program
                    </a>
                </div>
            </div>
        </div>
        <div id="footer" class="footer-bottom">
            <p>&copy; {{ date('Y') }} RentUS. All rights reserved.</p>
        </div>
    </footer>

    <!--**********************************
        Scripts
    ***********************************-->
    <script src="{{ asset('vendor/global/global.min.js') }}"></script>
	<script src="{{ asset('vendor/bootstrap-select/js/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('js/custom.min.js') }}"></script>
	<script src="{{ asset('js/dlabnav-init.js') }}"></script>
</body>
</html>
