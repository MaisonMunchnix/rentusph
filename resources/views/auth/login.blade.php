<!DOCTYPE html>
<html lang="en">

<head>
  <title>Login — RentUs</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="shortcut icon" type="image/svg+xml" href="{{ asset('images/rentus.svg') }}">
  <link href="{{ asset('vendor/bootstrap-select/css/bootstrap-select.min.css') }}" rel="stylesheet">
  <link href="{{ asset('css/style.css') }}" rel="stylesheet">
  @include('auth.partials.auth-head')

  <style>
    /* ── Reset fix-wrapper so we control the full layout ── */
    html,
    body {
      height: 100%;
      margin: 0;
      padding: 0;
      background: #0f172a;
    }

    .fix-wrapper {
      all: unset;
      display: block;
      width: 100%;
      height: 100%;
    }

    /* ══════════════════════════════════════
           SPLIT LAYOUT
        ══════════════════════════════════════ */
    .auth-split {
      display: flex;
      min-height: 100vh;
    }

    /* ── LEFT — Car Preview ── */
    .auth-left {
      width: 45%;
      flex-shrink: 0;
      position: relative;
      background: linear-gradient(135deg, #0f172a 0%, #060b14 100%);
      display: flex;
      flex-direction: column;
      justify-content: center;
      padding: 3rem 4rem;
      overflow: hidden;
    }

    /* Dynamic glow effects behind car */
    .auth-left::before {
      content: '';
      position: absolute;
      top: 10%;
      right: -10%;
      width: 500px;
      height: 500px;
      border-radius: 50%;
      background: radial-gradient(circle, rgba(234, 179, 8, 0.15) 0%, transparent 60%);
      pointer-events: none;
      filter: blur(40px);
    }

    .auth-left::after {
      content: '';
      position: absolute;
      bottom: -10%;
      left: -10%;
      width: 400px;
      height: 400px;
      border-radius: 50%;
      background: radial-gradient(circle, rgba(56, 189, 248, 0.08) 0%, transparent 60%);
      pointer-events: none;
      filter: blur(40px);
    }

    /* Back to homepage link */
    .auth-back {
      position: absolute;
      top: 2rem;
      left: 2.5rem;
      color: rgba(255, 255, 255, 0.6);
      font-size: 0.9rem;
      font-weight: 500;
      text-decoration: none;
      display: flex;
      align-items: center;
      gap: 0.5rem;
      transition: color 0.3s;
      z-index: 10;
    }

    .auth-back:hover {
      color: #eab308;
    }

    .badge-tag {
      position: relative;
      z-index: 1;
      display: inline-block;
      background: rgba(234, 179, 8, 0.15);
      border: 1px solid rgba(234, 179, 8, 0.3);
      color: #eab308;
      font-size: 0.75rem;
      font-weight: 700;
      letter-spacing: 0.1em;
      text-transform: uppercase;
      padding: 0.4rem 1rem;
      border-radius: 50px;
      margin-bottom: 1.5rem;
      width: fit-content;
      box-shadow: 0 4px 15px rgba(234, 179, 8, 0.1);
    }

    .car-preview-img {
      position: relative;
      z-index: 1;
      width: 100%;
      height: 240px;
      object-fit: cover;
      border-radius: 16px;
      margin-bottom: 2rem;
      box-shadow: 0 20px 50px rgba(0, 0, 0, 0.6);
      border: 1px solid rgba(255, 255, 255, 0.05);
    }

    .car-placeholder {
      position: relative;
      z-index: 1;
      width: 100%;
      height: 240px;
      background: rgba(255, 255, 255, 0.02);
      border: 1px dashed rgba(255, 255, 255, 0.1);
      border-radius: 16px;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 2rem;
      color: rgba(255, 255, 255, 0.1);
      font-size: 4rem;
    }

    .car-name {
      position: relative;
      z-index: 1;
      font-size: 2rem;
      font-weight: 800;
      color: #fff;
      margin: 0 0 0.5rem;
      letter-spacing: -0.02em;
    }

    .car-meta {
      position: relative;
      z-index: 1;
      display: flex;
      gap: 1.5rem;
      flex-wrap: wrap;
      font-size: 0.9rem;
      color: #94a3b8;
      margin-bottom: 2rem;
    }

    .car-meta span {
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }

    .car-meta svg {
      color: #eab308;
      opacity: 0.8;
    }

    .car-rate {
      position: relative;
      z-index: 1;
      font-size: 2.5rem;
      font-weight: 900;
      color: #eab308;
      line-height: 1;
      margin-bottom: 2rem;
      text-shadow: 0 4px 15px rgba(234, 179, 8, 0.2);
    }

    .car-rate small {
      font-size: 1.1rem;
      font-weight: 500;
      color: #64748b;
    }

    .intent-box {
      position: relative;
      z-index: 1;
      border-top: 1px solid rgba(255, 255, 255, 0.05);
      padding-top: 1.5rem;
      font-size: 0.9rem;
    }

    .intent-box strong {
      display: block;
      color: #f8fafc;
      font-weight: 600;
      margin-bottom: 0.25rem;
    }

    .intent-box span {
      color: #64748b;
    }

    /* ── RIGHT — Form ── */
    .auth-right {
      flex: 1;
      display: flex;
      align-items: center;
      justify-content: center;
      background: #0b1121;
      /* Dark theme for split side */
      padding: 2rem 3rem;
      position: relative;
      overflow-y: auto;
    }

    /* Subtle pattern */
    .auth-right::before {
      content: '';
      position: absolute;
      inset: 0;
      background-image: radial-gradient(rgba(255, 255, 255, 0.03) 1px, transparent 1px);
      background-size: 24px 24px;
      opacity: 0.5;
      pointer-events: none;
    }

    /* ══════════════════════════════════════
           NO-CAR DEFAULT: CENTERED LAYOUT
        ══════════════════════════════════════ */
    .auth-split.no-car {
      background: transparent;
      justify-content: center;
      align-items: center;
      position: relative;
      overflow: hidden;
    }

    .auth-split.no-car .auth-right {
      background: transparent;
      max-width: 550px;
      width: 100%;
      z-index: 10;
    }

    .auth-split.no-car .auth-right::before {
      display: none;
    }

    /* Form Box Styles */
    .auth-form-box {
      width: 100%;
      max-width: 480px;
      position: relative;
      z-index: 10;
    }

    .auth-split.no-car .auth-form-box {
      background: rgba(15, 23, 42, 0.6);
      backdrop-filter: blur(20px);
      -webkit-backdrop-filter: blur(20px);
      border: 1px solid rgba(255, 255, 255, 0.08);
      border-radius: 24px;
      padding: 3rem 2.5rem;
      box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5), 0 0 0 1px rgba(255, 255, 255, 0.02) inset;
      max-width: 100%;
    }

    .auth-logo {
      display: block;
      margin: 0 auto 2rem;
      height: 48px;
      width: auto;
      filter: drop-shadow(0 4px 6px rgba(0, 0, 0, 0.3));
    }

    .auth-title {
      font-size: 1.8rem;
      font-weight: 800;
      color: #f8fafc;
      margin-bottom: 0.5rem;
      text-align: center;
      letter-spacing: -0.03em;
    }

    .auth-subtitle {
      text-align: center;
      color: #94a3b8;
      font-size: 0.95rem;
      margin-bottom: 2.5rem;
    }

    /* Form fields */
    .auth-form-box .form-group {
      margin-bottom: 1.5rem;
    }

    .auth-form-box .form-label {
      font-size: 0.85rem;
      font-weight: 600;
      color: #cbd5e1;
      margin-bottom: 0.5rem;
      display: inline-block;
    }

    /* Input Wrappers */
    .input-wrapper {
      position: relative;
      display: flex;
      align-items: center;
    }

    .input-icon {
      position: absolute;
      left: 1rem;
      color: #64748b;
      font-size: 1.1rem;
      pointer-events: none;
      transition: color 0.3s;
    }

    .auth-form-box .form-control {
      width: 100%;
      border: 1px solid #334155;
      border-radius: 12px;
      padding: 0.8rem 1rem 0.8rem 2.75rem;
      font-size: 0.95rem;
      background: rgba(15, 23, 42, 0.4);
      color: #f1f5f9;
      transition: all 0.3s ease;
    }

    .auth-form-box .form-control::placeholder {
      color: #475569;
    }

    .auth-form-box .form-control:focus {
      border-color: #eab308;
      background: rgba(15, 23, 42, 0.8);
      box-shadow: 0 0 0 4px rgba(234, 179, 8, 0.1);
      outline: none;
    }

    .auth-form-box .form-control:focus+.input-icon {
      color: #eab308;
    }

    .show-pass {
      position: absolute;
      right: 1rem;
      top: 50%;
      transform: translateY(-50%);
      color: #64748b;
      cursor: pointer;
      transition: color 0.3s;
      font-size: 1.1rem;
      z-index: 5;
    }

    .show-pass:hover {
      color: #eab308;
    }

    .show-pass i.fa-eye {
      display: none;
    }

    .show-pass.active i.fa-eye {
      display: inline-block;
    }

    .show-pass.active i.fa-eye-slash {
      display: none;
    }

    /* Custom Checkbox */
    .custom-checkbox {
      display: flex;
      align-items: center;
      gap: 0.6rem;
      margin-top: 0.5rem;
    }

    .custom-checkbox input[type="checkbox"] {
      appearance: none;
      background-color: transparent;
      margin: 0;
      font: inherit;
      color: currentColor;
      width: 1.15em;
      height: 1.15em;
      border: 2px solid #475569;
      border-radius: 0.25em;
      display: grid;
      place-content: center;
      transition: all 0.2s ease-in-out;
      cursor: pointer;
    }

    .custom-checkbox input[type="checkbox"]::before {
      content: "";
      width: 0.65em;
      height: 0.65em;
      transform: scale(0);
      transition: 120ms transform ease-in-out;
      box-shadow: inset 1em 1em #0f172a;
      background-color: #0f172a;
      transform-origin: center;
      clip-path: polygon(14% 44%, 0 65%, 50% 100%, 100% 16%, 80% 0%, 43% 62%);
    }

    .custom-checkbox input[type="checkbox"]:checked {
      background-color: #eab308;
      border-color: #eab308;
    }

    .custom-checkbox input[type="checkbox"]:checked::before {
      transform: scale(1);
    }

    .custom-checkbox label {
      color: #cbd5e1;
      font-size: 0.9rem;
      cursor: pointer;
      user-select: none;
    }

    .forgot-password-link {
      font-size: 0.85rem;
      color: #94a3b8;
      text-decoration: none;
      font-weight: 500;
      transition: color 0.3s;
    }

    .forgot-password-link:hover {
      color: #eab308;
    }

    /* Primary Button CTA */
    .btn-signup {
      width: 100%;
      padding: 0.85rem;
      background: linear-gradient(135deg, #facc15 0%, #eab308 100%);
      color: #451a03;
      font-weight: 700;
      font-size: 1rem;
      border: none;
      border-radius: 12px;
      cursor: pointer;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      box-shadow: 0 4px 14px rgba(234, 179, 8, 0.25);
      margin-top: 1rem;
      display: flex;
      justify-content: center;
      align-items: center;
      gap: 0.5rem;
      position: relative;
      overflow: hidden;
    }

    /* Shine effect */
    .btn-signup::after {
      content: '';
      position: absolute;
      top: -50%;
      right: -50%;
      bottom: -50%;
      left: -50%;
      background: linear-gradient(to bottom, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, 0.4) 50%, rgba(255, 255, 255, 0) 100%);
      transform: rotateZ(60deg) translate(-5em, 7.5em);
      opacity: 0;
      transition: all 0.5s ease-out;
    }

    .btn-signup:hover::after {
      opacity: 1;
      transform: rotateZ(60deg) translate(1em, -9em);
    }

    .btn-signup:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 25px rgba(234, 179, 8, 0.4);
      color: #451a03;
    }

    .btn-signup:active {
      transform: translateY(0);
      box-shadow: 0 4px 10px rgba(234, 179, 8, 0.2);
    }

    .auth-footer-link {
      text-align: center;
      margin-top: 2rem;
      font-size: 0.9rem;
      color: #94a3b8;
      line-height: 1.6;
    }

    .auth-footer-link a {
      color: #eab308;
      font-weight: 600;
      text-decoration: none;
      transition: color 0.2s;
    }

    .auth-footer-link a:hover {
      color: #facc15;
      text-decoration: underline;
    }

    .alert-danger {
      background: rgba(239, 68, 68, 0.1);
      border: 1px solid rgba(239, 68, 68, 0.2);
      color: #fca5a5;
      border-radius: 12px;
      padding: 1rem;
      font-size: 0.85rem;
      margin-bottom: 1.5rem;
    }

    /* ── Responsive ── */
    @media (max-width: 768px) {
      .auth-split {
        flex-direction: column;
      }

      .auth-left {
        width: 100%;
        padding: 3rem 2rem;
        min-height: auto;
      }

      .auth-left::before,
      .auth-left::after {
        display: none;
      }

      .auth-right {
        padding: 3rem 1.5rem;
      }

      .auth-split.no-car .auth-form-box {
        padding: 2.5rem 1.5rem;
      }
    }
  </style>
