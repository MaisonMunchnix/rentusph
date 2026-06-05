<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <title>Forgot Password</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- FAVICONS ICON -->
    <link rel="shortcut icon" type="image/svg+xml" href="{{ asset('images/rentus.svg') }}">
    <link href="{{ asset('vendor/bootstrap-select/css/bootstrap-select.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    @include('auth.partials.auth-head')
    <style>
        .auth-shell {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            position: relative;
            z-index: 1;
        }

        .auth-shell .card.auth-card {
            background: var(--glass-bg);
            border: 1px solid var(--glass-border);
            color: #f8fafc;
            max-width: 520px;
            width: 100%;
        }

        .auth-shell .card-body {
            padding: 2.5rem 2.25rem;
        }

        .auth-shell .form-label {
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 0.04em;
        }

        .auth-shell .form-control {
            height: 46px;
        }

        .auth-shell h4 {
            color: #f8fafc;
            font-weight: 800;
        }
    </style>
</head>
<body class="auth-page" data-bs-theme="dark">
    <div class="fix-wrapper auth-shell">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-6">
                    <div class="card auth-card mb-0 h-auto">
                        <div class="card-body">
                            <div class="text-center mb-3">
                                <a href="{{ url('/') }}"><img class="logo-auth" src="{{ asset('images/rentus-logo.svg') }}" alt="RentUs Logo" style="max-width: 200px;"></a>
                            </div>
                            <h4 class="text-center mb-4">Reset Password</h4>
                            <form action="{{ url('forgot-password') }}" method="POST">
                                @csrf
                                <div class="form-group mb-4">
                                    <label class="form-label" for="email">Email</label>
                                    <input type="email" name="email" class="form-control" placeholder="hello@example.com" id="email" required>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary btn-block">SUBMIT</button>
                                </div>
                            </form>
                            <div class="new-account mt-3">
                                <p>Remembered your password? <a class="text-primary" href="{{ url('login') }}">Sign in</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Scripts -->
    <script src="{{ asset('vendor/global/global.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap-select/js/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('js/custom.min.js') }}"></script>
    <script src="{{ asset('js/dlabnav-init.js') }}"></script>
</body>
</html>
