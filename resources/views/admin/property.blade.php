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
                    <!-- Desktop Table View -->
                    <div id="prop-table-view">
                        <div class="table-responsive">
                            <table class="table table-responsive-md datatable-enabled">
                            <thead>
                                <tr>
                                    <th><strong>TITLE & TYPE</strong></th>
                                    <th><strong>LOCATION</strong></th>
                                    <th><strong>DETAILS</strong></th>
                                    <th><strong>RATE TYPE</strong></th>
                                    <th><strong>RATE</strong></th>
                                    <th><strong>SECURITY DEPOSIT</strong></th>
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
                                    <td><span class="badge light badge-info">{{ ucfirst($property->rate_type ?? 'daily') }}</span></td>
                                    <td>₱{{ number_format($property->monthly_rate, 2) }}</td>
                                    <td>₱{{ number_format($property->security_deposit, 2) }}</td>
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
                                            <a href="#" class="btn btn-warning shadow btn-xs sharp me-1" title="Toggle Status" onclick="event.preventDefault(); document.getElementById('toggle-status-{{ $property->id }}').submit();"><i class="fas fa-power-off"></i></a>
                                            <button type="button" class="btn btn-danger shadow btn-xs sharp" title="Delete" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $property->id }}">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>
                                        
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="{{ (auth()->user() && auth()->user()->role == 'admin') ? '8' : '7' }}" class="text-center">No properties found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        </div>
                    </div>

                    <!-- Mobile/Tablet Card View -->
                    <div id="prop-card-view">
                        <div class="row">
                            @forelse($properties as $property)
                            <div class="col-md-6 col-12 mb-4">
                                <div class="card border shadow-sm h-100 mb-0">
                                    <div class="card-body p-4">
                                        <div class="d-flex align-items-center mb-3">
                                            @if($property->image)
                                                <img src="{{ asset($property->image) }}" class="rounded-lg me-3 shadow-sm" width="70" height="70" alt="" style="object-fit: cover;">
                                            @else
                                                <div class="bg-light rounded-lg me-3 d-flex align-items-center justify-content-center shadow-sm" style="width: 70px; height: 70px;">
                                                    <i class="fas fa-building text-muted fa-2x"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <h5 class="mb-1 text-primary">{{ $property->title }}</h5>
                                                <span class="text-muted d-block fs-14">
                                                    <i class="fas fa-home me-1"></i>{{ $property->type }}
                                                </span>
                                            </div>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <div class="d-flex align-items-start mb-1">
                                                <i class="fas fa-map-marker-alt text-muted mt-1 me-2" style="width: 15px;"></i>
                                                <span class="text-dark fs-14">{{ $property->city }}, {{ $property->region }}</span>
                                            </div>
                                            <div class="d-flex align-items-start">
                                                <i class="fas fa-bed text-muted mt-1 me-2" style="width: 15px;"></i>
                                                <span class="text-dark fs-14">{{ $property->bedrooms }} BR | {{ $property->bathrooms }} BA | {{ $property->floor_area }} sqm</span>
                                            </div>
                                        </div>

                                        <div class="row mb-3 bg-light rounded p-2 mx-0">
                                            <div class="col-6 px-2 border-end">
                                                <small class="text-muted d-block mb-1">{{ ucfirst($property->rate_type ?? 'daily') }} Rate</small>
                                                <span class="text-black font-w600 fs-15">₱{{ number_format($property->monthly_rate, 2) }}</span>
                                            </div>
                                            <div class="col-6 px-2">
                                                <small class="text-muted d-block mb-1">Security Deposit</small>
                                                <span class="text-black font-w600 fs-15">₱{{ number_format($property->security_deposit, 2) }}</span>
                                            </div>
                                        </div>
                                        
                                        <div class="row mb-3">
                                            <div class="col-6">
                                                <small class="text-muted d-block mb-1">Status</small>
                                                @if($property->is_available)
                                                    <span class="badge light badge-success badge-sm">Available</span>
                                                @else
                                                    <span class="badge light badge-warning badge-sm">Unavailable</span>
                                                @endif
                                            </div>
                                            @if(auth()->user() && auth()->user()->role == 'admin')
                                            <div class="col-6">
                                                <small class="text-muted d-block mb-1">Owner</small>
                                                <span class="text-black fs-14"><i class="fas fa-user-circle me-1 text-muted"></i>{{ $property->user->name ?? 'N/A' }}</span>
                                            </div>
                                            @endif
                                        </div>
                                        
                                        <div class="d-flex gap-2 pt-2 border-top">
                                            <a href="#" class="btn btn-outline-primary btn-sm flex-grow-1" title="Edit" data-bs-toggle="modal" data-bs-target="#editPropertyModal" onclick="populateEditModal({{ json_encode($property) }})"><i class="fas fa-pencil-alt me-1"></i> Edit</a>
                                            <a href="#" class="btn btn-outline-warning btn-sm flex-grow-1" title="Toggle Status" onclick="event.preventDefault(); document.getElementById('toggle-status-{{ $property->id }}').submit();"><i class="fas fa-power-off me-1"></i> Status</a>
                                            <button type="button" class="btn btn-outline-danger btn-sm flex-grow-1" title="Delete" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $property->id }}">
                                                <i class="fa fa-trash me-1"></i> Delete
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="col-12 text-center py-5">
                                <i class="fas fa-building fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">No properties found.</h5>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function applyPropertyResponsiveView() {
            var tableView = document.getElementById('prop-table-view');
            var cardView = document.getElementById('prop-card-view');
            if (!tableView || !cardView) return;
            if (window.innerWidth >= 992) {
                tableView.style.setProperty('display', 'block', 'important');
                cardView.style.setProperty('display', 'none', 'important');
            } else {
                tableView.style.setProperty('display', 'none', 'important');
                cardView.style.setProperty('display', 'block', 'important');
            }
        }
        applyPropertyResponsiveView();
        window.addEventListener('resize', applyPropertyResponsiveView);
    </script>

    <!-- Add Property Modal -->
    <div class="modal fade" id="addPropertyModal">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Property</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('properties.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group mb-3 text-center">
                            <label class="text-black font-w500 d-block">Property Image</label>
                            <div class="image-placeholder mb-2">
                                <img id="add_image_preview" src="#" alt="Preview" class="d-none" style="width: 100%; height: 150px; object-fit: cover; border-radius: 10px;">
                                <div id="add_image_icon" class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 150px;">
                                    <i class="fas fa-image fa-3x text-muted"></i>
                                </div>
                            </div>
                            <input type="file" name="image" class="form-control" onchange="previewImage(this, 'add_image_preview', 'add_image_icon')">
                        </div>
                        <div class="form-group mb-3">
                            <label class="text-black font-w500">Property Title</label>
                            <input type="text" name="title" class="form-control" required placeholder="e.g. Modern 2BR Condo">
                        </div>
                        <div class="form-group mb-3">
                            <label class="text-black font-w500">Property Type</label>
                            <select name="type" class="form-control">
                                <option value="Apartment">Apartment</option>
                                <option value="House">House</option>
                                <option value="Condo">Condo</option>
                                <option value="Commercial">Commercial</option>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label class="text-black font-w500">Address</label>
                            <textarea name="address" class="form-control" rows="2" required></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label class="text-black font-w500">City</label>
                                <input type="text" name="city" class="form-control" required>
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label class="text-black font-w500">Region</label>
                                <input type="text" name="region" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 form-group mb-3">
                                <label class="text-black font-w500 text-nowrap">Bedrooms</label>
                                <input type="number" name="bedrooms" class="form-control">
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label class="text-black font-w500 text-nowrap">Bathrooms</label>
                                <input type="number" name="bathrooms" class="form-control">
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label class="text-black font-w500 text-nowrap">Floor Area (sqm)</label>
                                <input type="number" name="floor_area" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 form-group mb-3">
                                <label class="text-black font-w500">Rate Type</label>
                                <select name="rate_type" class="form-control">
                                    <option value="daily" selected>Daily</option>
                                    <option value="monthly">Monthly</option>
                                </select>
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label class="text-black font-w500">Rate (₱)</label>
                                <input type="number" step="0.01" name="monthly_rate" class="form-control" required placeholder="0.00">
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label class="text-black font-w500">Sec. Deposit (₱)</label>
                                <input type="number" step="0.01" name="security_deposit" class="form-control" value="3000.00" required>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label class="text-black font-w500">Description</label>
                            <textarea name="description" class="form-control" rows="3"></textarea>
                        </div>
                        <div class="form-group mb-3">
                            <button type="submit" class="btn btn-primary d-block w-100">Add Property</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Edit Property Modal -->
    <div class="modal fade" id="editPropertyModal">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Property</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editPropertyForm" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group mb-3 text-center">
                            <label class="text-black font-w500 d-block">Property Image</label>
                            <div class="image-placeholder mb-2">
                                <img id="edit_image_preview" src="#" alt="Preview" class="d-none" style="width: 100%; height: 150px; object-fit: cover; border-radius: 10px;">
                                <div id="edit_image_icon" class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 150px;">
                                    <i class="fas fa-image fa-3x text-muted"></i>
                                </div>
                            </div>
                            <input type="file" name="image" class="form-control" onchange="previewImage(this, 'edit_image_preview', 'edit_image_icon')">
                        </div>
                        <div class="form-group mb-3">
                            <label class="text-black font-w500">Property Title</label>
                            <input type="text" id="edit_title" name="title" class="form-control" required>
                        </div>
                        <div class="form-group mb-3">
                            <label class="text-black font-w500">Property Type</label>
                            <select id="edit_type" name="type" class="form-control">
                                <option value="Apartment">Apartment</option>
                                <option value="House">House</option>
                                <option value="Condo">Condo</option>
                                <option value="Commercial">Commercial</option>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label class="text-black font-w500">Address</label>
                            <textarea id="edit_address" name="address" class="form-control" rows="2" required></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label class="text-black font-w500">City</label>
                                <input type="text" id="edit_city" name="city" class="form-control" required>
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label class="text-black font-w500">Region</label>
                                <input type="text" id="edit_region" name="region" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 form-group mb-3">
                                <label class="text-black font-w500 text-nowrap">Bedrooms</label>
                                <input type="number" id="edit_bedrooms" name="bedrooms" class="form-control">
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label class="text-black font-w500 text-nowrap">Bathrooms</label>
                                <input type="number" id="edit_bathrooms" name="bathrooms" class="form-control">
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label class="text-black font-w500 text-nowrap">Floor Area (sqm)</label>
                                <input type="number" id="edit_floor_area" name="floor_area" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 form-group mb-3">
                                <label class="text-black font-w500">Rate Type</label>
                                <select id="edit_rate_type" name="rate_type" class="form-control">
                                    <option value="daily">Daily</option>
                                    <option value="monthly">Monthly</option>
                                </select>
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label class="text-black font-w500">Rate (₱)</label>
                                <input type="number" step="0.01" id="edit_monthly_rate" name="monthly_rate" class="form-control" required>
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label class="text-black font-w500">Sec. Deposit (₱)</label>
                                <input type="number" step="0.01" id="edit_security_deposit" name="security_deposit" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label class="text-black font-w500">Description</label>
                            <textarea id="edit_description" name="description" class="form-control" rows="3"></textarea>
                        </div>
                        <div class="form-group mb-3">
                            <button type="submit" class="btn btn-primary d-block w-100">Update Property</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <script>
    function populateEditModal(property) {
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
        document.getElementById('edit_security_deposit').value = property.security_deposit;
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
    </script>
    @foreach($properties as $property)
    <!-- Toggle Status Form -->
    <form id="toggle-status-{{ $property->id }}" action="{{ route('properties.toggle-status', $property) }}" method="POST" class="d-none">
        @csrf
        @method('PATCH')
    </form>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal{{ $property->id }}">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirm Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center py-4">
                    <div class="mb-3 text-danger">
                        <i class="fas fa-exclamation-triangle fa-4x"></i>
                    </div>
                    <p class="mb-0 fs-5 text-danger fw-bold">Warning: Permanent Action</p>
                    <p class="mt-2 fs-5">Are you sure you want to delete property <strong>{{ $property->title }}</strong>? This cannot be undone.</p>
                </div>
                <div class="modal-footer border-0 pt-0 justify-content-center">
                    <button type="button" class="btn btn-light btn-sm px-4" data-bs-dismiss="modal">Cancel</button>
                    <form action="{{ route('properties.destroy', $property) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm px-4">Yes, Delete Permanently</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</x-dynamic-component>
