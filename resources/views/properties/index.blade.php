@php
    $layout = auth()->user()->role === 'admin' ? 'layouts.admin' : 'layouts.affiliate';
@endphp

<x-dynamic-component :component="$layout">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header border-0 pb-0 flex-wrap">
                    <h4 class="card-title">Property Management</h4>
                    <button class="btn btn-primary btn-sm mt-3 mt-sm-0" data-bs-toggle="modal" data-bs-target="#addPropertyModal">
                        <i class="fas fa-plus me-2"></i>Add Property
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-responsive-md">
                            <thead>
                                <tr>
                                    <th><strong>TITLE & TYPE</strong></th>
                                    <th><strong>LOCATION</strong></th>
                                    <th><strong>DETAILS</strong></th>
                                    <th><strong>RATE TYPE</strong></th>
                                    <th><strong>RATE</strong></th>
                                    <th><strong>STATUS</strong></th>
                                    @if(auth()->user() && auth()->user()->role == 'admin')
                                    <th><strong>OWNER</strong></th>
                                    @endif
                                    <th class="text-end"><strong>ACTION</strong></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($properties as $property)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($property->image)
                                                <img src="{{ asset($property->image) }}" class="rounded-lg me-2" width="50" height="50" alt="" style="object-fit: cover;">
                                            @else
                                                <div class="bg-light rounded-lg me-2 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                                    <i class="fas fa-building text-muted"></i>
                                                </div>
                                            @endif
                                            <span class="w-space-no"><strong>{{ $property->title }}</strong><br><small>{{ $property->type }}</small></span>
                                        </div>
                                    </td>
                                    <td>{{ $property->city }}, {{ $property->region }}</td>
                                    <td>{{ $property->bedrooms }} BR | {{ $property->bathrooms }} BA | {{ $property->floor_area }} sqm</td>
                                    <td><span class="badge light badge-dark">{{ ucfirst($property->rate_type ?? 'daily') }}</span></td>
                                    <td>₱{{ number_format($property->monthly_rate, 2) }}</td>
                                    <td>
                                        @if($property->is_available)
                                            <span class="badge light badge-success">Available</span>
                                        @else
                                            <span class="badge light badge-warning">Unavailable</span>
                                        @endif
                                    </td>
                                    @if(auth()->user() && auth()->user()->role == 'admin')
                                    <td>{{ $property->user->name ?? 'N/A' }}</td>
                                    @endif
                                    <td>
                                        <div class="d-flex justify-content-end">
                                            <a href="#" class="btn btn-primary shadow btn-xs sharp me-1" title="Edit" data-bs-toggle="modal" data-bs-target="#editPropertyModal" onclick="populateEditModal({{ json_encode($property) }})"><i class="fas fa-pencil-alt"></i></a>
                                            <a href="#" class="btn btn-warning shadow btn-xs sharp me-1" title="Toggle Status" 
                                               data-bs-toggle="modal" data-bs-target="#statusModal{{ $property->id }}">
                                                <i class="fas fa-power-off"></i>
                                            </a>
                                            <a href="#" class="btn btn-danger shadow btn-xs sharp" title="Delete" 
                                               data-bs-toggle="modal" data-bs-target="#deleteModal{{ $property->id }}">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </div>
                                        
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="{{ (auth()->user() && auth()->user()->role == 'admin') ? '7' : '6' }}" class="text-center">No properties found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Property Modal -->
    <div class="modal fade" id="addPropertyModal">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-700">
                        <i class="fas fa-plus-circle text-primary me-2"></i>Add New Property
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body pt-2">
                    <form action="{{ route('properties.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <!-- Left Column: Image and Basic Info -->
                            <div class="col-md-5 border-end">
                                <div class="form-group mb-4 text-center">
                                    <label class="text-black fw-600 d-block mb-2">Property Photo (Cover)</label>
                                    <div class="image-placeholder mb-3 position-relative overflow-hidden rounded-lg shadow-sm" style="height: 200px; background: #f8f9fa; cursor: pointer;" onclick="document.getElementById('add_image_input').click()">
                                        <img id="add_image_preview" src="#" alt="Preview" class="d-none w-100 h-100" style="object-fit: cover;">
                                        <div id="add_image_icon" class="d-flex flex-column align-items-center justify-content-center h-100 text-muted">
                                            <i class="fas fa-cloud-upload-alt fa-3x mb-2"></i>
                                            <small>Click to upload cover photo</small>
                                        </div>
                                    </div>
                                    <input type="file" id="add_image_input" name="image" class="form-control mb-4" onchange="previewImage(this, 'add_image_preview', 'add_image_icon')" required>
                                </div>

                                <hr class="my-3 opacity-50">
                                <h6 class="text-primary fw-700 mb-3"><i class="fas fa-images me-2"></i>Photo Gallery</h6>
                                <div class="form-group mb-4">
                                    <label class="text-black fw-600 mb-1">Upload Gallery Photos</label>
                                    <input type="file" name="gallery_photos[]" class="form-control mb-2" accept="image/*" multiple style="cursor: pointer;">
                                    <small class="text-muted d-block">Select multiple photos. Images are automatically compressed.</small>
                                </div>

                                <div class="form-group mb-3">
                                    <label class="text-black fw-600 mb-1"><i class="fas fa-tag me-1 small text-primary"></i> Property Title</label>
                                    <input type="text" name="title" class="form-control" required placeholder="e.g. Modern 2BR Condo">
                                </div>

                                <div class="form-group mb-3">
                                    <label class="text-black fw-600 mb-1"><i class="fas fa-building me-1 small text-primary"></i> Property Type</label>
                                    <select name="type" class="form-control default-select">
                                        <option value="Apartment">Apartment</option>
                                        <option value="House">House</option>
                                        <option value="Condo">Condo</option>
                                        <option value="Commercial">Commercial</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Right Column: Location and Details -->
                            <div class="col-md-7 ps-md-4">
                                <h6 class="text-primary fw-700 mb-3 border-bottom pb-2">Location & Details</h6>
                                
                                <div class="form-group mb-3">
                                    <label class="text-black fw-600 mb-1"><i class="fas fa-map-marker-alt me-1 small text-primary"></i> Full Address</label>
                                    <textarea name="address" class="form-control" rows="2" required placeholder="Street address, Village/Bldg..."></textarea>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-sm-6">
                                        <label class="text-black fw-600 mb-1">City</label>
                                        <input type="text" name="city" class="form-control" required placeholder="City">
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="text-black fw-600 mb-1">Region</label>
                                        <input type="text" name="region" class="form-control" placeholder="Province/Region">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-4">
                                        <label class="text-black fw-600 mb-1 small text-nowrap">Bedrooms</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white border-end-0"><i class="fas fa-bed text-muted"></i></span>
                                            <input type="number" name="bedrooms" class="form-control border-start-0 ps-0" placeholder="0">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <label class="text-black fw-600 mb-1 small text-nowrap">Bathrooms</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white border-end-0"><i class="fas fa-bath text-muted"></i></span>
                                            <input type="number" name="bathrooms" class="form-control border-start-0 ps-0" placeholder="0">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <label class="text-black fw-600 mb-1 small text-nowrap">Area (sqm)</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white border-end-0"><i class="fas fa-vector-square text-muted"></i></span>
                                            <input type="number" name="floor_area" class="form-control border-start-0 ps-0" placeholder="0">
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-sm-4">
                                        <label class="text-black fw-600 mb-1">Rate Type</label>
                                        <select name="rate_type" class="form-control default-select form-control-lg">
                                            <option value="daily" selected>Daily Payment</option>
                                            <option value="monthly">Monthly Payment</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-4">
                                        <label class="text-black fw-600 mb-1">Price (₱)</label>
                                        <div class="input-group input-group-lg">
                                            <span class="input-group-text bg-success text-white border-0">₱</span>
                                            <input type="number" step="0.01" name="monthly_rate" class="form-control" required placeholder="0.00">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <label class="text-black fw-600 mb-1">Deposit (₱)</label>
                                        <div class="input-group input-group-lg">
                                            <span class="input-group-text bg-warning text-white border-0">₱</span>
                                            <input type="number" step="0.01" name="security_deposit" class="form-control" required placeholder="0.00">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mb-0">
                                    <label class="text-black fw-600 mb-1">Description</label>
                                    <textarea name="description" class="form-control" rows="3" placeholder="Additional features, amenities, or rules..."></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer border-0 px-0 pb-0 mt-3 d-flex justify-content-center">
                            <button type="button" class="btn btn-outline-light px-4 me-2" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary px-5">
                                <i class="fas fa-check-circle me-1"></i> Register Property
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Edit Property Modal -->
    <div class="modal fade" id="editPropertyModal">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-700">
                        <i class="fas fa-edit text-primary me-2"></i>Edit Property
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body pt-2">
                    <form id="editPropertyForm" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <!-- Left Column -->
                            <div class="col-md-5 border-end">
                                <div class="form-group mb-4 text-center">
                                    <label class="text-black fw-600 d-block mb-2">Cover Photo</label>
                                    <div class="image-placeholder mb-3 position-relative overflow-hidden rounded-lg shadow-sm" style="height: 200px; background: #f8f9fa; cursor: pointer;" onclick="document.getElementById('edit_image_input').click()">
                                        <img id="edit_image_preview" src="#" alt="Preview" class="d-none w-100 h-100" style="object-fit: cover;">
                                        <div id="edit_image_icon" class="d-flex flex-column align-items-center justify-content-center h-100 text-muted">
                                            <i class="fas fa-image fa-3x mb-2"></i>
                                            <small>No cover uploaded</small>
                                        </div>
                                    </div>
                                    <input type="file" id="edit_image_input" name="image" class="form-control" onchange="previewImage(this, 'edit_image_preview', 'edit_image_icon')">
                                    <small class="text-muted d-block mt-2">Upload a new image to replace the current cover.</small>
                                </div>

                                <hr class="my-3 opacity-50">
                                <h6 class="text-primary font-w700 mb-3"><i class="fas fa-images me-2"></i>Photo Gallery</h6>
                                <div class="form-group mb-4">
                                    <label class="text-black font-w600">Upload Gallery Photos</label>
                                    <input type="file" id="property_gallery_upload_input" class="form-control mb-2" accept="image/*" multiple style="cursor: pointer;">
                                    <small class="text-muted d-block mb-3">Select multiple photos. Images are automatically compressed.</small>
                                    <button type="button" class="btn btn-sm btn-outline-primary w-100" onclick="uploadPropertyGalleryPhotos()">
                                        <i class="fas fa-upload me-1"></i> Upload Photos
                                    </button>
                                </div>

                                <div class="gallery-preview-container d-flex flex-wrap gap-2 mb-4" id="edit_property_gallery_preview">
                                    <!-- Gallery items injected here via JS -->
                                </div>

                                <div class="form-group mb-3">
                                    <label class="text-black fw-600 mb-1">Property Title</label>
                                    <input type="text" id="edit_title" name="title" class="form-control" required>
                                </div>

                                <div class="form-group mb-3">
                                    <label class="text-black fw-600 mb-1">Property Type</label>
                                    <select id="edit_type" name="type" class="form-control default-select">
                                        <option value="Apartment">Apartment</option>
                                        <option value="House">House</option>
                                        <option value="Condo">Condo</option>
                                        <option value="Commercial">Commercial</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Right Column -->
                            <div class="col-md-7 ps-md-4">
                                <h6 class="text-primary fw-700 mb-3 border-bottom pb-2">Location & Details</h6>
                                
                                <div class="form-group mb-3">
                                    <label class="text-black fw-600 mb-1">Full Address</label>
                                    <textarea id="edit_address" name="address" class="form-control" rows="2" required></textarea>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-6">
                                        <label class="text-black fw-600 mb-1">City</label>
                                        <input type="text" id="edit_city" name="city" class="form-control" required>
                                    </div>
                                    <div class="col-6">
                                        <label class="text-black fw-600 mb-1">Region</label>
                                        <input type="text" id="edit_region" name="region" class="form-control">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-4">
                                        <label class="text-black fw-600 mb-1 small text-nowrap">Bedrooms</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white"><i class="fas fa-bed text-muted"></i></span>
                                            <input type="number" id="edit_bedrooms" name="bedrooms" class="form-control border-start-0 ps-1">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <label class="text-black fw-600 mb-1 small text-nowrap">Bathrooms</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white"><i class="fas fa-bath text-muted"></i></span>
                                            <input type="number" id="edit_bathrooms" name="bathrooms" class="form-control border-start-0 ps-1">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <label class="text-black fw-600 mb-1 small text-nowrap">Area (sqm)</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white"><i class="fas fa-vector-square text-muted"></i></span>
                                            <input type="number" id="edit_floor_area" name="floor_area" class="form-control border-start-0 ps-1">
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-4">
                                        <label class="text-black fw-600 mb-1">Rate Type</label>
                                        <select id="edit_rate_type" name="rate_type" class="form-control default-select form-control-lg">
                                            <option value="daily">Daily</option>
                                            <option value="monthly">Monthly</option>
                                        </select>
                                    </div>
                                    <div class="col-4">
                                        <label class="text-black fw-600 mb-1">Price (₱)</label>
                                        <div class="input-group input-group-lg">
                                            <span class="input-group-text bg-success text-white border-0">₱</span>
                                            <input type="number" step="0.01" id="edit_monthly_rate" name="monthly_rate" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <label class="text-black fw-600 mb-1">Deposit (₱)</label>
                                        <div class="input-group input-group-lg">
                                            <span class="input-group-text bg-warning text-white border-0">₱</span>
                                            <input type="number" step="0.01" id="edit_security_deposit" name="security_deposit" class="form-control" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mb-0">
                                    <label class="text-black fw-600 mb-1">Description</label>
                                    <textarea id="edit_description" name="description" class="form-control" rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer border-0 px-0 pb-0 mt-3 d-flex justify-content-center">
                            <button type="button" class="btn btn-outline-light px-4 me-2" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary px-5">
                                <i class="fas fa-save me-1"></i> Update Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    
    <script>
    let currentEditPropertyId = null;

    function populateEditModal(property) {
        currentEditPropertyId = property.id;
        document.getElementById('edit_title').value = property.title;
        document.getElementById('edit_type').value = property.type;
        document.getElementById('edit_address').value = property.address;
        document.getElementById('edit_city').value = property.city;
        document.getElementById('edit_region').value = property.region;
        document.getElementById('edit_bedrooms').value = property.bedrooms;
        document.getElementById('edit_bathrooms').value = property.bathrooms;
        document.getElementById('edit_floor_area').value = property.floor_area;
        document.getElementById('edit_rate_type').value = property.rate_type || 'daily';
        document.getElementById('edit_monthly_rate').value = property.monthly_rate;
        document.getElementById('edit_security_deposit').value = property.security_deposit || 0;
        document.getElementById('edit_description').value = property.description;
        
        // Dynamically update the form action URL
        const form = document.getElementById('editPropertyForm');
        form.action = `/properties/${property.id}`;

        // Update image preview
        const preview = document.getElementById('edit_image_preview');
        const icon = document.getElementById('edit_image_icon');
        if (property.image) {
            preview.src = `/${property.image}`;
            preview.classList.remove('d-none');
            icon.classList.add('d-none');
        } else {
            preview.classList.add('d-none');
            icon.classList.remove('d-none');
        }

        // Populate Gallery
        const galleryContainer = document.getElementById('edit_property_gallery_preview');
        galleryContainer.innerHTML = '';
        if (property.gallery_images && property.gallery_images.length > 0) {
            property.gallery_images.forEach(img => {
                galleryContainer.innerHTML += `
                    <div class="position-relative d-inline-block">
                        <img src="/${img.path}" class="rounded shadow-sm" style="width: 80px; height: 60px; object-fit: cover;">
                        <button type="button" class="btn btn-danger btn-xs sharp position-absolute" style="top: -5px; right: -5px; width: 20px; height: 20px; padding: 0; display: flex; align-items: center; justify-content: center; z-index: 10;" onclick="deletePropertyGalleryImage(${img.id})">
                            <i class="fas fa-times" style="font-size: 10px;"></i>
                        </button>
                    </div>
                `;
            });
        } else {
            galleryContainer.innerHTML = '<p class="text-muted small mb-0 w-100 text-center py-2 bg-light rounded">No gallery photos yet.</p>';
        }
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

    async function uploadPropertyGalleryPhotos() {
        const input = document.getElementById('property_gallery_upload_input');
        if (!input.files || input.files.length === 0) {
            alert('Please select at least one photo.');
            return;
        }

        const formData = new FormData();
        for (let i = 0; i < input.files.length; i++) {
            formData.append('photos[]', input.files[i]);
        }

        const btn = document.querySelector('button[onclick="uploadPropertyGalleryPhotos()"]');
        const originalText = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Uploading...';
        btn.disabled = true;

        try {
            const response = await fetch(`/properties/${currentEditPropertyId}/gallery`, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: formData
            });

            if (response.ok) {
                window.location.reload();
            } else {
                const data = await response.json();
                alert(data.message || 'Upload failed.');
            }
        } catch (err) {
            alert('An error occurred during upload.');
        } finally {
            btn.innerHTML = originalText;
            btn.disabled = false;
        }
    }

    async function deletePropertyGalleryImage(imageId) {
        if (!confirm('Are you sure you want to delete this photo?')) return;

        try {
            const response = await fetch(`/properties/gallery/${imageId}`, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
            });

            if (response.ok) {
                window.location.reload();
            } else {
                alert('Failed to delete photo.');
            }
        } catch (err) {
            alert('An error occurred.');
        }
    }
    @if($errors->any())
        let errorMessages = '';
        @foreach ($errors->all() as $error)
            errorMessages += '{{ $error }}<br>';
        @endforeach
        alert('Validation Error:\n' + errorMessages.replace(/<br>/g, '\n'));
    @endif

    @if(session('success'))
        document.addEventListener('DOMContentLoaded', function() {
            const modalEl = document.getElementById('successModal');
            if(modalEl) {
                const successModal = new bootstrap.Modal(modalEl);
                successModal.show();
            }
        });
    @endif
    </script>
    @foreach($properties as $property)
    <!-- Status Toggle Modal -->
    <div class="modal fade" id="statusModal{{ $property->id }}">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-700">{{ $property->is_available ? 'Deactivate' : 'Activate' }} Property</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center py-4">
                    <div class="mb-3">
                        @if($property->is_available)
                            <div class="d-inline-flex align-items-center justify-content-center bg-warning-light rounded-circle mb-3" style="width: 80px; height: 80px;">
                                <i class="fas fa-power-off fa-2x text-warning"></i>
                            </div>
                            <p class="mb-0 fs-5 text-warning fw-bold">Disable Property Listing</p>
                        @else
                            <div class="d-inline-flex align-items-center justify-content-center bg-success-light rounded-circle mb-3" style="width: 80px; height: 80px;">
                                <i class="fas fa-check-circle fa-2x text-success"></i>
                            </div>
                            <p class="mb-0 fs-5 text-success fw-bold">Enable Property Listing</p>
                        @endif
                    </div>
                    <p class="mt-2 fs-6">Are you sure you want to <strong>{{ $property->is_available ? 'deactivate' : 'activate' }}</strong> the listing for <strong>{{ $property->title }}</strong>?</p>
                </div>
                <div class="modal-footer border-0 pt-0 justify-content-center pb-4">
                    <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Cancel</button>
                    <form action="{{ route('properties.toggle-status', $property) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn {{ $property->is_available ? 'btn-warning' : 'btn-success' }} px-4">
                            Yes, {{ $property->is_available ? 'Deactivate' : 'Activate' }} Now
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal{{ $property->id }}">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-700">Confirm Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center py-4">
                    <div class="mb-3 text-danger">
                        <i class="fas fa-trash-alt fa-3x"></i>
                    </div>
                    <p class="mb-0 fs-5 text-danger fw-bold">Warning: Permanent Action</p>
                    <p class="mt-2 fs-6">Are you sure you want to delete <strong>{{ $property->title }}</strong>? This cannot be undone.</p>
                </div>
                <div class="modal-footer border-0 pt-0 justify-content-center pb-4">
                    <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Cancel</button>
                    <form action="{{ route('properties.destroy', $property) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger px-4">Delete Permanently</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</x-dynamic-component>
