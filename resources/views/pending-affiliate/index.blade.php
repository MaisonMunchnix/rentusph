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
            --primary: #eab308;
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
            border-radius: 1.5rem;
            padding: 2.5rem;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
            max-width: 750px;
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
        .section-title {
            color: var(--primary);
            font-size: 1.1rem;
            font-weight: 700;
            margin: 2rem 0 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 1px solid #333;
            text-align: left;
            display: flex;
            align-items: center;
        }
        .section-title i {
            margin-right: 0.5rem;
        }
        .form-group {
            margin-bottom: 1rem;
            text-align: left;
        }
        .form-label {
            display: block;
            font-weight: 600;
            color: #ffffff;
            margin-bottom: 0.35rem;
            font-size: 0.8rem;
        }
        .form-control {
            width: 100%;
            padding: 0.6rem 0.875rem;
            border-radius: 0.5rem;
            border: 1px solid #333;
            background: #1a1a1a;
            color: #ffffff;
            transition: all 0.2s;
            font-size: 0.875rem;
        }
        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(234, 179, 8, 0.2);
        }
        .row-flex {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
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
            padding: 0.8rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 700;
            width: 100%;
            cursor: pointer;
            transition: all 0.2s;
            box-shadow: 0 4px 6px -1px rgba(79, 70, 229, 0.2);
            margin-top: 0.5rem;
            font-size: 0.9rem;
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
                <h2>Almost There!</h2>
                <p class="subtitle">To complete your application, please submit your first vehicle details for review.</p>
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
                            <option value="">Select...</option>
                            <option value="Automatic">Automatic</option>
                            <option value="Manual">Manual</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Fuel Type</label>
                        <select name="fuel_type" class="form-control">
                            <option value="">Select...</option>
                            <option value="Gas">Gasoline</option>
                            <option value="Diesel">Diesel</option>
                            <option value="Electric">Electric</option>
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
                    <small style="color: #94a3b8; font-size: 0.8rem; margin-top: 0.25rem; display: block;">Clear exterior photo of the vehicle.</small>
                </div>

                <div class="row-flex">
                    <div class="form-group">
                        <label class="form-label">Official Receipt (OR) <span class="text-danger">*</span></label>
                        <input type="file" name="or_file" class="form-control" accept="image/*,.pdf" required>
                        <small style="color: #94a3b8; font-size: 0.8rem; margin-top: 0.25rem; display: block;">PDF, JPG, or PNG</small>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Certificate of Reg. (CR) <span class="text-danger">*</span></label>
                        <input type="file" name="cr_file" class="form-control" accept="image/*,.pdf" required>
                        <small style="color: #94a3b8; font-size: 0.8rem; margin-top: 0.25rem; display: block;">PDF, JPG, or PNG</small>
                    </div>
                </div>

                <div class="row-flex">
                    <div class="form-group">
                        <label class="form-label">Government ID 1 (Owner) <span class="text-danger">*</span></label>
                        <input type="file" name="owner_id_1" class="form-control" accept="image/*,.pdf" required>
                        <small style="color: #94a3b8; font-size: 0.8rem; margin-top: 0.25rem; display: block;">PDF, JPG, or PNG</small>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Government ID 2 (Owner) <span class="text-danger">*</span></label>
                        <input type="file" name="owner_id_2" class="form-control" accept="image/*,.pdf" required>
                        <small style="color: #94a3b8; font-size: 0.8rem; margin-top: 0.25rem; display: block;">PDF, JPG, or PNG</small>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Comprehensive Insurance <span class="text-danger">*</span></label>
                    <input type="file" name="comprehensive_insurance" class="form-control" accept="image/*,.pdf" required>
                    <small style="color: #94a3b8; font-size: 0.8rem; margin-top: 0.25rem; display: block;">PDF, JPG, or PNG</small>
                </div>

                <button type="submit" class="btn-primary" style="margin-top: 2rem;">Submit Application</button>
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
