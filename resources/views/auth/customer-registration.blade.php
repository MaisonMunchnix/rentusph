<!DOCTYPE html>
<html lang="en">

<head>
  <title>Customer Signup — RentUs</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="shortcut icon" type="image/svg+xml" href="{{ asset('images/rentus.svg') }}">
  <link href="{{ asset('vendor/bootstrap-select/css/bootstrap-select.min.css') }}" rel="stylesheet">
  <link href="{{ asset('css/style.css') }}" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700&family=Arvo:ital,wght@0,400;0,700;1,400&family=Bebas+Neue&display=swap" rel="stylesheet">

  <style>
    /* ── Reset fix-wrapper so we control the full layout ── */
    html,
    body {
      height: 100%;
      margin: 0;
      padding: 0;
      background: #0f172a;
      font-family: 'Outfit', sans-serif;
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
      width: 42%;
      flex-shrink: 0;
      position: relative;
      background: linear-gradient(160deg, #0a0f1e 0%, #111827 60%, #1a2540 100%);
      display: flex;
      flex-direction: column;
      justify-content: center;
      padding: 3rem 3rem 3rem 4rem;
      overflow: hidden;
    }

    /* Subtle geometric accent */
    .auth-left::before {
      content: '';
      position: absolute;
      top: -120px;
      right: -120px;
      width: 350px;
      height: 350px;
      border-radius: 50%;
      background: radial-gradient(circle, rgba(234, 179, 8, 0.12) 0%, transparent 70%);
      pointer-events: none;
    }

    .auth-left::after {
      content: '';
      position: absolute;
      bottom: -80px;
      left: -80px;
      width: 250px;
      height: 250px;
      border-radius: 50%;
      background: radial-gradient(circle, rgba(234, 179, 8, 0.07) 0%, transparent 70%);
      pointer-events: none;
    }

    /* Back to homepage link */
    .auth-back {
      position: absolute;
      top: 1.75rem;
      left: 2rem;
      color: rgba(255, 255, 255, 0.45);
      font-size: 0.85rem;
      text-decoration: none;
      display: flex;
      align-items: center;
      gap: 0.4rem;
      transition: color 0.2s;
    }

    .auth-back:hover {
      color: #eab308;
    }

    .badge-tag {
      display: inline-block;
      background: rgba(234, 179, 8, 0.12);
      border: 1px solid rgba(234, 179, 8, 0.35);
      color: #eab308;
      font-size: 0.72rem;
      font-weight: 700;
      letter-spacing: 0.08em;
      text-transform: uppercase;
      padding: 0.3rem 0.9rem;
      border-radius: 50px;
      margin-bottom: 1.25rem;
      width: fit-content;
    }

    .car-preview-img {
      width: 100%;
      height: 210px;
      object-fit: cover;
      border-radius: 14px;
      margin-bottom: 1.5rem;
      box-shadow: 0 16px 40px rgba(0, 0, 0, 0.5);
    }

    .car-placeholder {
      width: 100%;
      height: 210px;
      background: rgba(255, 255, 255, 0.04);
      border: 1px solid rgba(255, 255, 255, 0.08);
      border-radius: 14px;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 1.5rem;
      color: rgba(255, 255, 255, 0.15);
      font-size: 3.5rem;
    }

    .car-name {
      font-size: 1.75rem;
      font-weight: 800;
      color: #fff;
      margin: 0 0 0.5rem;
      letter-spacing: -0.02em;
    }

    .car-meta {
      display: flex;
      gap: 1.25rem;
      flex-wrap: wrap;
      font-size: 0.82rem;
      color: rgba(255, 255, 255, 0.5);
      margin-bottom: 1.5rem;
    }

    .car-meta span {
      display: flex;
      align-items: center;
      gap: 0.35rem;
    }

    .car-meta svg {
      opacity: 0.6;
    }

    .car-rate {
      font-size: 2.25rem;
      font-weight: 900;
      color: #eab308;
      line-height: 1;
      margin-bottom: 1.75rem;
    }

    .car-rate small {
      font-size: 1rem;
      font-weight: 400;
      color: rgba(255, 255, 255, 0.4);
    }

    .intent-box {
      border-top: 1px solid rgba(255, 255, 255, 0.08);
      padding-top: 1.25rem;
      font-size: 0.83rem;
    }

    .intent-box strong {
      display: block;
      color: rgba(255, 255, 255, 0.85);
      font-weight: 600;
      margin-bottom: 0.2rem;
    }

    .intent-box span {
      color: rgba(255, 255, 255, 0.4);
    }

    /* ── RIGHT — Form ── */
    .auth-right {
      flex: 1;
      display: flex;
      align-items: center;
      justify-content: center;
      background: #f8fafc;
      padding: 2rem 3rem;
      overflow-y: auto;
    }

    .auth-form-box {
      width: 100%;
      max-width: 550px;
    }

    .auth-logo {
      display: block;
      margin: 0 auto 1.75rem;
      max-height: 50px;
      width: auto;
    }

    h1,
    h2,
    h3,
    h4,
    h5,
    h6 {
      font-family: 'Arvo', serif;
    }

    .auth-title {
      font-size: 1.6rem;
      font-weight: 800;
      color: #0f172a;
      margin-bottom: 0.25rem;
      text-align: center;
      letter-spacing: -0.02em;
    }

    .auth-subtitle {
      text-align: center;
      color: #64748b;
      font-size: 0.9rem;
      margin-bottom: 2rem;
    }

    /* Form fields */
    .auth-form-box .form-label {
      font-size: 0.82rem;
      font-weight: 600;
      color: #374151;
      margin-bottom: 0.35rem;
    }

    .auth-form-box .form-control {
      border: 1.5px solid #e2e8f0;
      border-radius: 10px;
      padding: 0.65rem 0.9rem;
      font-size: 0.9rem;
      background: #fff;
      color: #0f172a;
      transition: border-color 0.2s, box-shadow 0.2s;
    }

    .auth-form-box .form-control:focus {
      border-color: #eab308;
      box-shadow: 0 0 0 3px rgba(234, 179, 8, 0.12);
      outline: none;
    }

    .show-pass.eye {
      right: 0.9rem;
    }

    .btn-signup {
      width: 100%;
      padding: 0.8rem;
      background: #eab308;
      color: #0a0f1e;
      font-weight: 700;
      font-size: 0.95rem;
      border: none;
      border-radius: 10px;
      cursor: pointer;
      transition: background 0.2s, transform 0.15s, box-shadow 0.2s;
      box-shadow: 0 4px 14px rgba(234, 179, 8, 0.3);
      margin-top: 0.5rem;
    }

    .btn-signup:hover {
      background: #facc15;
      transform: translateY(-1px);
      box-shadow: 0 6px 20px rgba(234, 179, 8, 0.35);
    }

    .btn-signup:active {
      transform: translateY(0);
    }

    .auth-footer-link {
      text-align: center;
      margin-top: 1.25rem;
      font-size: 0.85rem;
      color: #64748b;
    }

    .auth-footer-link a {
      color: #eab308;
      font-weight: 600;
      text-decoration: none;
    }

    .auth-footer-link a:hover {
      text-decoration: underline;
    }

    .alert-danger {
      background: #fef2f2;
      border: 1px solid #fecaca;
      color: #991b1b;
      border-radius: 10px;
      padding: 0.75rem 1rem;
      font-size: 0.85rem;
      margin-bottom: 1.25rem;
    }

    /* ── Responsive ── */
    @media (max-width: 768px) {
      .auth-split {
        flex-direction: column;
      }

      .auth-left {
        width: 100%;
        padding: 2rem 1.5rem;
        min-height: auto;
      }

      .auth-right {
        padding: 2rem 1.25rem;
      }
    }

    /* ── No-car default: center the form on dark bg ── */
    .auth-split.no-car {
      background-color: #0f172a;
      background-image:
        radial-gradient(at 0% 0%, rgba(234, 179, 8, 0.15) 0px, transparent 50%),
        radial-gradient(at 100% 100%, rgba(56, 189, 248, 0.1) 0px, transparent 50%),
        radial-gradient(at 100% 0%, rgba(15, 23, 42, 1) 0px, transparent 50%);
      justify-content: center;
      align-items: center;
      position: relative;
      overflow: hidden;
      padding: 2rem;
    }

    .auth-split.no-car::before {
      content: '';
      position: absolute;
      inset: 0;
      background: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noiseFilter'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.65' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noiseFilter)'/%3E%3C/svg%3E");
      opacity: 0.03;
      pointer-events: none;
    }

    .auth-split.no-car .auth-right {
      background: transparent;
      max-width: 650px;
      width: 100%;
      z-index: 10;
    }

    .auth-split.no-car .auth-form-box {
      background: rgba(15, 23, 42, 0.6);
      backdrop-filter: blur(20px);
      -webkit-backdrop-filter: blur(20px);
      border: 1px solid rgba(255, 255, 255, 0.08);
      border-radius: 24px;
      padding: 3.5rem 3rem;
      box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5), 0 0 0 1px rgba(255, 255, 255, 0.02) inset;
    }

    .auth-split.no-car .auth-title {
      color: #f1f5f9;
    }

    .auth-split.no-car .auth-subtitle {
      color: #94a3b8;
    }

    .auth-split.no-car .form-label {
      color: #cbd5e1;
    }

    .auth-split.no-car .form-control {
      background: #0f172a;
      border-color: #334155;
      color: #f1f5f9;
    }

    .auth-split.no-car .form-control::placeholder {
      color: #475569;
    }

    .auth-split.no-car .auth-footer-link {
      color: #94a3b8;
    }
  </style>
