<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Affiliate Application | RentUs</title>
    
    <!-- FAVICONS ICON -->
    <link rel="shortcut icon" type="image/svg+xml" href="{{ asset('images/rentus.svg') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    @include('auth.partials.auth-head')

    <style>
        *, *::before, *::after {
            box-sizing: border-box;
        }
        
        body.auth-page {
            overflow-y: auto !important;
            overflow-x: hidden;
        }

        .auth-split {
            min-height: 100vh;
            display: flex;
            background: transparent;
            justify-content: center;
            align-items: center;
            padding: 2rem;
        }
        .auth-right {
            max-width: 750px;
            width: 100%;
            z-index: 10;
        }

        .form-control {
            width: 100%;
            border-radius: 12px;
            padding: 0.8rem 1rem;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }
        
        .status-header {
            text-align: center;
            margin-bottom: 2.5rem;
        }
        .icon-box {
            width: 70px;
            height: 70px;
            background: var(--field-bg);
            border: 1px solid var(--field-border);
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
        
        .section-title {
            color: var(--accent);
            font-size: 1.1rem;
            font-weight: 700;
            margin: 2rem 0 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 1px solid var(--field-border);
            text-align: left;
            display: flex;
            align-items: center;
        }
        .section-title i {
            margin-right: 0.5rem;
        }
        .form-group {
            margin-bottom: 1.5rem;
            text-align: left;
        }
        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-size: 0.85rem;
        }
        .row-flex {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
            width: 100%;
        }
        @media (max-width: 576px) {
            .row-flex {
                grid-template-columns: 1fr;
                gap: 0;
            }
        }
        
        .btn-signup {
            width: 100%;
            padding: 0.85rem;
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
            font-size: 1rem;
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
        }
        .btn-signup:active {
            transform: translateY(0);
            box-shadow: 0 4px 10px rgba(234,179,8,0.2);
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
            border-radius: 12px;
            margin-bottom: 1.5rem;
            font-weight: 500;
        }
        .alert-success {
            background: rgba(34, 197, 94, 0.1);
            color: #86efac;
            border: 1px solid rgba(34, 197, 94, 0.2);
        }
        .alert-danger {
            background: rgba(239, 68, 68, 0.1);
            color: #fca5a5;
            border: 1px solid rgba(239, 68, 68, 0.2);
        }
        
        /* File input specific styling */
        input[type="file"].form-control {
            padding: 0.6rem 1rem;
        }
        input[type="file"]::file-selector-button {
            background: var(--field-border);
            color: #f8fafc;
            border: none;
            padding: 0.4rem 0.8rem;
            border-radius: 6px;
            margin-right: 1rem;
            cursor: pointer;
            transition: all 0.2s;
            font-family: inherit;
            font-size: 0.85rem;
        }
        input[type="file"]::file-selector-button:hover {
            background: #475569;
        }
    </style>
