<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Affiliate Application | RentUs</title>
    <link href="{{ asset('public/css/style.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary: #eab308; /* Using the yellow brand color from affiliate layout */
            --primary-hover: #ca8a04;
            --bg-card: #000000;
            --border-card: #2d2d2d;
        }
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
        }
        .container-box {
            background: var(--bg-card);
            border-radius: 2rem;
            padding: 3rem;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            width: 100%;
            border: 1px solid var(--border-card);
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
        }
        .logo-box {
            display: flex;
            justify-content: center;
            margin-bottom: 2rem;
        }
        .logo-box img {
            height: 50px;
            width: auto;
        }
        .status-header {
            text-align: center;
            margin-bottom: 2.5rem;
        }
        .icon-box {
            width: 70px;
            height: 70px;
            background: #1a1a1a;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            margin: 0 auto 1.5rem;
            box-shadow: 0 10px 15px -3px rgba(0,0,0,0.5);
        }
        .icon-pending { color: #f59e0b; }
        .icon-review { color: #3b82f6; }
        
        h2 {
            font-weight: 800;
            color: #ffffff;
            margin-bottom: 0.5rem;
            letter-spacing: -0.025em;
        }
        .subtitle {
            color: #94a3b8;
            font-size: 1rem;
            line-height: 1.5;
        }
        .form-group {
            margin-bottom: 1.25rem;
            text-align: left;
        }
        .form-label {
            display: block;
            font-weight: 600;
            color: #ffffff;
            margin-bottom: 0.5rem;
            font-size: 0.875rem;
        }
        .form-control {
            width: 100%;
            padding: 0.75rem 1rem;
            border-radius: 0.75rem;
            border: 1px solid #333;
            background: #1a1a1a;
            color: #ffffff;
            transition: all 0.2s;
            font-size: 1rem;
        }
        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(234, 179, 8, 0.2);
        }
        .row-flex {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
            width: 100%;
            margin-bottom: 0px;
        }
        @media (max-width: 576px) {
            .row-flex {
                grid-template-columns: 1fr;
                gap: 0;
            }
            .container-box {
                padding: 2rem;
            }
        }
        .btn-primary {
            background: var(--primary);
            color: white;
            border: none;
            padding: 1rem 2rem;
            border-radius: 1rem;
            font-weight: 700;
            width: 100%;
            cursor: pointer;
            transition: all 0.2s;
            box-shadow: 0 4px 6px -1px rgba(79, 70, 229, 0.2);
            margin-top: 1rem;
        }
        .btn-primary:hover {
            background: var(--primary-hover);
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(79, 70, 229, 0.3);
        }
        .logout-link {
            display: inline-block;
            margin-top: 2rem;
            color: #ef4444;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.875rem;
            transition: color 0.2s;
        }
        .logout-link:hover {
            color: #dc2626;
        }
        .alert {
            padding: 1rem;
            border-radius: 0.75rem;
            margin-bottom: 1.5rem;
            font-weight: 500;
        }
        .alert-success {
            background: #dcfce7;
            color: #166534;
            border: 1px solid #bbf7d0;
        }
    </style>
</head>
<body>
    <div class="container-box">
        <div class="logo-box">
            <img src="{{ asset('images/rentus-logo.svg') }}" alt="RentUs Logo">
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger" style="background: #fee2e2; color: #991b1b; border: 1px solid #fecaca;">
                <ul class="mb-0" style="list-style: none; padding-left: 0;">
                    @foreach($errors->all() as $error)
                        <li><i class="fas fa-exclamation-circle me-2"></i> {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(!$vehicles_submitted)
            <div class="status-header">
                <div class="icon-box icon-pending">
                    <i class="fas fa-car"></i>
                </div>
                <h2>Almost There!</h2>
                <p class="subtitle">To complete your application, please submit your first vehicle details for review.</p>
            </div>

            <form action="{{ route('pending-review.vehicles') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row-flex">
                    <div class="form-group">
                        <label class="form-label">Brand</label>
                        <input type="text" name="brand" class="form-control" placeholder="e.g. Toyota" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Model</label>
                        <input type="text" name="model" class="form-control" placeholder="e.g. Vios" required>
                    </div>
                </div>

                <div class="row-flex">
                    <div class="form-group">
                        <label class="form-label">Year</label>
                        <input type="number" name="year" class="form-control" placeholder="2023" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Plate Number</label>
                        <input type="text" name="plate_number" class="form-control" placeholder="ABC 1234" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Daily Rate (₱)</label>
                    <input type="number" name="daily_rate" class="form-control" placeholder="1500" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Vehicle Photo</label>
                    <input type="file" name="image" class="form-control" accept="image/*" required>
                </div>

                <button type="submit" class="btn-primary">Submit Application</button>
            </form>
        @else
            <div class="status-header">
                <div class="icon-box icon-review">
                    <i class="fas fa-clock"></i>
                </div>
                <h2>Application Under Review</h2>
                <p class="subtitle">Thank you for submitting your details. Our admin team is currently reviewing your personal information and vehicle details.</p>
                <p class="subtitle" style="margin-top: 1rem;">We'll notify you once your account has been processed.</p>
            </div>
        @endif

        <form action="{{ url('logout') }}" method="POST" style="text-align: center;">
            @csrf
            <button type="submit" class="logout-link" style="background:none; border:none; cursor:pointer;">
                <i class="fas fa-sign-out-alt me-1"></i> Sign Out & Return Home
            </button>
        </form>
    </div>
</body>
</html>