</head>

<body>
  <div class="fix-wrapper">

    @if($selectedCar)
      {{-- ════ SPLIT LAYOUT ════ --}}
      <div class="auth-split">

        {{-- ── LEFT: Car Preview ── --}}
        <div class="auth-left">
          <a href="{{ url('/') }}" class="auth-back">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
              <polyline points="15 18 9 12 15 6" />
            </svg>
            Back to home
          </a>

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
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6" />
              </svg>
              {{ $selectedCar->transmission }}
            </span>
            <span>
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                <circle cx="9" cy="7" r="4" />
              </svg>
              {{ $selectedCar->capacity }} Seats
            </span>
            <span>
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
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
            <span>Create an account to complete your reservation.</span>
          </div>
        </div>

        {{-- ── RIGHT: Registration Form ── --}}
        <div class="auth-right">
          <div class="auth-form-box">
            <a href="{{ url('/') }}">
              <img src="{{ asset('images/rentus-logo.svg') }}" alt="RentUs" class="auth-logo">
            </a>
            <h1 class="auth-title">Create your account</h1>
            <p class="auth-subtitle">Join RentUs and complete your booking</p>

            @if($errors->any())
              <div class="alert-danger">
                <ul class="mb-0" style="padding-left:1rem;">
                  @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                </ul>
              </div>
            @endif

            <form action="{{ url('register') }}" method="POST">
              @csrf
              <input type="hidden" name="role" value="customer">

              <div class="row g-3">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="form-label" for="name">Full Name</label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="Your name" required>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="form-label" for="email">Email</label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="hello@example.com"
                      required>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group position-relative">
                    <label class="form-label" for="dlab-password">Password</label>
                    <input type="password" name="password" id="dlab-password" class="form-control" required>
                    <span class="show-pass eye"><i class="fa fa-eye-slash"></i><i class="fa fa-eye"></i></span>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group position-relative">
                    <label class="form-label" for="dlab-confirm-password">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="dlab-confirm-password" class="form-control"
                      required>
                    <span class="show-pass eye"><i class="fa fa-eye-slash"></i><i class="fa fa-eye"></i></span>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="form-label" for="phone">Phone Number</label>
                    <input type="tel" name="phone" id="phone" class="form-control" placeholder="+63 9XX XXX XXXX"
                      required>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="form-label" for="address">Address <span
                        style="color:#94a3b8;font-weight:400;">(optional)</span></label>
                    <input type="text" name="address" id="address" class="form-control" placeholder="City, Province">
                  </div>
                </div>
              </div>

              <button type="submit" class="btn-signup mt-3">Create Account</button>
            </form>

            <p class="auth-footer-link">
              Already have an account?
              <a href="{{ route('login', session('pending_car_id') ? ['car_id' => session('pending_car_id')] : []) }}">Sign
                in</a>
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
              <img src="{{ asset('images/rentus-logo.svg') }}" alt="RentUs" class="auth-logo">
            </a>
            <h1 class="auth-title">Create your account</h1>
            <p class="auth-subtitle">Join RentUs today</p>

            @if($errors->any())
              <div class="alert-danger">
                <ul class="mb-0" style="padding-left:1rem;">
                  @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                </ul>
              </div>
            @endif

            <form action="{{ url('register') }}" method="POST">
              @csrf
              <input type="hidden" name="role" value="customer">

              <div class="row g-3">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="form-label" for="name">Full Name</label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="Your name" required>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="form-label" for="email">Email</label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="hello@example.com"
                      required>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group position-relative">
                    <label class="form-label" for="dlab-password">Password</label>
                    <input type="password" name="password" id="dlab-password" class="form-control" required>
                    <span class="show-pass eye"><i class="fa fa-eye-slash"></i><i class="fa fa-eye"></i></span>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group position-relative">
                    <label class="form-label" for="dlab-confirm-password">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="dlab-confirm-password" class="form-control"
                      required>
                    <span class="show-pass eye"><i class="fa fa-eye-slash"></i><i class="fa fa-eye"></i></span>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="form-label" for="phone">Phone Number</label>
                    <input type="tel" name="phone" id="phone" class="form-control" placeholder="+63 9XX XXX XXXX"
                      required>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="form-label" for="address">Address <span
                        style="color:#94a3b8;font-weight:400;">(optional)</span></label>
                    <input type="text" name="address" id="address" class="form-control" placeholder="City, Province">
                  </div>
                </div>
              </div>

              <button type="submit" class="btn-signup mt-3">Create Account</button>
            </form>

            <p class="auth-footer-link">
              Already have an account? <a href="{{ url('login') }}">Sign in</a>
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