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
    <style>
        :root {
            --card: #000000 !important;
            --text-dark: #ffffff !important;
            --text-gray: #cbd5e1 !important;
            --text: #ffffff !important;
            --bs-body-color: #ffffff !important;
            --primary: #eab308 !important;
        }
        .fix-wrapper .card {
            background-color: #000000 !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            color: #ffffff !important;
        }
        .fix-wrapper .card-body {
            background-color: #000000 !important;
            color: #ffffff !important;
        }
        .fix-wrapper .card-body .form-label,
        .fix-wrapper .card-body label,
        .fix-wrapper .card-body .form-group label,
        .fix-wrapper .card-body .form-check-label,
        .fix-wrapper .card-body * label {
            color: #ffffff !important;
            font-weight: 800 !important;
            opacity: 1 !important;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.03em;
            display: inline-block;
            margin-bottom: 0.5rem;
        }
        .fix-wrapper h4, 
        .fix-wrapper p, 
        .fix-wrapper span:not(.badge) {
            color: #ffffff !important;
            font-weight: 600 !important;
        }
        .fix-wrapper .form-control {
            background-color: rgba(255, 255, 255, 0.15) !important;
            border: 1.5px solid rgba(255, 255, 255, 0.3) !important;
            color: #ffffff !important;
            height: 45px;
        }
        .fix-wrapper .form-control:focus {
            border-color: #eab308 !important;
            background-color: rgba(255, 255, 255, 0.2) !important;
        }
        .fix-wrapper .form-control::placeholder {
            color: rgba(255, 255, 255, 0.7) !important;
        }
        .card a {
            color: #eab308 !important;
        }
        .text-muted {
            color: #cbd5e1 !important;
        }
        .btn-primary {
            background-color: #eab308 !important;
            border-color: #eab308 !important;
            color: #000000 !important;
            font-weight: 700 !important;
        }
        .btn-primary:hover {
            background-color: #facc15 !important;
            border-color: #facc15 !important;
            color: #000000 !important;
        }
    </style>
</head>
<body>
    <div class="fix-wrapper">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-6">
                    <div class="card mb-0 h-auto">
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
