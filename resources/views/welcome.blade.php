<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>RentUs | Premium Car Rental</title>

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
        /* Maintain some specific rentusph variables just in case */
        :root {
            --accent: #eab308;
            --glass-bg: rgba(255, 255, 255, 0.6);
            --glass-border: rgba(0, 0, 0, 0.08);
            --glass-blur: blur(12px);
        }

        body {
            font-family: 'Outfit', sans-serif !important;
        }

        h1, h2, h3, h4, h5, h6, 
        .section-title, .car-name, .step-title,
        .btn, .nav-links li a {
            font-family: 'Outfit', sans-serif !important;
        }

        /* --- Layout & Sections --- */
        .hero {
            position: relative;
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 0 5%;
            overflow: hidden;
        }

        /* --- Logo-inspired Typography --- */
        .font-logo-slab {
            font-family: 'Arvo', serif !important;
            font-weight: 700;
        }

        .hero-title {
            font-size: clamp(3rem, 6vw, 5.5rem);
            line-height: 1.1;
            margin-bottom: 1.5rem;
            color: #fff;
            font-weight: 700;
        }

        .hero-title .text-rent {
            font-family: 'Arvo', serif !important;
            font-weight: 700;
        }

        .hero-title .text-explore {
            font-family: 'Arvo', serif !important;
            color: var(--accent);
            display: block;
            font-size: 0.9em;
            font-weight: 700;
            margin-top: 0.5rem;
        }

        .hero-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -2;
            opacity: 0.8;
            transform: scale(1.05);
            animation: slowZoom 20s infinite alternate linear;
        }

        @keyframes slowZoom {
            0% { transform: scale(1); }
            100% { transform: scale(1.1); }
        }

        .hero-gradient {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to bottom, rgba(0,0,0,0.4) 0%, rgba(0,0,0,0.7) 100%);
            z-index: -1;
        }

        .hero-content {
            max-width: 700px;
            margin-top: 5rem;
            animation: fadeUp 1s ease forwards;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .hero-title {
            font-size: clamp(3rem, 6vw, 5.5rem);
            font-weight: 800;
            line-height: 1.1;
            margin-bottom: 1.5rem;
        }

        .hero-title span {
            color: var(--accent);
            display: block;
        }

        .hero-subtitle {
            font-size: 1.125rem;
            color: #64748b;
            margin-bottom: 2.5rem;
            line-height: 1.6;
            max-width: 500px;
        }

        .hero-actions {
            display: flex;
            gap: 1rem;
        }

        /* --- Featured Fleet Section --- */
        .fleet {
            padding: 8rem 5%;
            position: relative;
        }

        .section-header {
            text-align: center;
            margin-bottom: 4rem;
        }

        .section-title {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 1rem;
        }

        .section-subtitle {
            font-size: 1.1rem;
            max-width: 600px;
            margin: 0 auto;
        }

        .fleet-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2.5rem;
        }

        .car-card {
            background: var(--glass-bg);
            border: 1px solid var(--glass-border);
            border-radius: 20px;
            padding: 1.5rem;
            backdrop-filter: var(--glass-blur);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }

        .car-card::before {
            content: '';
            position: absolute;
            top: 0; left: -100%;
            width: 50%; height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.6), transparent);
            transition: 0.5s;
            transform: skewX(-25deg);
        }

        .car-card:hover {
            transform: translateY(-10px);
            border-color: rgba(0, 0, 0, 0.15);
            background: rgba(255,255,255,0.9);
        }
        
        .car-card:hover::before {
            left: 150%;
        }

        .car-image-container {
            width: 100%;
            height: 200px;
            border-radius: 12px;
            overflow: hidden;
            margin-bottom: 1.5rem;
            position: relative;
        }

        .car-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .car-card:hover .car-image {
            transform: scale(1.08);
        }

        .car-tag {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: #0f172a;
            backdrop-filter: blur(4px);
            padding: 0.25rem 0.75rem;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--accent);
            border: 1px solid rgba(234, 179, 8, 0.5);
        }

        .car-name {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .car-specs {
            display: flex;
            justify-content: space-between;
            font-size: 0.9rem;
            margin-bottom: 1.5rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid var(--glass-border);
        }

        .car-specs span {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .car-specs svg {
            width: 16px;
            height: 16px;
            fill: none;
            stroke: currentColor;
            stroke-width: 2;
        }

        .car-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .car-price span {
            font-size: 1.25rem;
            font-weight: 800;
        }

        .car-price small {
            font-weight: 400;
        }

        /* --- How it Works --- */
        .how-it-works {
            padding: 6rem 5%;
            background: linear-gradient(0deg, #e2e8f0 0%, #f8fafc 100%);
        }

        .steps-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 3rem;
            margin-top: 4rem;
        }

        .step {
            text-align: center;
            position: relative;
        }

        .step-icon {
            width: 80px;
            height: 80px;
            background: var(--glass-bg);
            border: 1px solid var(--glass-border);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 2rem;
            color: var(--accent);
            transition: all 0.3s ease;
        }

        .step:hover .step-icon {
            background: rgba(234, 179, 8, 0.1);
            transform: scale(1.1);
            border-color: rgba(234, 179, 8, 0.3);
        }

        .step-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .step-desc {
            font-size: 0.95rem;
            line-height: 1.6;
        }

        /* --- Footer --- */
        footer {
            background-color: #f1f5f9;
            padding: 4rem 5% 2rem;
            border-top: 1px solid var(--glass-border);
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
        }

        .footer-heading {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
        }

        .footer-links {
            list-style: none;
            padding-left: 0;
        }

        .footer-links li {
            margin-bottom: 0.75rem;
        }

        .footer-links a:hover {
            color: var(--accent);
        }

        .footer-bottom {
            padding-top: 2rem;
            border-top: 1px solid var(--glass-border);
            text-align: center;
            font-size: 0.9rem;
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

        .btn-primary {
            background-color: var(--accent) !important;
            border-color: var(--accent) !important;
            color: #0a0a0a !important;
            font-weight: 600;
            padding: 0.75rem 2rem;
            border-radius: 50px;
            display: inline-block;
            transition: all 0.3s ease;
        }

        /* --- Premium Refinements --- */
        body {
            background-color: #fdfdfd; 
            color: #1a1a1a;
            letter-spacing: -0.01em;
        }

        /* CTA Buttons in Header - Simplified */
        .header-cta-group {
            display: flex;
            align-items: center;
            gap: 1.25rem;
        }

        .header-cta-group .btn {
            white-space: nowrap;
        }

        /* Refined Typography */
        .hero-title {
            font-size: clamp(3.5rem, 8vw, 6.5rem);
            font-weight: 800;
            letter-spacing: -0.03em;
        }

        .hero-subtitle {
            font-size: 1.25rem;
            font-weight: 400;
            color: rgba(255, 255, 255, 0.8) !important;
            max-width: 450px;
            border-left: 3px solid var(--accent);
            padding-left: 1.5rem;
            margin-top: 2rem;
        }

        /* Buttons Polish - Unified Language */
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
            background: #facc15 !important; /* Slightly brighter yellow on hover */
        }

        .btn-outline {
            border: 1.5px solid rgba(255, 255, 255, 0.3) !important;
            color: #fff !important;
            background: transparent !important;
        }

        .btn-outline:hover {
            border-color: var(--accent) !important;
            color: var(--accent) !important;
            background: rgba(234, 179, 8, 0.05) !important;
            transform: translateY(-2px);
        }

        /* Hover Navigation */
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

        /* --- Footer Polish --- */
        footer {
            background-color: #0a0a0a !important;
            color: rgba(255, 255, 255, 0.6);
            padding: 4rem 5% 2rem !important;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
        }

        .footer-heading {
            color: #fff;
            font-family: 'Arvo', serif;
            font-size: 1.2rem;
            margin-bottom: 2rem;
            letter-spacing: 0.02em;
        }

        .footer-links a {
            color: rgba(255, 255, 255, 0.5);
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
            color: rgba(255, 255, 255, 0.3);
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
                            <li><a href="#fleet" style="font-weight: 600; font-size: 1.1rem;">Our Fleet</a></li>
                            <li><a href="#properties" style="font-weight: 600; font-size: 1.1rem;">Properties</a></li>
                            <li><a href="#how-it-works" style="font-weight: 600; font-size: 1.1rem;">How it Works</a></li>
                            <li><a href="#footer" style="font-weight: 600; font-size: 1.1rem;">Reach Us</a></li>
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

    <!-- Hero Section -->
    <section class="hero">
        <!-- Using a high quality Unsplash image of a bright luxury car -->
        <img src="https://images.unsplash.com/photo-1502877338535-766e1452684a?ixlib=rb-4.0.3&auto=format&fit=crop&w=2000&q=80" alt="Luxury Sports Car" class="hero-bg">
        <div class="hero-gradient"></div>
        
        <div class="hero-content">
            <h1 class="hero-title" style="text-transform: none;"> 
                <span class="text-rent">Rent</span> Today,
                <span class="text-explore">Explore Tomorrow</span>
            </h1>
            <p class="hero-subtitle">Effortless Renting. Endless Possibilities</p>
            <div class="hero-actions">
                <a href="{{ route('register.customer') }}" class="btn btn-primary">Book Now</a>
                <a href="#how-it-works" class="btn btn-outline">Learn More</a>
            </div>
        </div>

    </section>

    <!-- Featured Fleet -->
    <section id="fleet" class="fleet">
        <div class="section-header">
            <h2 class="section-title">Our Premium Fleet</h2>
            <p class="section-subtitle">Choose from our reliable and well-maintained vehicles, perfect for Philippine roads and any travel need.</p>
        </div>

        <div class="fleet-grid">
            <!-- Car 1: Toyota Vios -->
            <div class="car-card">
                <div class="car-image-container">
                    <div class="car-tag">Most Popular</div>
                    <img src="https://imgcdn.zigwheels.ph/large/gallery/exterior/30/1943/toyota-vios-front-side-view-752875.jpg" alt="Toyota Vios" class="car-image">
                </div>
                <h3 class="car-name">Toyota Vios</h3>
                <div class="car-specs">
                    <span>
                        <svg viewBox="0 0 24 24"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                        Auto
                    </span>
                    <span>
                        <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                        5 Seats
                    </span>
                    <span>
                        <svg viewBox="0 0 24 24"><path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path><polyline points="13 2 13 9 20 9"></polyline></svg>
                        Petrol
                    </span>
                </div>
                <div class="car-footer">
                    <div class="car-price">
                        <span>₱1,800</span><small>/day</small>
                    </div>
                    <a href="#" class="btn btn-outline" style="padding: 0.5rem 1rem;">Book</a>
                </div>
            </div>

            <!-- Car 2: Toyota Innova -->
            <div class="car-card">
                <div class="car-image-container">
                    <div class="car-tag">Family Choice</div>
                    <img src="https://images.topgear.com.ph/topgear/images/2023/02/22/toyota-innova-facelift-2023-1677055189.jpg" alt="Toyota Innova" class="car-image">
                </div>
                <h3 class="car-name">Toyota Innova</h3>
                <div class="car-specs">
                    <span>
                        <svg viewBox="0 0 24 24"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                        Auto
                    </span>
                    <span>
                        <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                        8 Seats
                    </span>
                    <span>
                        <svg viewBox="0 0 24 24"><path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path><polyline points="13 2 13 9 20 9"></polyline></svg>
                        Diesel
                    </span>
                </div>
                <div class="car-footer">
                    <div class="car-price">
                        <span>₱3,500</span><small>/day</small>
                    </div>
                    <a href="#" class="btn btn-outline" style="padding: 0.5rem 1rem;">Book</a>
                </div>
            </div>

            <!-- Car 3: Mitsubishi Montero Sport -->
            <div class="car-card">
                <div class="car-image-container">
                    <div class="car-tag">Premium SUV</div>
                    <img src="https://upload.wikimedia.org/wikipedia/commons/1/19/Mitsubishi_Pajero_Sport_%283rd_generation%29_1X7A0409.jpg" alt="Mitsubishi Montero" class="car-image">
                </div>
                <h3 class="car-name">Mitsubishi Montero Sport</h3>
                <div class="car-specs">
                    <span>
                        <svg viewBox="0 0 24 24"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                        Auto
                    </span>
                    <span>
                        <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                        7 Seats
                    </span>
                    <span>
                        <svg viewBox="0 0 24 24"><path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path><polyline points="13 2 13 9 20 9"></polyline></svg>
                        Diesel
                    </span>
                </div>
                <div class="car-footer">
                    <div class="car-price">
                        <span>₱4,500</span><small>/day</small>
                    </div>
                    <a href="#" class="btn btn-outline" style="padding: 0.5rem 1rem;">Book</a>
                </div>
            </div>

            <!-- Car 4: Toyota Hiace GL Grandia -->
            <div class="car-card">
                <div class="car-image-container">
                    <div class="car-tag">Group Travel</div>
                    <img src="https://toyotasantarosa.com.ph/wp-content/uploads/2020/08/hiace18.jpg" alt="Toyota Hiace" class="car-image">
                </div>
                <h3 class="car-name">Toyota Hiace GL Grandia</h3>
                <div class="car-specs">
                    <span>
                        <svg viewBox="0 0 24 24"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                        Manual
                    </span>
                    <span>
                        <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                        12 Seats
                    </span>
                    <span>
                        <svg viewBox="0 0 24 24"><path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path><polyline points="13 2 13 9 20 9"></polyline></svg>
                        Diesel
                    </span>
                </div>
                <div class="car-footer">
                    <div class="car-price">
                        <span>₱5,500</span><small>/day</small>
                    </div>
                    <a href="#" class="btn btn-outline" style="padding: 0.5rem 1rem;">Book</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Property Rentals -->
    <section id="properties" class="fleet" style="background-color: #f8fafc;">
        <div class="section-header">
            <h2 class="section-title">Premier Stays</h2>
            <p class="section-subtitle">Discover our handpicked collection of premium properties, from modern urban condos to serene beachfront villas.</p>
        </div>

        <div class="fleet-grid">
            <!-- Property 1: Urban Condo -->
            <div class="car-card">
                <div class="car-image-container">
                    <div class="car-tag">City Living</div>
                    <img src="https://images.unsplash.com/photo-1512917774080-9991f1c4c750?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Modern Penthouse" class="car-image">
                </div>
                <h3 class="car-name">Skyline Executive Suite</h3>
                <div class="car-specs">
                    <span>
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                        Condo
                    </span>
                    <span>
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 20h20M2 14h20M2 8h20M2 2h20"></path></svg>
                        2 BR
                    </span>
                    <span>
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><path d="M12 8v4l3 3"></path></svg>
                        Fully Furnished
                    </span>
                </div>
                <div class="car-footer">
                    <div class="car-price">
                        <span>₱5,500</span><small>/night</small>
                    </div>
                    <a href="{{ route('register.customer') }}" class="btn btn-outline" style="padding: 0.5rem 1rem;">Book Stay</a>
                </div>
            </div>

            <!-- Property 2: Beachfront Villa -->
            <div class="car-card">
                <div class="car-image-container">
                    <div class="car-tag">Beach Escape</div>
                    <img src="https://images.unsplash.com/photo-1499793983690-e29da59ef1c2?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Beachfront Villa" class="car-image">
                </div>
                <h3 class="car-name">Azure Beachfront Villa</h3>
                <div class="car-specs">
                    <span>
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                        Villa
                    </span>
                    <span>
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 20h20M2 14h20M2 8h20M2 2h20"></path></svg>
                        4 BR
                    </span>
                    <span>
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2v20M5 5l7 7 7-7"></path></svg>
                        Private Pool
                    </span>
                </div>
                <div class="car-footer">
                    <div class="car-price">
                        <span>₱12,000</span><small>/night</small>
                    </div>
                    <a href="{{ route('register.customer') }}" class="btn btn-outline" style="padding: 0.5rem 1rem;">Book Stay</a>
                </div>
            </div>

            <!-- Property 3: Vacation Home -->
            <div class="car-card">
                <div class="car-image-container">
                    <div class="car-tag">Staycation</div>
                    <img src="https://images.unsplash.com/photo-1518780664697-55e3ad937233?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Vacation Home" class="car-image">
                </div>
                <h3 class="car-name">Serene Hilltop Retreat</h3>
                <div class="car-specs">
                    <span>
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                        House
                    </span>
                    <span>
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 20h20M2 14h20M2 8h20M2 2h20"></path></svg>
                        3 BR
                    </span>
                    <span>
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"></path></svg>
                        Scenic View
                    </span>
                </div>
                <div class="car-footer">
                    <div class="car-price">
                        <span>₱7,500</span><small>/night</small>
                    </div>
                    <a href="{{ route('register.customer') }}" class="btn btn-outline" style="padding: 0.5rem 1rem;">Book Stay</a>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works -->
    <section id="how-it-works" class="how-it-works">
        <div class="section-header">
            <h2 class="section-title">Seamless Experience</h2>
            <p class="section-subtitle">Getting behind the wheel of your dream car has never been simpler.</p>
        </div>

        <div class="steps-container">
            <div class="step">
                <div class="step-icon">
                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                </div>
                <h3 class="step-title">1. Choose Date & Time</h3>
                <p class="step-desc">Select your pickup and return dates according to your schedule. We offer flexible renting durations.</p>
            </div>
            <div class="step">
                <div class="step-icon">
                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
                </div>
                <h3 class="step-title">2. Select Your Car</h3>
                <p class="step-desc">Browse our diverse collection of reliable vehicles to find the best match for your journey.</p>
            </div>
            <div class="step">
                <div class="step-icon">
                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                </div>
                <h3 class="step-title">3. Book & Drive</h3>
                <p class="step-desc">Complete your reservation securely online, grab the keys, and enjoy the ultimate driving experience.</p>
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
                        <span>+63 915 047 5208<br>+63 915 0475 207<br>(043) 784-014</span>
                    </li>
                    <li style="margin-bottom: 1rem; display: flex; align-items: flex-start; gap: 0.75rem;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: var(--accent); position: relative; top: 3px;"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                        <span>rentusph@gmail.com</span>
                    </li>
                    <li style="display: flex; align-items: flex-start; gap: 0.75rem;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: var(--accent); position: relative; top: 3px;"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                        <span>0220, Batangas City, Philippines, 4200</span>
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
    <!-- Required vendors -->
    <script src="{{ asset('vendor/global/global.min.js') }}"></script>
	<script src="{{ asset('vendor/bootstrap-select/js/bootstrap-select.min.js') }}"></script>

	<!-- counter -->
	<script src="{{ asset('vendor/counter/counter.min.js') }}"></script>
	<script src="{{ asset('vendor/counter/waypoint.min.js') }}"></script>
	
	<!-- Apex Chart -->
	<script src="{{ asset('vendor/apexchart/apexchart.js') }}"></script>
	<script src="{{ asset('vendor/chart-js/chart.bundle.min.js') }}"></script>
	<!-- Chart piety plugin files -->
    <script src="{{ asset('vendor/peity/jquery.peity.min.js') }}"></script>
	
	<script src="{{ asset('vendor/owl-carousel/owl.carousel.js') }}"></script>
	
    <script src="{{ asset('js/custom.min.js') }}"></script>
	<script src="{{ asset('js/dlabnav-init.js') }}"></script>
	<script src="{{ asset('js/demo.js') }}"></script>
    <script src="{{ asset('js/styleSwitcher.js') }}"></script>
</body>
</html>