</head>

<body class="auth-page">
  <div class="fix-wrapper">

    @if($selectedCar || isset($selectedProperty))
      {{-- ════ SPLIT LAYOUT ════ --}}
      <div class="auth-split">

        {{-- ── LEFT: Preview ── --}}
        <div class="auth-left">
          <a href="{{ url('/') }}" class="auth-back">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
              <polyline points="15 18 9 12 15 6" />
            </svg>
            Back to home
          </a>

          @if($selectedCar)
            <div class="badge-tag">{{ $selectedCar->brand }}</div>

            @if($selectedCar->image)
              <img src="{{ asset($selectedCar->image) }}" alt="{{ $selectedCar->brand }} {{ $selectedCar->model }}"
                class="car-preview-img">
            @else
              <div class="car-placeholder"><i class="fas fa-car"></i></div>
            @endif

            <h2 class="car-name">{{ $selectedCar->brand }} {{ $selectedCar->model }}</h2>

            <div class="car-meta">
              <span>
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6" />
                </svg>
                {{ $selectedCar->transmission }}
              </span>
              <span>
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                  <circle cx="9" cy="7" r="4" />
                </svg>
                {{ $selectedCar->capacity }} Seats
              </span>
              <span>
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z" />
                  <polyline points="13 2 13 9 20 9" />
                </svg>
                {{ $selectedCar->type }}
              </span>
            </div>

            <div class="car-rate">
              ₱{{ number_format($selectedCar->daily_rate, 2) }}
              <small>/day</small>
            </div>

            <div class="intent-box">
              <strong>You're about to book this car</strong>
              <span>Sign in to complete your reservation.</span>
            </div>
          @else
            <div class="badge-tag">{{ $selectedProperty->type }}</div>

            @if($selectedProperty->image)
              <img src="{{ asset($selectedProperty->image) }}" alt="{{ $selectedProperty->title }}"
                class="car-preview-img">
            @else
              <div class="car-placeholder"><i class="fas fa-home"></i></div>
            @endif

            <h2 class="car-name">{{ $selectedProperty->title }}</h2>

            <div class="car-meta">
              <span>
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                  <polyline points="9 22 9 12 15 12 15 22" />
                </svg>
                {{ $selectedProperty->bedrooms ?: 'N/A' }} Beds
              </span>
              <span>
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <path d="M21.54 15H17M17 15V19M17 15L21.5 19.5" />
                  <path d="M2.46 9H7M7 9V5M7 9L2.5 4.5" />
                  <rect x="7" y="9" width="10" height="10" />
                </svg>
                {{ $selectedProperty->bathrooms ?: 'N/A' }} Baths
              </span>
              <span>
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" />
                  <circle cx="12" cy="10" r="3" />
                </svg>
                {{ $selectedProperty->city }}
              </span>
            </div>

            <div class="car-rate">
              ₱{{ number_format($selectedProperty->monthly_rate, 2) }}
              <small>/{{ $selectedProperty->rate_type }}</small>
            </div>

            <div class="intent-box">
              <strong>You're about to book this stay</strong>
              <span>Sign in to complete your reservation.</span>
            </div>
          @endif
        </div>

        {{-- ── RIGHT: Login Form ── --}}
        <div class="auth-right">
          <div class="auth-form-box auth-card">
            <a href="{{ url('/') }}">
              <img src="{{ asset('images/rentus.png') }}" alt="RentUs" class="auth-logo">
            </a>
            <h1 class="auth-title">Welcome back</h1>
            <p class="auth-subtitle">Sign in to complete your booking</p>

            @if (session('status'))
              <div style="background:rgba(34,197,94,0.1);border:1px solid rgba(34,197,94,0.3);color:#86efac;border-radius:12px;padding:1rem;font-size:0.85rem;margin-bottom:1.5rem;">
                {{ session('status') }}
              </div>
            @endif
            @if($errors->any())
              <div class="alert-danger">
                <ul class="mb-0" style="padding-left:1rem;">
                  @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                </ul>
              </div>
            @endif

            <form action="{{ url('login') }}" method="POST">
              @csrf

              <div class="form-group">
                <label class="form-label" for="email">Email Address</label>
                <div class="input-wrapper">
                  <i class="fas fa-envelope input-icon"></i>
                  <input type="email" name="email" id="email" class="form-control" placeholder="hello@example.com"
                    required>
                </div>
              </div>

              <div class="form-group position-relative">
                <div class="d-flex justify-content-between align-items-center mb-2">
                  <label class="form-label mb-0" for="dlab-password">Password</label>
                  <a href="{{ url('forgot-password') }}" class="forgot-password-link">Forgot Password?</a>
                </div>
                <div class="input-wrapper">
                  <i class="fas fa-lock input-icon"></i>
                  <input type="password" name="password" id="dlab-password" class="form-control" placeholder="••••••••"
                    required>
                  <span class="show-pass"><i class="fa fa-eye-slash"></i><i class="fa fa-eye"></i></span>
                </div>
              </div>


              <button type="submit" class="btn-signup">
                Sign in
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                  stroke-linecap="round" stroke-linejoin="round">
                  <line x1="5" y1="12" x2="19" y2="12"></line>
                  <polyline points="12 5 19 12 12 19"></polyline>
                </svg>
              </button>
            </form>

            <p class="auth-footer-link">
              Don't have an account? <br>
              <a
                href="{{ route('register.customer', session('pending_car_id') ? ['car_id' => session('pending_car_id')] : (session('pending_property_id') ? ['property_id' => session('pending_property_id')] : [])) }}">Sign
                up as Customer</a> &nbsp;|&nbsp;
              <a href="{{ url('register/affiliate') }}">Sign up as Affiliate</a>
            </p>
          </div>
        </div>

      </div>

    @else
      {{-- ════ DEFAULT CENTERED LAYOUT (no car selected) ════ --}}
      <div class="auth-split no-car">
        <div class="auth-right">
          <div class="auth-form-box">
            <a href="{{ url('/') }}">
              <img src="{{ asset('images/rentus.png') }}" alt="RentUs" class="auth-logo">
            </a>
            <h1 class="auth-title">Welcome back</h1>
            <p class="auth-subtitle">Sign in to your account</p>

            @if (session('status'))
              <div style="background:rgba(34,197,94,0.1);border:1px solid rgba(34,197,94,0.3);color:#86efac;border-radius:12px;padding:1rem;font-size:0.85rem;margin-bottom:1.5rem;">
                {{ session('status') }}
              </div>
            @endif
            @if($errors->any())
              <div class="alert-danger">
                <ul class="mb-0" style="padding-left:1rem;">
                  @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                </ul>
              </div>
            @endif

            <form action="{{ url('login') }}" method="POST">
              @csrf

              <div class="form-group">
                <label class="form-label" for="email">Email Address</label>
                <div class="input-wrapper">
                  <i class="fas fa-envelope input-icon"></i>
                  <input type="email" name="email" id="email" class="form-control" placeholder="hello@example.com"
                    required>
                </div>
              </div>

              <div class="form-group position-relative">
                <div class="d-flex justify-content-between align-items-center mb-2">
                  <label class="form-label mb-0" for="dlab-password">Password</label>
                  <a href="{{ url('forgot-password') }}" class="forgot-password-link">Forgot Password?</a>
                </div>
                <div class="input-wrapper">
                  <i class="fas fa-lock input-icon"></i>
                  <input type="password" name="password" id="dlab-password" class="form-control" placeholder="••••••••"
                    required>
                  <span class="show-pass"><i class="fa fa-eye-slash"></i><i class="fa fa-eye"></i></span>
                </div>
              </div>


              <button type="submit" class="btn-signup">
                Sign in
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                  stroke-linecap="round" stroke-linejoin="round">
                  <line x1="5" y1="12" x2="19" y2="12"></line>
                  <polyline points="12 5 19 12 12 19"></polyline>
                </svg>
              </button>
            </form>

            <p class="auth-footer-link">
              Don't have an account? <br>
              <a href="{{ url('register/customer') }}">Sign up as Customer</a> &nbsp;|&nbsp;
              <a href="{{ url('register/affiliate') }}">Sign up as Affiliate</a>
            </p>
          </div>
        </div>
      </div>
    @endif

  </div>

  <script src="{{ asset('vendor/global/global.min.js') }}"></script>
  <script src="{{ asset('vendor/bootstrap-select/js/bootstrap-select.min.js') }}"></script>
  <script src="{{ asset('js/custom.min.js') }}"></script>
  <script src="{{ asset('js/dlabnav-init.js') }}"></script>
  <!-- FontAwesome for icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <script>
    jQuery(document).ready(function () {
      jQuery('.show-pass').off('click').on('click', function () {
        jQuery(this).toggleClass('active');
        var input = jQuery(this).parent().find('input');
        input.attr('type', input.attr('type') === 'password' ? 'text' : 'password');
      });
    });
  </script>
</body>

</html>