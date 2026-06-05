<!DOCTYPE html>
<html lang="en">
<head>
    <title>Affiliate Signup — RentUs</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- FAVICONS ICON -->
    <link rel="shortcut icon" type="image/svg+xml" href="{{ asset('images/rentus.svg') }}">
    <link href="{{ asset('vendor/bootstrap-select/css/bootstrap-select.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    @include('auth.partials.auth-head')

    <style>
        /* Same base styles as login */
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

        .auth-split.no-car {
            min-height: 100vh;
            display: flex;
            background: transparent;
            justify-content: center;
            align-items: center;
            position: relative;
            overflow: hidden;
            padding: 2rem;
        }

        .auth-right {
            background: transparent;
            max-width: 750px; /* Wider for 2 columns */
            width: 100%;
            z-index: 10;
        }

        /* Glassmorphism Form Box */
        .auth-form-box {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            border-radius: 24px;
            padding: 3.5rem 3rem;
            box-shadow: var(--shadow-lg), 0 0 0 1px rgba(255,255,255,0.02) inset;
        }

        .auth-logo {
            display: block;
            margin: 0 auto 2rem;
            height: 48px;
            width: auto;
            filter: drop-shadow(0 4px 6px rgba(0,0,0,0.3));
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
            color: var(--muted);
            font-size: 0.95rem;
            margin-bottom: 2.5rem;
        }

        /* Form fields */
        .form-group { margin-bottom: 1.5rem; }
        
        .form-label {
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

        .form-control {
            width: 100%;
            border: 1px solid var(--field-border);
            border-radius: 12px;
            padding: 0.8rem 1rem 0.8rem 2.75rem;
            font-size: 0.95rem;
            background: var(--field-bg);
            color: #f1f5f9;
            transition: all 0.3s ease;
        }
        .form-control::placeholder { color: #475569; }
        .form-control:focus {
            border-color: var(--accent);
            background: rgba(15, 23, 42, 0.8);
            box-shadow: 0 0 0 4px var(--field-focus);
            outline: none;
        }
        .form-control:focus + .input-icon { color: #eab308; }

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
            box-shadow: 0 4px 14px rgba(234,179,8,0.25);
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
            box-shadow: 0 8px 25px rgba(234,179,8,0.4);
            color: #451a03;
        }
        .btn-signup:active {
            transform: translateY(0);
            box-shadow: 0 4px 10px rgba(234,179,8,0.2);
        }

        .auth-footer-link {
            text-align: center;
            margin-top: 2rem;
            font-size: 0.9rem;
            color: var(--muted);
            line-height: 1.6;
        }
        .auth-footer-link a {
            color: var(--accent);
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
            .auth-form-box {
                padding: 2.5rem 1.5rem;
            }
        }
    </style>
</head>
<body class="auth-page">
    <div class="fix-wrapper">
        <div class="auth-split no-car">
            <div class="auth-right">
                <div class="auth-form-box auth-card">
                    <div class="text-center mb-3">
                        <a href="{{ url('/') }}"><img class="auth-logo" src="{{ asset('images/rentus.png') }}" alt="RentUs Logo"></a>
                    </div>
                    <h4 class="auth-title">Affiliate sign up</h4>
                    <p class="auth-subtitle">Register your account to manage your cars and property.</p>
                    
                    @if($errors->any())
                        <div class="alert-danger py-2 mb-4">
                            <ul class="mb-0" style="padding-left:1rem;">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    <form action="{{ url('register') }}" method="POST">
                        @csrf
                        <input type="hidden" name="role" value="affiliate">
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-4">
                                    <label class="form-label" for="name">Full Name / Company Name</label>
                                    <div class="input-wrapper">
                                        <i class="fas fa-building input-icon"></i>
                                        <input type="text" name="name" class="form-control" placeholder="Enter full name" id="name" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-4">
                                    <label class="form-label" for="email">Email Address</label>
                                    <div class="input-wrapper">
                                        <i class="fas fa-envelope input-icon"></i>
                                        <input type="email" name="email" class="form-control" placeholder="hello@example.com" id="email" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-4 position-relative">
                                    <label class="form-label" for="dlab-password">Password</label>
                                    <div class="input-wrapper">
                                        <i class="fas fa-lock input-icon"></i>
                                        <input type="password" name="password" id="dlab-password" class="form-control" placeholder="••••••••" required>
                                        <span class="show-pass"><i class="fa fa-eye-slash"></i><i class="fa fa-eye"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-4 position-relative">
                                    <label class="form-label" for="dlab-confirm-password">Confirm Password</label>
                                    <div class="input-wrapper">
                                        <i class="fas fa-lock input-icon"></i>
                                        <input type="password" name="password_confirmation" id="dlab-confirm-password" class="form-control" placeholder="••••••••" required>
                                        <span class="show-pass"><i class="fa fa-eye-slash"></i><i class="fa fa-eye"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-4">
                                    <label class="form-label" for="phone">Contact Number</label>
                                    <div class="input-wrapper">
                                        <i class="fas fa-phone input-icon"></i>
                                        <input type="tel" name="phone" class="form-control" placeholder="Enter contact number" id="phone" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-4">
                                    <label class="form-label" for="address">Address</label>
                                    <div class="input-wrapper">
                                        <i class="fas fa-map-marker-alt input-icon"></i>
                                        <input type="text" name="address" class="form-control" placeholder="Enter your full address" id="address" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn-signup mt-2">
                            Sign up as Affiliate
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                        </button>
                    </form>
                    
                    <p class="auth-footer-link">
                        Already have an account? <a href="{{ url('login') }}">Sign in</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Scripts -->
    <script src="{{ asset('vendor/global/global.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap-select/js/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('js/custom.min.js') }}"></script>
    <script src="{{ asset('js/dlabnav-init.js') }}"></script>
    <!-- FontAwesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        jQuery(document).ready(function() {
            jQuery('.show-pass').off('click').on('click', function(){
                jQuery(this).toggleClass('active');
                var input = jQuery(this).parent().find('input');
                if (input.attr('type') == 'password') {
                    input.attr('type', 'text');
                } else {
                    input.attr('type', 'password');
                }
            });
        });
    </script>
</body>
</html>
