@php
    $layout = auth()->user()->role === 'admin' ? 'layouts.admin' : 'layouts.affiliate';
@endphp

<x-dynamic-component :component="$layout">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header border-0 pb-0 flex-wrap">
                    <h4 class="card-title">{{ auth()->user()->role === 'admin' ? 'Car Management' : 'My Cars' }}</h4>
                    <div class="d-flex mt-3 mt-sm-0 gap-2">
                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('admin.car-verification') }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-shield-alt me-2"></i>Verify Cars 
                                @if(isset($pendingCarsCount) && $pendingCarsCount > 0)
                                    <span class="badge badge-danger ms-1 text-light">{{ $pendingCarsCount }}</span>
                                @endif
                            </a>
                        @endif
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addCarModal">
                            <i class="fas fa-plus me-2"></i>Add Car
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Cars Filter Bar (all screens) -->
                    <div class="d-flex align-items-center gap-3 mb-3 flex-wrap" id="cars-filter-bar">
                        <div class="d-flex align-items-center gap-2">
                            <label class="text-muted small fw-600 mb-0" style="white-space:nowrap;"><i class="fas fa-circle me-1"></i>Status</label>
                            <select id="cars-filter-status" class="form-select form-select-sm" style="min-width:130px; border-radius:0.5rem; font-size:0.82rem;">
                                <option value="">All Status</option>
                                <option value="available">Available</option>
                                <option value="unavailable">Unavailable</option>
                            </select>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <label class="text-muted small fw-600 mb-0" style="white-space:nowrap;"><i class="fas fa-shield-alt me-1"></i>Verification</label>
                            <select id="cars-filter-verification" class="form-select form-select-sm" style="min-width:140px; border-radius:0.5rem; font-size:0.82rem;">
                                <option value="">All Verification</option>
                                <option value="pending">Pending</option>
                                <option value="approved">Approved</option>
                                <option value="rejected">Rejected</option>
                            </select>
                        </div>
                        <button id="cars-filter-reset" class="btn btn-outline-secondary btn-sm" style="border-radius:0.5rem; font-size:0.82rem;">
                            <i class="fas fa-times me-1"></i>Reset
                        </button>
                    </div>

                    <!-- Mobile Search Bar (visible on small screens only) -->
                    <div class="d-lg-none mb-3">
                        <div class="input-group">
                            <span class="input-group-text bg-white"><i class="fas fa-search text-muted"></i></span>
                            <input type="text" id="cars-mobile-search" class="form-control" placeholder="Search cars..." style="border-left:0;">
                        </div>
                    </div>

                    <!-- Desktop Table View -->
                    <div class="table-responsive d-none d-lg-block">
                        <table id="carsTable" class="table table-responsive-md datatable-enabled">
                            <thead>
                                <tr>
                                    <th><strong>BRAND & MODEL</strong></th>
                                    <th><strong>YEAR</strong></th>
                                    <th><strong>PLATE NO.</strong></th>
                                    <th><strong>CAPACITY/TYPE</strong></th>
                                    <th><strong>DAILY RATE</strong></th>
                                    <th><strong>SECURITY DEPOSIT</strong></th>
                                    <th><strong>STATUS</strong></th>
                                    <th><strong>VERIFICATION</strong></th>
                                    @if(auth()->user() && auth()->user()->role == 'admin')
                                    <th><strong>OWNER</strong></th>
                                    @endif
                                    <th class="text-end"><strong>ACTION</strong></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($cars as $car)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($car->image)
                                                <img src="{{ asset($car->image) }}" class="rounded-lg me-2" width="50" height="50" alt="" style="object-fit: cover;">
                                            @else
                                                <div class="bg-light rounded-lg me-2 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                                    <i class="fas fa-car text-muted"></i>
                                                </div>
                                            @endif
                                            <span class="w-space-no">{{ $car->brand }} {{ $car->model }}</span>
                                        </div>
                                    </td>
                                    <td>{{ $car->year }}</td>
                                    <td>{{ $car->plate_number }}</td>
                                    <td>{{ $car->capacity }} Pax / {{ $car->transmission }}</td>
                                    <td>₱{{ number_format($car->daily_rate, 2) }}</td>
                                    <td>₱{{ number_format($car->security_deposit, 2) }}</td>
                                    <td data-filter-status="{{ $car->is_available ? 'available' : 'unavailable' }}">
                                        @if($car->is_available)
                                            <span class="badge light badge-success">Available</span>
                                        @else
                                            <span class="badge light badge-warning">Unavailable</span>
                                        @endif
                                    </td>
                                    <td data-filter-verification="{{ $car->verification_status ?? 'pending' }}">
                                        @php
                                            $vClasses = [
                                                'pending'  => 'badge-warning',
                                                'approved' => 'badge-success',
                                                'rejected' => 'badge-danger',
                                            ];
                                        @endphp
                                        <span class="badge light {{ $vClasses[$car->verification_status] ?? 'badge-secondary' }}">
                                            {{ ucfirst($car->verification_status ?? 'pending') }}
                                        </span>
                                        @if($car->verification_status === 'rejected' && $car->rejection_reason)
                                            <br><small class="text-danger" style="font-size:0.7rem;">{{ Str::limit($car->rejection_reason, 40) }}</small>
                                        @endif
                                    </td>
                                    @if(auth()->user() && auth()->user()->role == 'admin')
                                    <td>{{ $car->user->name ?? 'N/A' }}</td>
                                    @endif
                                    <td>
                                        <div class="d-flex justify-content-end">
                                            <a href="#" class="btn btn-primary shadow btn-xs sharp me-1" title="Edit" data-bs-toggle="modal" data-bs-target="#editCarModal" onclick="populateEditModal({{ json_encode(array_merge($car->toArray(), ['affiliate' => optional($car->user->affiliateDetail)->toArray()])) }})"><i class="fas fa-pencil-alt"></i></a>
                                            <a href="#" class="btn btn-warning shadow btn-xs sharp me-1" title="{{ $car->is_available ? 'Deactivate' : 'Activate' }} Car" data-bs-toggle="modal" data-bs-target="#statusModal{{ $car->id }}"><i class="fas fa-power-off"></i></a>
                                            <button type="button" class="btn btn-danger shadow btn-xs sharp" title="Delete" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $car->id }}">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>
                                        
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="{{ (auth()->user() && auth()->user()->role == 'admin') ? '10' : '9' }}" class="text-center">No cars found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Mobile/Tablet Card View -->
                    <div class="d-lg-none">
                        <div class="row">
                            @forelse($cars as $car)
                            <div class="col-md-6 col-12 mb-4" data-card-status="{{ $car->is_available ? 'available' : 'unavailable' }}" data-card-verification="{{ $car->verification_status ?? 'pending' }}">
                                <div class="card border shadow-sm h-100 mb-0">
                                    <div class="card-body p-4">
                                        <div class="d-flex align-items-center mb-3">
                                            @if($car->image)
                                                <img src="{{ asset($car->image) }}" class="rounded-lg me-3 shadow-sm" width="70" height="70" alt="" style="object-fit: cover;">
                                            @else
                                                <div class="bg-light rounded-lg me-3 d-flex align-items-center justify-content-center shadow-sm" style="width: 70px; height: 70px;">
                                                    <i class="fas fa-car text-muted fa-2x"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <h5 class="mb-1 text-primary">{{ $car->brand }} {{ $car->model }}</h5>
                                                <span class="text-muted d-block fs-14">
                                                    <i class="fas fa-hashtag me-1"></i>{{ $car->plate_number }} &nbsp;•&nbsp; 
                                                    <i class="far fa-calendar-alt me-1"></i>{{ $car->year }}
                                                </span>
                                            </div>
                                        </div>
                                        
                                        <div class="row mb-3 bg-light rounded p-2 mx-0">
                                            <div class="col-6 px-2 border-end">
                                                <small class="text-muted d-block mb-1">Daily Rate</small>
                                                <span class="text-black font-w600 fs-15">₱{{ number_format($car->daily_rate, 2) }}</span>
                                            </div>
                                            <div class="col-6 px-2">
                                                <small class="text-muted d-block mb-1">Security Deposit</small>
                                                <span class="text-black font-w600 fs-15">₱{{ number_format($car->security_deposit, 2) }}</span>
                                            </div>
                                        </div>
                                        
                                        <div class="row mb-3">
                                            <div class="col-6">
                                                <small class="text-muted d-block mb-1">Specifications</small>
                                                <span class="text-black fs-14"><i class="fas fa-users me-1 text-muted"></i>{{ $car->capacity }} Pax</span><br>
                                                <span class="text-black fs-14"><i class="fas fa-cogs me-1 text-muted"></i>{{ $car->transmission }}</span>
                                            </div>
                                            <div class="col-6">
                                                <small class="text-muted d-block mb-1">Status</small>
                                                <div class="mb-1">
                                                    @if($car->is_available)
                                                        <span class="badge light badge-success badge-sm">Available</span>
                                                    @else
                                                        <span class="badge light badge-warning badge-sm">Unavailable</span>
                                                    @endif
                                                </div>
                                                <div>
                                                    @php
                                                        $vClasses = [
                                                            'pending'  => 'badge-warning',
                                                            'approved' => 'badge-success',
                                                            'rejected' => 'badge-danger',
                                                        ];
                                                    @endphp
                                                    <span class="badge light {{ $vClasses[$car->verification_status] ?? 'badge-secondary' }} badge-sm">
                                                        {{ ucfirst($car->verification_status ?? 'pending') }}
                                                    </span>
                                                </div>
                                                @if($car->verification_status === 'rejected' && $car->rejection_reason)
                                                    <small class="text-danger d-block mt-1" style="font-size:0.75rem; line-height: 1.2;">{{ Str::limit($car->rejection_reason, 40) }}</small>
                                                @endif
                                            </div>
                                        </div>

                                        @if(auth()->user() && auth()->user()->role == 'admin')
                                        <div class="mb-3">
                                            <small class="text-muted d-block mb-1">Owner</small>
                                            <span class="text-black fs-14"><i class="fas fa-user-circle me-1 text-muted"></i>{{ $car->user->name ?? 'N/A' }}</span>
                                        </div>
                                        @endif
                                        
                                        <div class="d-flex gap-2 pt-2 border-top">
                                            <a href="#" class="btn btn-outline-primary btn-sm flex-grow-1" title="Edit" data-bs-toggle="modal" data-bs-target="#editCarModal" onclick="populateEditModal({{ json_encode(array_merge($car->toArray(), ['affiliate' => optional($car->user->affiliateDetail)->toArray()])) }})"><i class="fas fa-pencil-alt me-1"></i> Edit</a>
                                            <a href="#" class="btn btn-outline-warning btn-sm flex-grow-1" title="{{ $car->is_available ? 'Deactivate' : 'Activate' }} Car" data-bs-toggle="modal" data-bs-target="#statusModal{{ $car->id }}"><i class="fas fa-power-off me-1"></i> Status</a>
                                            <button type="button" class="btn btn-outline-danger btn-sm flex-grow-1" title="Delete" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $car->id }}">
                                                <i class="fa fa-trash me-1"></i> Delete
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="col-12 text-center py-5">
                                <i class="fas fa-car fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">No cars found.</h5>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Car Modal -->
    <div class="modal fade" id="addCarModal">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0 shadow-sm">
                    <h5 class="modal-title font-w700">Add New Car Listing</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('cars.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body py-4 px-4">
                        <div class="row">
                            <!-- Left Column: Image & Basic Info -->
                            <div class="col-xl-5 border-end">
                                <div class="form-group mb-4 text-center">
                                    <label class="text-black font-w600 d-block mb-3">Vehicle Photography (Cover)</label>
                                    <div class="image-placeholder mb-4">
                                        <img id="add_image_preview" src="#" alt="Preview" class="d-none w-100 shadow-sm" style="height: 220px; object-fit: cover; border-radius: 15px; cursor: pointer;" onclick="document.getElementById('add_image_input').click()">
                                        <div id="add_image_icon" class="bg-light rounded d-flex align-items-center justify-content-center shadow-inner" style="height: 220px; border: 2px dashed #cbd5e1; cursor: pointer;" onclick="document.getElementById('add_image_input').click()">
                                            <div class="text-center">
                                                <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-2"></i>
                                                <p class="mb-0 text-muted font-w500">Upload Cover Photo</p>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="file" id="add_image_input" name="image" class="d-none" onchange="previewImage(this, 'add_image_preview', 'add_image_icon')" accept="image/*" required>
                                </div>

                                <hr class="my-3 opacity-50">
                                <h6 class="text-primary font-w700 mb-3"><i class="fas fa-images me-2"></i>Photo Gallery</h6>
                                <div class="form-group mb-4">
                                    <label class="text-black font-w600">Upload Gallery Photos</label>
                                    <input type="file" name="gallery_photos[]" class="form-control mb-2" accept="image/*" multiple style="cursor: pointer;">
                                    <small class="text-muted d-block">Select multiple photos. Images are automatically compressed.</small>
                                </div>

                                @if(auth()->user()->role !== 'admin')
                                <hr class="my-3 opacity-50">
                                <h6 class="text-primary font-w700 mb-3"><i class="fas fa-file-alt me-2"></i>LTO Documents <span class="text-danger">*</span></h6>
                                
                                <div class="form-group mb-3">
                                    <label class="text-black font-w600">Official Receipt (OR) <span class="text-danger">*</span></label>
                                    <input type="file" name="or_file" class="form-control" accept="image/*,.pdf" required>
                                    <small class="text-muted">JPG, PNG, or PDF · Max 5MB</small>
                                </div>
                                <div class="form-group mb-3">
                                    <label class="text-black font-w600">Certificate of Registration (CR) <span class="text-danger">*</span></label>
                                    <input type="file" name="cr_file" class="form-control" accept="image/*,.pdf" required>
                                    <small class="text-muted">JPG, PNG, or PDF · Max 5MB</small>
                                </div>
                                <div class="form-group mb-3">
                                    <label class="text-black font-w600">Comprehensive Insurance</label>
                                    <input type="file" name="comprehensive_insurance" class="form-control" accept="image/*,.pdf">
                                    <small class="text-muted">Upload copy of comprehensive insurance (optional, Max 5MB)</small>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 form-group mb-3">
                                        <label class="text-black font-w600">Government ID (Owner) 1</label>
                                        <input type="file" name="owner_id_1" class="form-control" accept="image/*,.pdf">
                                        <small class="text-muted">JPG, PNG, or PDF · Max 5MB</small>
                                    </div>
                                    <div class="col-md-6 form-group mb-3">
                                        <label class="text-black font-w600">Government ID (Owner) 2</label>
                                        <input type="file" name="owner_id_2" class="form-control" accept="image/*,.pdf">
                                        <small class="text-muted">JPG, PNG, or PDF · Max 5MB</small>
                                    </div>
                                </div>
                                @endif

                                
                                <div class="form-group mb-3">
                                    <label class="text-black font-w600">Plate Number</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-id-card text-primary"></i></span>
                                        <input type="text" name="plate_number" class="form-control bg-light" placeholder="LTO Plate No." required>
                                    </div>
                                    <small class="text-muted">Must be unique and verifiable.</small>
                                </div>
                            </div>

                            <!-- Right Column: Technical Details -->
                            <div class="col-xl-7">
                                <h6 class="text-primary font-w700 mb-3"><i class="fas fa-info-circle me-2"></i>General Specifications</h6>
                                <div class="row">
                                    <div class="col-md-6 form-group mb-3">
                                        <label class="text-black font-w600">Brand</label>
                                        <input type="text" name="brand" class="form-control" placeholder="e.g. BMW" required>
                                    </div>
                                    <div class="col-md-6 form-group mb-3">
                                        <label class="text-black font-w600">Model</label>
                                        <input type="text" name="model" class="form-control" placeholder="e.g. M4" required>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 form-group mb-3">
                                        <label class="text-black font-w600">Manufacture Year</label>
                                        <input type="number" name="year" class="form-control" placeholder="YYYY" required>
                                    </div>
                                    <div class="col-md-6 form-group mb-3">
                                        <label class="text-black font-w600">Exterior Color</label>
                                        <input type="text" name="color" class="form-control" placeholder="e.g. Matte Black">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4 form-group mb-3">
                                        <label class="text-black font-w600">Seats</label>
                                        <input type="number" name="capacity" class="form-control" placeholder="Pax">
                                    </div>
                                    <div class="col-md-4 form-group mb-3">
                                        <label class="text-black font-w600">Transmission</label>
                                        <select name="transmission" class="form-control wide">
                                            <option value="Automatic">Automatic</option>
                                            <option value="Manual">Manual</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group mb-3">
                                        <label class="text-black font-w600">Fuel</label>
                                        <select name="fuel_type" class="form-control wide">
                                            <option value="Gas">Gasoline</option>
                                            <option value="Diesel">Diesel</option>
                                            <option value="Electric">Electric</option>
                                        </select>
                                    </div>
                                </div>

                                <hr class="my-4 opacity-50">
                                <h6 class="text-primary font-w700 mb-3"><i class="fas fa-tag me-2"></i>Pricing & Policies</h6>
                                <div class="row">
                                    <div class="col-md-6 form-group mb-3">
                                        <label class="text-black font-w600">Daily Rental Rate</label>
                                        <div class="input-group mb-2">
                                            <span class="input-group-text">₱</span>
                                            <input type="number" step="0.01" name="daily_rate" class="form-control font-w700" min="500" max="20000" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6 form-group mb-3">
                                        <label class="text-black font-w600">Security Deposit</label>
                                        <div class="input-group mb-2">
                                            <span class="input-group-text">₱</span>
                                            <input type="number" step="0.01" name="security_deposit" class="form-control font-w700 text-warning" value="3000.00" min="1000" max="50000" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mb-0">
                                    <label class="text-black font-w600">Additional Description</label>
                                    <textarea name="description" class="form-control" rows="3" placeholder="Features, accessories, or rental conditions..."></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0 pt-3 justify-content-end px-4 pb-4">
                        <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Discard</button>
                        <button type="submit" class="btn btn-primary px-5 shadow">Save Vehicle Listing</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Edit Car Modal -->
    <div class="modal fade" id="editCarModal">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0 shadow-sm">
                    <h5 class="modal-title font-w700">Edit Vehicle Information</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="editCarForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body py-4 px-4">
                        <div class="row">
                            <!-- Left Column: Image -->
                            <div class="col-xl-5 border-end">
                                <div class="form-group mb-4 text-center">
                                    <label class="text-black font-w600 d-block mb-3">Cover Photo</label>
                                    <div class="image-placeholder mb-3">
                                        <img id="edit_image_preview" src="#" alt="Preview" class="d-none w-100 shadow-sm" style="height: 220px; object-fit: cover; border-radius: 15px; cursor: pointer;" onclick="document.getElementById('edit_image_input').click()">
                                        <div id="edit_image_icon" class="bg-light rounded d-flex align-items-center justify-content-center shadow-inner" style="height: 220px; border: 2px dashed #cbd5e1; cursor: pointer;" onclick="document.getElementById('edit_image_input').click()">
                                            <div class="text-center">
                                                <i class="fas fa-image fa-3x text-muted mb-2"></i>
                                                <p class="mb-0 text-muted font-w500">Cover Photo</p>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="file" id="edit_image_input" name="image" class="d-none" onchange="previewImage(this, 'edit_image_preview', 'edit_image_icon')" accept="image/*">
                                    <small class="text-muted d-block mt-2">Upload a new image to replace the current cover.</small>
                                </div>

                                <hr class="my-3 opacity-50">
                                <h6 class="text-primary font-w700 mb-3"><i class="fas fa-images me-2"></i>Photo Gallery</h6>
                                <div class="form-group mb-4">
                                    <label class="text-black font-w600">Upload Gallery Photos</label>
                                    <input type="file" id="gallery_upload_input" class="form-control mb-2" accept="image/*" multiple style="cursor: pointer;">
                                    <small class="text-muted d-block mb-3">Select multiple photos. Images are automatically compressed.</small>
                                    <button type="button" class="btn btn-sm btn-outline-primary w-100" onclick="uploadGalleryPhotos()">
                                        <i class="fas fa-upload me-1"></i> Upload Photos
                                    </button>
                                </div>

                                <div class="gallery-preview-container d-flex flex-wrap gap-2 mb-4" id="edit_gallery_preview">
                                    <!-- Gallery items injected here via JS -->
                                </div>

                                @if(auth()->user()->role !== 'admin')
                                <hr class="my-3 opacity-50">
                                <h6 class="text-primary font-w700 mb-3"><i class="fas fa-file-alt me-2"></i>LTO Documents</h6>
                                <div class="alert alert-info py-2 px-3 small border-0 mb-3" style="background: rgba(59, 130, 246, 0.1); color: #1d4ed8;">
                                    <i class="fas fa-info-circle me-1"></i> Uploading new documents will require admin verification again.
                                </div>
                                <div class="form-group mb-3">
                                    <label class="text-black font-w600">Official Receipt (OR)</label>
                                    <input type="file" name="or_file" class="form-control" accept="image/*,.pdf">
                                    <small class="text-muted">Upload only to update documents (Max 5MB)</small>
                                    <div id="edit_or_preview" class="mt-2"></div>
                                </div>
                                <div class="form-group mb-3">
                                    <label class="text-black font-w600">Certificate of Registration (CR)</label>
                                    <input type="file" name="cr_file" class="form-control" accept="image/*,.pdf">
                                    <small class="text-muted">Upload only to update documents (Max 5MB)</small>
                                    <div id="edit_cr_preview" class="mt-2"></div>
                                </div>
                                <div class="form-group mb-3">
                                    <label class="text-black font-w600">Comprehensive Insurance</label>
                                    <input type="file" name="comprehensive_insurance" class="form-control" accept="image/*,.pdf">
                                    <small class="text-muted">Upload copy of comprehensive insurance (optional, Max 5MB)</small>
                                    <div id="edit_insurance_preview" class="mt-2"></div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 form-group mb-3">
                                        <label class="text-black font-w600">Government ID (Owner) 1</label>
                                        <input type="file" name="owner_id_1" class="form-control" accept="image/*,.pdf">
                                        <small class="text-muted">JPG, PNG, or PDF · Max 5MB</small>
                                        <div id="edit_owner1_preview" class="mt-2"></div>
                                    </div>
                                    <div class="col-md-6 form-group mb-3">
                                        <label class="text-black font-w600">Government ID (Owner) 2</label>
                                        <input type="file" name="owner_id_2" class="form-control" accept="image/*,.pdf">
                                        <small class="text-muted">JPG, PNG, or PDF · Max 5MB</small>
                                        <div id="edit_owner2_preview" class="mt-2"></div>
                                    </div>
                                </div>
                                @endif

                                <div class="form-group mb-3">
                                    <label class="text-black font-w600">Plate Number</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-id-card text-primary"></i></span>
                                        <input type="text" id="edit_plate_number" name="plate_number" class="form-control bg-light font-w600" required>
                                    </div>
                                </div>
                            </div>

                            <!-- Right Column: Details -->
                            <div class="col-xl-7">
                                <h6 class="text-primary font-w700 mb-3"><i class="fas fa-edit me-2"></i>Unit Specifications</h6>
                                <div class="row">
                                    <div class="col-md-6 form-group mb-3">
                                        <label class="text-black font-w600">Brand</label>
                                        <input type="text" id="edit_brand" name="brand" class="form-control" required>
                                    </div>
                                    <div class="col-md-6 form-group mb-3">
                                        <label class="text-black font-w600">Model</label>
                                        <input type="text" id="edit_model" name="model" class="form-control" required>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 form-group mb-3">
                                        <label class="text-black font-w600">Manufacture Year</label>
                                        <input type="number" id="edit_year" name="year" class="form-control" required>
                                    </div>
                                    <div class="col-md-6 form-group mb-3">
                                        <label class="text-black font-w600">Exterior Color</label>
                                        <input type="text" id="edit_color" name="color" class="form-control">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4 form-group mb-3">
                                        <label class="text-black font-w600">Seats</label>
                                        <input type="number" id="edit_capacity" name="capacity" class="form-control">
                                    </div>
                                    <div class="col-md-4 form-group mb-3">
                                        <label class="text-black font-w600">Transmission</label>
                                        <select id="edit_transmission" name="transmission" class="form-control wide">
                                            <option value="Automatic">Automatic</option>
                                            <option value="Manual">Manual</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group mb-3">
                                        <label class="text-black font-w600">Fuel</label>
                                        <select id="edit_fuel_type" name="fuel_type" class="form-control wide">
                                            <option value="Gas">Gasoline</option>
                                            <option value="Diesel">Diesel</option>
                                            <option value="Electric">Electric</option>
                                        </select>
                                    </div>
                                </div>

                                <hr class="my-4 opacity-50">
                                <h6 class="text-primary font-w700 mb-3"><i class="fas fa-coins me-2"></i>Rates & Deposits</h6>
                                <div class="row">
                                    <div class="col-md-6 form-group mb-3">
                                        <label class="text-black font-w600">Daily Rental Rate</label>
                                        <div class="input-group">
                                            <span class="input-group-text">₱</span>
                                            <input type="number" step="0.01" id="edit_daily_rate" name="daily_rate" class="form-control font-w700" min="500" max="20000" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6 form-group mb-3">
                                        <label class="text-black font-w600">Security Deposit</label>
                                        <div class="input-group">
                                            <span class="input-group-text">₱</span>
                                            <input type="number" step="0.01" id="edit_security_deposit" name="security_deposit" class="form-control font-w700 text-warning" min="1000" max="50000" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mb-0">
                                    <label class="text-black font-w600">Additional Description</label>
                                    <textarea id="edit_description" name="description" class="form-control" rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0 pt-3 justify-content-end px-4 pb-4">
                        <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Discard</button>
                        <button type="submit" class="btn btn-primary px-5 shadow">Update Vehicle listing</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <x-slot name="styles">
        <link href="{{ asset('vendor/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet">
    </x-slot>

    <x-slot name="scripts">
        <script src="{{ asset('vendor/sweetalert2/sweetalert2.min.js') }}"></script>
        <script>
        function confirmToggleStatus(carId, isAvailable) {
            // Deprecated - using Bootstrap Modals now
        }

        @if($errors->any())
            let errorMessages = '';
            @foreach ($errors->all() as $error)
                errorMessages += '{{ $error }}<br>';
            @endforeach
            Swal.fire({
                html: `
                <div class="py-2 text-center">
                    <div class="mb-3 text-danger">
                        <i class="fas fa-exclamation-triangle fa-3x"></i>
                    </div>
                    <p class="mb-0 fs-5 text-danger fw-bold">Validation Error!</p>
                    <p class="mt-2 text-muted fs-6">` + errorMessages + `</p>
                </div>
                `,
                showConfirmButton: true,
                confirmButtonText: 'Okay',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-danger px-4',
                    popup: 'rounded-lg border-0 shadow-sm'
                }
            });
        @endif

        @if(session('success'))
            Swal.fire({
                html: `
                <div class="py-2 text-center">
                    <div class="mb-3 text-success">
                        <i class="fas fa-check-circle fa-3x"></i>
                    </div>
                    <p class="mb-0 fs-5 text-success fw-bold">Success!</p>
                    <p class="mt-2 text-muted fs-6">{{ session('success') }}</p>
                </div>
                `,
                showConfirmButton: true,
                confirmButtonText: 'Okay',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-success px-4',
                    popup: 'rounded-lg border-0 shadow-sm'
                }
            });
        @endif

        let currentEditCarId = null;

        function populateEditModal(car) {
            currentEditCarId = car.id;
            document.getElementById('edit_brand').value = car.brand;
            document.getElementById('edit_model').value = car.model;
            document.getElementById('edit_year').value = car.year;
            document.getElementById('edit_color').value = car.color;
            document.getElementById('edit_plate_number').value = car.plate_number;
            document.getElementById('edit_capacity').value = car.capacity;
            document.getElementById('edit_transmission').value = car.transmission;
            document.getElementById('edit_fuel_type').value = car.fuel_type;
            document.getElementById('edit_daily_rate').value = car.daily_rate;
            document.getElementById('edit_security_deposit').value = car.security_deposit;
            document.getElementById('edit_description').value = car.description;
            
            const form = document.getElementById('editCarForm');
            form.action = `/cars/${car.id}`;

            const preview = document.getElementById('edit_image_preview');
            const icon = document.getElementById('edit_image_icon');
            if (car.image) {
                preview.src = `/${car.image}`;
                preview.classList.remove('d-none');
                icon.classList.add('d-none');
            } else {
                preview.classList.add('d-none');
                icon.classList.remove('d-none');
            }

            // Populate Gallery
            const galleryContainer = document.getElementById('edit_gallery_preview');
            galleryContainer.innerHTML = '';
            if (car.gallery_images && car.gallery_images.length > 0) {
                car.gallery_images.forEach(img => {
                    galleryContainer.innerHTML += `
                        <div class="position-relative d-inline-block">
                            <img src="/${img.path}" class="rounded shadow-sm" style="width: 80px; height: 60px; object-fit: cover;">
                            <button type="button" class="btn btn-danger btn-xs sharp position-absolute" style="top: -5px; right: -5px; width: 20px; height: 20px; padding: 0; display: flex; align-items: center; justify-content: center; z-index: 10;" onclick="deleteGalleryImage(${img.id})">
                                <i class="fas fa-times" style="font-size: 10px;"></i>
                            </button>
                        </div>
                    `;
                });
            } else {
                galleryContainer.innerHTML = '<p class="text-muted small mb-0 w-100 text-center py-2 bg-light rounded">No gallery photos yet.</p>';
            }

            // Populate LTO / document filename links (no image previews)
            function setDocPreview(elId, path) {
                const el = document.getElementById(elId);
                if (!el) return;
                if (!path) {
                    el.innerHTML = '<p class="text-muted small mb-0">No file uploaded.</p>';
                    return;
                }
                const url = path.startsWith('/') ? path : '/' + path;
                const filename = path.split('/').pop();
                const ext = filename.split('.').pop().toLowerCase();
                let iconClass = 'fa-file-alt text-secondary';
                if (ext === 'pdf') iconClass = 'fa-file-pdf text-danger';
                else if (['jpg','jpeg','png','gif','webp'].includes(ext)) iconClass = 'fa-file-image text-primary';

                el.innerHTML = `
                    <a href="${url}" target="_blank" class="d-inline-flex align-items-center text-decoration-none">
                        <i class="fas ${iconClass} fa-lg me-2"></i>
                        <span class="small text-truncate" style="max-width:220px;display:inline-block;vertical-align:middle">${filename}</span>
                    </a>
                `;
            }

            // Car-level documents
            setDocPreview('edit_or_preview', car.or_file);
            setDocPreview('edit_cr_preview', car.cr_file);
            setDocPreview('edit_insurance_preview', car.comprehensive_insurance);

            // Owner IDs stored on affiliate (if provided by controller when opening modal)
            const affiliate = car.affiliate || null;
            setDocPreview('edit_owner1_preview', affiliate && affiliate.owner_id_1 ? affiliate.owner_id_1 : null);
            setDocPreview('edit_owner2_preview', affiliate && affiliate.owner_id_2 ? affiliate.owner_id_2 : null);
        }

        function previewImage(input, previewId, iconId) {
            const preview = document.getElementById(previewId);
            const icon = document.getElementById(iconId);
            
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove('d-none');
                    icon.classList.add('d-none');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        async function uploadGalleryPhotos() {
            const input = document.getElementById('gallery_upload_input');
            if (!input.files || input.files.length === 0) {
                Swal.fire('No files', 'Please select at least one photo.', 'warning');
                return;
            }

            const formData = new FormData();
            for (let i = 0; i < input.files.length; i++) {
                formData.append('photos[]', input.files[i]);
            }

            const btn = document.querySelector('button[onclick="uploadGalleryPhotos()"]');
            const originalText = btn.innerHTML;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Uploading...';
            btn.disabled = true;

            try {
                const response = await fetch(`/cars/${currentEditCarId}/gallery`, {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    body: formData
                });

                if (response.ok) {
                    window.location.reload();
                } else {
                    const data = await response.json();
                    Swal.fire('Error', data.message || 'Upload failed.', 'error');
                }
            } catch (err) {
                Swal.fire('Error', 'An error occurred during upload.', 'error');
            } finally {
                btn.innerHTML = originalText;
                btn.disabled = false;
            }
        async function deleteGalleryImage(imageId) {
            if (!confirm('Are you sure you want to delete this photo?')) return;

            try {
                const response = await fetch(`/cars/gallery/${imageId}`, {
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                });

                if (response.ok) {
                    window.location.reload();
                } else {
                    Swal.fire('Error', 'Failed to delete photo.', 'error');
                }
            } catch (err) {
                Swal.fire('Error', 'An error occurred.', 'error');
            }
        }
        </script>
    </x-slot>
    @foreach($cars as $car)
    <!-- Status Toggle Modal -->
    <div class="modal fade" id="statusModal{{ $car->id }}">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title font-w700">{{ $car->is_available ? 'Deactivate' : 'Activate' }} Car</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center py-4">
                    <div class="mb-3">
                        @if($car->is_available)
                            <div class="d-inline-flex align-items-center justify-content-center bg-warning-light rounded-circle mb-3" style="width: 80px; height: 80px;">
                                <i class="fas fa-power-off fa-2x text-warning"></i>
                            </div>
                            <p class="mb-0 fs-5 text-warning fw-bold">Disable Vehicle Listing</p>
                        @else
                            <div class="d-inline-flex align-items-center justify-content-center bg-success-light rounded-circle mb-3" style="width: 80px; height: 80px;">
                                <i class="fas fa-check-circle fa-2x text-success"></i>
                            </div>
                            <p class="mb-0 fs-5 text-success fw-bold">Enable Vehicle Listing</p>
                        @endif
                    </div>
                    <p class="mt-2 fs-6">Are you sure you want to <strong>{{ $car->is_available ? 'deactivate' : 'activate' }}</strong> the listing for <strong>{{ $car->brand }} {{ $car->model }}</strong>?</p>
                </div>
                <div class="modal-footer border-0 pt-0 justify-content-center pb-4">
                    <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Cancel</button>
                    <form action="{{ route('cars.toggle-status', $car) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn {{ $car->is_available ? 'btn-warning' : 'btn-success' }} px-4">
                            Yes, {{ $car->is_available ? 'Deactivate' : 'Activate' }} Now
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal{{ $car->id }}">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title font-w700">Confirm Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center py-4">
                    <div class="mb-3 text-danger">
                        <i class="fas fa-trash-alt fa-3x"></i>
                    </div>
                    <p class="mb-0 fs-5 text-danger fw-bold">Warning: Permanent Action</p>
                    <p class="mt-2 fs-6">Are you sure you want to delete <strong>{{ $car->brand }} {{ $car->model }}</strong>? This cannot be undone.</p>
                </div>
                <div class="modal-footer border-0 pt-0 justify-content-center pb-4">
                    <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Cancel</button>
                    <form action="{{ route('cars.destroy', $car) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger px-4">Delete Permanently</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endforeach

    <x-slot name="scripts">
    <script>
    $(document).ready(function() {
        // Cars table filter by Status & Verification
        var carsTable = $('#carsTable').DataTable();
        if (!carsTable) return;

        var filterStatus = '';
        var filterVerification = '';

        $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
            if (settings.nTable.id !== 'carsTable') return true;
            var row = $(carsTable.row(dataIndex).node());
            var rowStatus = row.find('td[data-filter-status]').data('filter-status') || '';
            var rowVerification = row.find('td[data-filter-verification]').data('filter-verification') || '';
            var statusOk = filterStatus === '' || rowStatus === filterStatus;
            var verificationOk = filterVerification === '' || rowVerification === filterVerification;
            return statusOk && verificationOk;
        });

        $('#cars-filter-status').on('change', function() {
            filterStatus = $(this).val();
            carsTable.draw();
            filterMobileCards();
        });

        $('#cars-filter-verification').on('change', function() {
            filterVerification = $(this).val();
            carsTable.draw();
            filterMobileCards();
        });

        $('#cars-filter-reset').on('click', function() {
            filterStatus = '';
            filterVerification = '';
            $('#cars-filter-status').val('');
            $('#cars-filter-verification').val('');
            $('#cars-mobile-search').val('');
            carsTable.draw();
            filterMobileCards();
        });

        // Mobile card view filtering
        function filterMobileCards() {
            var status = $('#cars-filter-status').val().toLowerCase();
            var verification = $('#cars-filter-verification').val().toLowerCase();
            var search = $('#cars-mobile-search').val().toLowerCase();

            $('.d-lg-none .col-md-6.col-12.mb-4').each(function() {
                var card = $(this);
                var cardStatus = card.find('[data-card-status]').data('card-status') || '';
                var cardVerification = card.find('[data-card-verification]').data('card-verification') || '';
                var cardText = card.text().toLowerCase();

                var statusMatch = !status || cardStatus === status;
                var verificationMatch = !verification || cardVerification === verification;
                var searchMatch = !search || cardText.indexOf(search) !== -1;

                if (statusMatch && verificationMatch && searchMatch) {
                    card.show();
                } else {
                    card.hide();
                }
            });

            // Show empty state if no visible cards
            var visibleCards = $('.d-lg-none .col-md-6.col-12.mb-4:visible').length;
            var emptyState = $('#cars-mobile-empty');
            if (visibleCards === 0) {
                if (!emptyState.length) {
                    $('.d-lg-none .row').append('<div id="cars-mobile-empty" class="col-12 text-center py-4"><i class="fas fa-car fa-2x text-muted mb-2 d-block"></i><p class="text-muted mb-0">No cars match your search.</p></div>');
                }
            } else {
                emptyState.remove();
            }
        }

        $('#cars-mobile-search').on('input', function() {
            filterMobileCards();
        });
    });
    </script>
    </x-slot>
</x-dynamic-component>
