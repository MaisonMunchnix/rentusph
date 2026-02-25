<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>RentUs | Premium Car Rental</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&display=swap" rel="stylesheet">

    <!-- Styles -->
    <style>
        :root {
            --bg-color: #f8fafc;
            --text-main: #0f172a;
            --text-muted: #64748b;
            --accent: #eab308; /* Yellow/Gold accent for a premium feel */
            --glass-bg: rgba(255, 255, 255, 0.6);
            --glass-border: rgba(0, 0, 0, 0.08);
            --glass-blur: blur(12px);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Outfit', sans-serif;
        }

        body {
            background-color: var(--bg-color);
            color: var(--text-main);
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
        }

        a {
            text-decoration: none;
            color: inherit;
            transition: color 0.3s ease;
        }

        nav {
            position: fixed;
            top: 0;
            width: 100%;
            padding: 1.5rem 5%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 100;
            background: rgba(248, 250, 252, 0.85);
            backdrop-filter: var(--glass-blur);
            border-bottom: 1px solid var(--glass-border);
        }

        .logo {
            font-size: 1.5rem;
            font-weight: 800;
            letter-spacing: 1px;
        }
        
        .logo span {
            color: var(--accent);
        }

        .nav-links {
            display: flex;
            gap: 2rem;
            align-items: center;
        }

        .nav-links a:not(.btn-primary):hover {
            color: var(--accent);
        }

        @media (max-width: 768px) {
            .nav-links {
                display: none; /* simple mobile hide for now */
            }
        }

        /* --- Buttons --- */
        .btn-primary {
            background-color: var(--accent);
            color: #000;
            padding: 0.75rem 1.5rem;
            border-radius: 50px;
            font-weight: 600;
            display: inline-block;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(234, 179, 8, 0.2);
        }
        
        .btn-outline {
            background: transparent;
            color: var(--text-main);
            padding: 0.75rem 1.5rem;
            border-radius: 50px;
            font-weight: 600;
            border: 1px solid var(--glass-border);
            display: inline-block;
            transition: all 0.3s ease;
            backdrop-filter: var(--glass-blur);
        }

        .btn-outline:hover {
            background: var(--glass-bg);
            border-color: rgba(0, 0, 0, 0.15);
        }

        /* --- Hero Section --- */
        .hero {
            position: relative;
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 0 5%;
            overflow: hidden;
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
            transform: scale(1.05); /* Slight zoom for image */
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
            background: linear-gradient(180deg, rgba(248,250,252,0.4) 0%, #f8fafc 100%);
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
            color: var(--text-muted);
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
            background-color: var(--bg-color);
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
            color: var(--text-muted);
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
            color: var(--text-muted);
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
            color: var(--text-main);
        }

        .car-price small {
            color: var(--text-muted);
            font-weight: 400;
        }

        /* --- How it Works --- */
        .how-it-works {
            padding: 6rem 5%;
            background: linear-gradient(0deg, #e2e8f0 0%, var(--bg-color) 100%);
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
            color: var(--text-muted);
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
            grid-template-columns: 2fr 1fr 1fr 1fr;
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
            margin-bottom: 1rem;
        }
        
        .footer-desc {
            color: var(--text-muted);
            line-height: 1.6;
            margin-bottom: 1.5rem;
            max-width: 300px;
        }

        .footer-heading {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
        }

        .footer-links {
            list-style: none;
        }

        .footer-links li {
            margin-bottom: 0.75rem;
        }

        .footer-links a {
            color: var(--text-muted);
        }

        .footer-links a:hover {
            color: var(--accent);
        }

        .footer-bottom {
            padding-top: 2rem;
            border-top: 1px solid var(--glass-border);
            text-align: center;
            color: var(--text-muted);
            font-size: 0.9rem;
        }

        .badge-auth {
            display: flex;
            gap: 1rem;
            align-items: center;
        }
    </style>
</head>
<body>

    <!-- Navigation -->
    <nav>
        <div class="logo">Rent<span>Us</span></div>
        <div class="nav-links">
            <a href="#fleet">Our Fleet</a>
            <a href="#how-it-works">How it Works</a>
            <a href="#about">About us</a>
        </div>
        <div class="badge-auth">
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/home') }}" class="btn-outline">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" style="color:var(--text-main); font-weight:600;">Log in</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn-primary">Sign up</a>
                    @endif
                @endif
            @endif
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <!-- Using a high quality Unsplash image of a bright luxury car -->
        <img src="https://images.unsplash.com/photo-1502877338535-766e1452684a?ixlib=rb-4.0.3&auto=format&fit=crop&w=2000&q=80" alt="Luxury Sports Car" class="hero-bg">
        <div class="hero-gradient"></div>
        
        <div class="hero-content">
            <h1 class="hero-title"> Experience<span>Rent Us</span> on the Road.</h1>
            <p class="hero-subtitle">Elevate your journey with our exclusive collection of premium vehicles. Uncompromised comfort, breathtaking performance.</p>
            <div class="hero-actions">
                <a href="#fleet" class="btn-primary">Reserve Now</a>
                <a href="#how-it-works" class="btn-outline">Learn More</a>
            </div>
        </div>
    </section>

    <!-- Featured Fleet -->
    <section id="fleet" class="fleet">
        <div class="section-header">
            <h2 class="section-title">The Premium Fleet</h2>
            <p class="section-subtitle">Select from our meticulously maintained range of high-end vehicles tailored for any occasion.</p>
        </div>

        <div class="fleet-grid">
            <!-- Car 1 -->
            <div class="car-card">
                <div class="car-image-container">
                    <div class="car-tag">Most Popular</div>
                    <img src="https://images.unsplash.com/photo-1611859328053-12fede78bd2a?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Porsche 911" class="car-image">
                </div>
                <h3 class="car-name">Porsche 911 Carrera</h3>
                <div class="car-specs">
                    <span>
                        <svg viewBox="0 0 24 24"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                        Auto
                    </span>
                    <span>
                        <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                        2 Seats
                    </span>
                    <span>
                        <svg viewBox="0 0 24 24"><path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path><polyline points="13 2 13 9 20 9"></polyline></svg>
                        Petrol
                    </span>
                </div>
                <div class="car-footer">
                    <div class="car-price">
                        <span>$290</span><small>/day</small>
                    </div>
                    <a href="#" class="btn-outline" style="padding: 0.5rem 1rem;">Book</a>
                </div>
            </div>

            <!-- Car 2 -->
            <div class="car-card">
                <div class="car-image-container">
                    <img src="https://images.unsplash.com/photo-1549317661-bd32c8ce0be2?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Mercedes S-Class" class="car-image">
                </div>
                <h3 class="car-name">Mercedes S-Class</h3>
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
                        Electric
                    </span>
                </div>
                <div class="car-footer">
                    <div class="car-price">
                        <span>$350</span><small>/day</small>
                    </div>
                    <a href="#" class="btn-outline" style="padding: 0.5rem 1rem;">Book</a>
                </div>
            </div>

            <!-- Car 3 -->
            <div class="car-card">
                <div class="car-image-container">
                    <div class="car-tag">New Arrival</div>
                    <img src="https://images.unsplash.com/photo-1503376712396-6e8e815e1978?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Range Rover" class="car-image">
                </div>
                <h3 class="car-name">Range Rover Velar</h3>
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
                        Hybrid
                    </span>
                </div>
                <div class="car-footer">
                    <div class="car-price">
                        <span>$210</span><small>/day</small>
                    </div>
                    <a href="#" class="btn-outline" style="padding: 0.5rem 1rem;">Book</a>
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
                <p class="step-desc">Browse our curated collection of luxury and sports vehicles to find your perfect match.</p>
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
                <div class="logo footer-logo">Rent<span>Us</span></div>
                <p class="footer-desc">Redefining luxury car rentals with uncompromised quality, exceptional service, and a passion for driving excellence.</p>
            </div>
            <div>
                <h4 class="footer-heading">Company</h4>
                <ul class="footer-links">
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">Careers</a></li>
                    <li><a href="#">Blog</a></li>
                    <li><a href="#">Contact</a></li>
                </ul>
            </div>
            <div>
                <h4 class="footer-heading">Support</h4>
                <ul class="footer-links">
                    <li><a href="#">Help Center</a></li>
                    <li><a href="#">Terms of Service</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                    <li><a href="#">FAQ</a></li>
                </ul>
            </div>
            <div>
                <h4 class="footer-heading">Locations</h4>
                <ul class="footer-links">
                    <li><a href="#">Manila</a></li>
                    <li><a href="#">Lipa</a></li>
                    <li><a href="#">Quezon</a></li>
                    <li><a href="#">Cavite</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; {{ date('Y') }} RentUS Premium Rentals. All rights reserved.</p>
        </div>
    </footer>

</body>
</html>
