<!DOCTYPE html>
<html lang="en">
<head>
    <title>Customer Signup</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- FAVICONS ICON -->
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/favicon.png') }}">
    <link href="{{ asset('vendor/bootstrap-select/css/bootstrap-select.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body>
    <div class="fix-wrapper">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-6">
                    <div class="card mb-0 h-auto">
                        <div class="card-body">
                            <div class="text-center mb-3">
                                <a href="{{ url('/') }}"><img class="logo-auth" src="{{ asset('images/logo-full.png') }}" alt="Logo"></a>
                            </div>
                            <h4 class="text-center mb-4">Customer sign up</h4>
                            <form action="{{ url('register') }}" method="POST">
                                @csrf
                                <input type="hidden" name="role" value="customer">
                                <div class="form-group mb-4">
                                    <label class="form-label" for="name">Name</label>
                                    <input type="text" name="name" class="form-control" placeholder="Enter your name" id="name" required>
                                </div>
                                <div class="form-group mb-4">
                                    <label class="form-label" for="email">Email</label>
                                    <input type="email" name="email" class="form-control" placeholder="hello@example.com" id="email" required>
                                </div>
                                <div class="mb-sm-4 mb-3 position-relative">
                                    <label class="form-label" for="dlab-password">Password</label>
                                    <input type="password" name="password" id="dlab-password" class="form-control" required>
                                    <span class="show-pass eye">
                                        <i class="fa fa-eye-slash"></i>
                                        <i class="fa fa-eye"></i>
                                    </span>
                                </div>
                                <div class="mb-sm-4 mb-3 position-relative">
                                    <label class="form-label" for="dlab-confirm-password">Confirm password</label>
                                    <input type="password" name="password_confirmation" id="dlab-confirm-password" class="form-control" required>
                                    <span class="show-pass eye">
                                        <i class="fa fa-eye-slash"></i>
                                        <i class="fa fa-eye"></i>
                                    </span>
                                </div>
                                <div class="form-group mb-4">
                                    <label class="form-label" for="phone">Phone number (optional)</label>
                                    <input type="tel" name="phone" class="form-control" placeholder="Enter phone number" id="phone">
                                </div>
                                <div class="form-group mb-4">
                                    <label class="form-label" for="address">Address (optional)</label>
                                    <input type="text" name="address" class="form-control" placeholder="Enter your full address" id="address">
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary btn-block">Sign up</button>
                                </div>
                            </form>
                            <div class="new-account mt-3">
                                <p>Already have an account? <a class="text-primary" href="{{ url('login') }}">Sign in</a></p>
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
    <script src="{{ asset('js/dlabnav-init.js') }}"></script>
</body>
</html>
