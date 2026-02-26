<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Under Review | RentUs</title>
    <link href="{{ asset('public/vendor/bootstrap-select/dist/css/bootstrap-select.min.css') }}" rel="stylesheet">
    <link href="{{ asset('public/css/style.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
        }
        .pending-card {
            background: white;
            border-radius: 1.5rem;
            padding: 3rem;
            text-align: center;
            box-shadow: 0 1rem 3rem rgba(0,0,0,0.05);
            max-width: 500px;
            width: 90%;
            border: 1px solid rgba(0,0,0,0.05);
        }
        .icon-box {
            width: 80px;
            height: 80px;
            background: #fff8e1;
            color: #ffc107;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            margin: 0 auto 2rem;
        }
        h2 {
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 1rem;
        }
        p {
            color: #6c757d;
            line-height: 1.6;
            margin-bottom: 2.5rem;
        }
        .btn-logout {
            background-color: #f8f9fa;
            color: #dc3545;
            border: 1px solid #e9ecef;
            padding: 0.75rem 1.5rem;
            border-radius: 0.75rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
        }
        .btn-logout:hover {
            background-color: #fff5f5;
            border-color: #feb2b2;
            color: #c53030;
        }
        .logo-box {
            margin-bottom: 2.5rem;
        }
        .logo-box img {
            height: 40px;
        }
    </style>
</head>
<body>
    <div class="pending-card">
        <div class="logo-box">
            <img src="{{ asset('images/rentus-logo.svg') }}" alt="RentUs Logo">
        </div>
        <div class="icon-box">
            <i class="fas fa-clock"></i>
        </div>
        <h2>Account Under Review</h2>
        <p>
            Your affiliate account is currently being reviewed by our team. 
            Please revisit later.
        </p>
        
        <form action="{{ url('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn-logout">
                <i class="fas fa-sign-out-alt me-2"></i> Sign Out & Return Home
            </button>
        </form>
    </div>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</body>
</html>
