<!-- Shared auth typography + tokens (aligns with landing page) -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&family=Arvo:wght@400;700&family=Bebas+Neue&display=swap" rel="stylesheet">

<style>
    :root {
        --accent: #eab308;
        --night: #0f172a;
        --ink: #0b1121;
        --muted: #94a3b8;
        --glass-bg: rgba(15, 23, 42, 0.6);
        --glass-border: rgba(255, 255, 255, 0.08);
        --field-bg: rgba(15, 23, 42, 0.4);
        --field-border: #334155;
        --field-focus: rgba(234, 179, 8, 0.12);
        --shadow-lg: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
    }

    body {
        font-family: 'Outfit', sans-serif;
        color: #f8fafc;
    }

    h1, h2, h3, h4, h5, h6 {
        font-family: 'Arvo', serif;
    }

    .auth-page {
        min-height: 100vh;
        background-color: var(--night);
        background-image:
            radial-gradient(at 0% 0%, rgba(234, 179, 8, 0.15) 0px, transparent 50%),
            radial-gradient(at 100% 100%, rgba(56, 189, 248, 0.08) 0px, transparent 50%),
            radial-gradient(at 100% 0%, rgba(15, 23, 42, 1) 0px, transparent 50%);
        position: relative;
        overflow: hidden;
    }

    .auth-page::before {
        content: '';
        position: absolute;
        inset: 0;
        background: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noiseFilter'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.65' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noiseFilter)'/%3E%3C/svg%3E");
        opacity: 0.03;
        pointer-events: none;
    }

    .auth-card {
        background: var(--glass-bg);
        border: 1px solid var(--glass-border);
        border-radius: 24px;
        padding: 3rem 2.5rem;
        box-shadow: var(--shadow-lg);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
    }

    .auth-logo {
        filter: drop-shadow(0 4px 6px rgba(0, 0, 0, 0.3));
    }

    .auth-title {
        color: #f8fafc;
        font-weight: 800;
        letter-spacing: -0.02em;
    }

    .auth-subtitle {
        color: var(--muted);
    }

    .form-label {
        color: #cbd5e1;
        font-weight: 600;
    }

    .form-control {
        background: var(--field-bg);
        border: 1px solid var(--field-border);
        color: #f1f5f9;
    }

    .form-control::placeholder {
        color: #475569;
    }

    .form-control:focus {
        border-color: var(--accent);
        box-shadow: 0 0 0 4px var(--field-focus);
        outline: none;
    }

    .btn-signup,
    .btn-primary,
    .btn-accent {
        background: linear-gradient(135deg, #facc15 0%, #eab308 100%);
        color: #451a03;
        font-weight: 700;
        border: none;
    }

    .btn-signup:hover,
    .btn-primary:hover,
    .btn-accent:hover {
        background: linear-gradient(135deg, #fde047 0%, #facc15 100%);
        color: #451a03;
    }

    .auth-footer-link a,
    .auth-link a,
    .card a {
        color: var(--accent);
    }
</style>
