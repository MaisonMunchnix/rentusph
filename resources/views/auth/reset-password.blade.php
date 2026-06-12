<!DOCTYPE html>
<html lang="en">

<head>
  <title>Set New Password — RentUs</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="shortcut icon" type="image/svg+xml" href="{{ asset('images/rentus.svg') }}">
  <link href="{{ asset('vendor/bootstrap-select/css/bootstrap-select.min.css') }}" rel="stylesheet">
  <link href="{{ asset('css/style.css') }}" rel="stylesheet">
  @include('auth.partials.auth-head')

  <style>
    html, body {
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

    .auth-split {
      display: flex;
      min-height: 100vh;
    }

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

    .auth-right {
      flex: 1;
      display: flex;
      align-items: center;
      justify-content: center;
      background: #0b1121;
      padding: 2rem 3rem;
      position: relative;
      overflow-y: auto;
    }

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

    /* Email badge pill */
    .reset-email-badge {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 0.5rem;
      background: rgba(234, 179, 8, 0.08);
      border: 1px solid rgba(234, 179, 8, 0.2);
      border-radius: 50px;
      padding: 0.45rem 1.1rem;
      font-size: 0.85rem;
      color: #eab308;
      font-weight: 600;
      width: fit-content;
      margin: 0 auto 2rem;
    }

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
      padding: 0.8rem 3rem 0.8rem 2.75rem;
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

    /* Show/hide password toggle */
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

    .show-pass:hover { color: #eab308; }
    .show-pass i.fa-eye { display: none; }
    .show-pass.active i.fa-eye { display: inline-block; }
    .show-pass.active i.fa-eye-slash { display: none; }

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

    .btn-signup::after {
      content: '';
      position: absolute;
      top: -50%; right: -50%; bottom: -50%; left: -50%;
      background: linear-gradient(to bottom, rgba(255,255,255,0) 0%, rgba(255,255,255,0.4) 50%, rgba(255,255,255,0) 100%);
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

    @media (max-width: 768px) {
      .auth-split.no-car .auth-form-box {
        padding: 2.5rem 1.5rem;
      }
    }
  </style>
</head>

<body class="auth-page">
  <div class="fix-wrapper">
    <div class="auth-split no-car">
      <div class="auth-right">
        <div class="auth-form-box">

          <a href="{{ url('/') }}">
            <img src="{{ asset('images/rentus.png') }}" alt="RentUs" class="auth-logo">
          </a>
          <h1 class="auth-title">Set New Password</h1>
          <p class="auth-subtitle">Choose a strong password for your account.</p>

          {{-- Show which account is being reset --}}
          <div class="reset-email-badge">
            <i class="fas fa-user-circle"></i>
            {{ session('reset_email') }}
          </div>

          @if ($errors->any())
            <div class="alert-danger">{{ $errors->first() }}</div>
          @endif

          <form action="{{ route('password.update') }}" method="POST">
            @csrf

            <div class="form-group position-relative">
              <label class="form-label" for="password">New Password</label>
              <div class="input-wrapper">
                <i class="fas fa-lock input-icon"></i>
                <input type="password" name="password" id="password"
                       class="form-control @error('password') is-invalid @enderror"
                       placeholder="Min. 8 characters"
                       required autofocus>
                <span class="show-pass" id="toggle-password">
                  <i class="fa fa-eye-slash"></i>
                  <i class="fa fa-eye"></i>
                </span>
              </div>
            </div>

            <div class="form-group position-relative">
              <label class="form-label" for="password_confirmation">Confirm Password</label>
              <div class="input-wrapper">
                <i class="fas fa-lock input-icon"></i>
                <input type="password" name="password_confirmation" id="password_confirmation"
                       class="form-control"
                       placeholder="Repeat new password"
                       required>
                <span class="show-pass" id="toggle-confirm">
                  <i class="fa fa-eye-slash"></i>
                  <i class="fa fa-eye"></i>
                </span>
              </div>
            </div>

            <button type="submit" class="btn-signup">
              Save Password
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <line x1="5" y1="12" x2="19" y2="12"></line>
                <polyline points="12 5 19 12 12 19"></polyline>
              </svg>
            </button>
          </form>

          <p class="auth-footer-link">
            <a href="{{ url('forgot-password') }}">← Use a different email</a>
          </p>

        </div>
      </div>
    </div>
  </div>

  <script src="{{ asset('vendor/global/global.min.js') }}"></script>
  <script src="{{ asset('vendor/bootstrap-select/js/bootstrap-select.min.js') }}"></script>
  <script src="{{ asset('js/custom.min.js') }}"></script>
  <script src="{{ asset('js/dlabnav-init.js') }}"></script>
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