</head>
<body class="auth-page">
    <div class="auth-split">
        <div class="auth-right">
            <div class="auth-card">
                <div class="text-center" style="text-align: center; margin-bottom: 2rem;">
                    <a href="{{ url('/') }}"><img class="auth-logo" src="{{ asset('images/rentus.png') }}" alt="RentUs Logo" style="height: 48px; width: auto; filter: drop-shadow(0 4px 6px rgba(0,0,0,0.3));"></a>
                </div>

                @if(session('success'))
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0" style="list-style: none; padding-left: 0;">
                            @foreach($errors->all() as $error)
                                <li><i class="fas fa-exclamation-circle me-2"></i> {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if(!$vehicles_submitted)
                    <div class="status-header">
                        <h2 class="auth-title">Almost There!</h2>
                        <p class="auth-subtitle">To complete your application, please submit your first vehicle details for review.</p>
                    </div>

                    <form action="{{ route('pending-review.vehicles') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <h3 class="section-title"><i class="fas fa-car-side"></i> Vehicle Identification</h3>
                        <div class="row-flex">
                            <div class="form-group">
                                <label class="form-label">Brand <span class="text-danger">*</span></label>
                                <input type="text" name="brand" class="form-control" placeholder="e.g. Toyota" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Model <span class="text-danger">*</span></label>
                                <input type="text" name="model" class="form-control" placeholder="e.g. Vios" required>
                            </div>
                        </div>

                        <div class="row-flex">
                            <div class="form-group">
                                <label class="form-label">Manufacture Year <span class="text-danger">*</span></label>
                                <input type="number" name="year" class="form-control" placeholder="2023" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Plate Number <span class="text-danger">*</span></label>
                                <input type="text" name="plate_number" class="form-control" placeholder="ABC 1234" required>
                            </div>
                        </div>

                        <h3 class="section-title"><i class="fas fa-cogs"></i> Specifications</h3>
                        <div class="row-flex">
                            <div class="form-group">
                                <label class="form-label">Exterior Color</label>
                                <input type="text" name="color" class="form-control" placeholder="e.g. Black">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Seating Capacity</label>
                                <input type="number" name="capacity" class="form-control" placeholder="5">
                            </div>
                        </div>

                        <div class="row-flex">
                            <div class="form-group">
                                <label class="form-label">Transmission</label>
                                <select name="transmission" class="form-control">
                                    <option value="" style="color: #0f172a;">Select...</option>
                                    <option value="Automatic" style="color: #0f172a;">Automatic</option>
                                    <option value="Manual" style="color: #0f172a;">Manual</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Fuel Type</label>
                                <select name="fuel_type" class="form-control">
                                    <option value="" style="color: #0f172a;">Select...</option>
                                    <option value="Gas" style="color: #0f172a;">Gasoline</option>
                                    <option value="Diesel" style="color: #0f172a;">Diesel</option>
                                    <option value="Electric" style="color: #0f172a;">Electric</option>
                                </select>
                            </div>
                        </div>

                        <h3 class="section-title"><i class="fas fa-coins"></i> Pricing & Policies</h3>
                        <div class="row-flex">
                            <div class="form-group">
                                <label class="form-label">Daily Rental Rate (₱) <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" name="daily_rate" class="form-control" placeholder="1500" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Security Deposit (₱) <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" name="security_deposit" class="form-control" value="3000" min="1000" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Additional Description</label>
                            <textarea name="description" class="form-control" rows="3" placeholder="Features, rental conditions, etc..."></textarea>
                        </div>

                        <h3 class="section-title"><i class="fas fa-file-alt"></i> Photos & Documentation</h3>
                        <div class="form-group">
                            <label class="form-label">Vehicle Photo <span class="text-danger">*</span></label>
                            <input type="file" name="image" class="form-control" accept="image/*" required>
                            <small class="auth-subtitle" style="font-size: 0.8rem; margin-top: 0.25rem; display: block;">Clear exterior photo of the vehicle.</small>
                        </div>

                        <div class="row-flex">
                            <div class="form-group">
                                <label class="form-label">Official Receipt (OR) <span class="text-danger">*</span></label>
                                <input type="file" name="or_file" class="form-control" accept="image/*,.pdf" required>
                                <small class="auth-subtitle" style="font-size: 0.8rem; margin-top: 0.25rem; display: block;">PDF, JPG, or PNG</small>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Certificate of Reg. (CR) <span class="text-danger">*</span></label>
                                <input type="file" name="cr_file" class="form-control" accept="image/*,.pdf" required>
                                <small class="auth-subtitle" style="font-size: 0.8rem; margin-top: 0.25rem; display: block;">PDF, JPG, or PNG</small>
                            </div>
                        </div>

                        <div class="row-flex">
                            <div class="form-group">
                                <label class="form-label">Government ID 1 (Owner) <span class="text-danger">*</span></label>
                                <input type="file" name="owner_id_1" class="form-control" accept="image/*,.pdf" required>
                                <small class="auth-subtitle" style="font-size: 0.8rem; margin-top: 0.25rem; display: block;">PDF, JPG, or PNG</small>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Government ID 2 (Owner) <span class="text-danger">*</span></label>
                                <input type="file" name="owner_id_2" class="form-control" accept="image/*,.pdf" required>
                                <small class="auth-subtitle" style="font-size: 0.8rem; margin-top: 0.25rem; display: block;">PDF, JPG, or PNG</small>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Comprehensive Insurance <span class="text-danger">*</span></label>
                            <input type="file" name="comprehensive_insurance" class="form-control" accept="image/*,.pdf" required>
                            <small class="auth-subtitle" style="font-size: 0.8rem; margin-top: 0.25rem; display: block;">PDF, JPG, or PNG</small>
                        </div>

                        <button type="submit" class="btn-signup btn-primary">Submit Application</button>
                    </form>
                @else
                    <div class="status-header">
                        <div class="icon-box icon-review">
                            <i class="fas fa-clock"></i>
                        </div>
                        <h2 class="auth-title">Application Under Review</h2>
                        <p class="auth-subtitle">Thank you for submitting your details. Our admin team is currently reviewing your personal information and vehicle details.</p>
                        <p class="auth-subtitle" style="margin-top: 1rem;">We'll notify you once your account has been processed.</p>
                    </div>
                @endif

                <form action="{{ url('logout') }}" method="POST" style="text-align: center;">
                    @csrf
                    <button type="submit" class="logout-link" style="background:none; border:none; cursor:pointer;">
                        <i class="fas fa-sign-out-alt me-1"></i> Sign Out & Return Home
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/browser-image-compression@2.0.1/dist/browser-image-compression.js"></script>
    <script>
        document.querySelectorAll('input[type="file"]').forEach(function(input) {
            input.addEventListener('change', async function(event) {
                const file = event.target.files[0];
                if (!file) return;

                // Only compress images, skip PDFs or other documents
                if (!file.type.startsWith('image/')) return;

                const options = {
                    maxSizeMB: 1,            // Target size in MB
                    maxWidthOrHeight: 1920,   // Max dimensions
                    useWebWorker: true        // Use web worker for faster compression
                };

                try {
                    // Optional: show a loading indicator or disable submit button here
                    const submitBtn = document.querySelector('button[type="submit"]');
                    if (submitBtn) {
                        submitBtn.disabled = true;
                        submitBtn.innerText = 'Compressing image...';
                    }

                    const compressedFile = await imageCompression(file, options);
                    
                    // Create a new FileList containing the compressed file
                    const dataTransfer = new DataTransfer();
                    const newFile = new File([compressedFile], file.name, {
                        type: compressedFile.type,
                        lastModified: Date.now()
                    });
                    dataTransfer.items.add(newFile);
                    event.target.files = dataTransfer.files;

                } catch (error) {
                    console.error('Error compressing image:', error);
                } finally {
                    // Re-enable submit button
                    const submitBtn = document.querySelector('button[type="submit"]');
                    if (submitBtn) {
                        submitBtn.disabled = false;
                        submitBtn.innerText = 'Submit Application';
                    }
                }
            });
        });
    </script>
</body>
</html>
