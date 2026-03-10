@php
    $layout = auth()->user()->role === 'admin' ? 'layouts.admin' : 'layouts.affiliate';
@endphp

<x-dynamic-component :component="$layout">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header border-0 pb-0 flex-wrap">
                    <h4 class="card-title">{{ auth()->user()->role === 'admin' ? 'Car Management' : 'My Cars' }}</h4>
                    <button class="btn btn-primary btn-sm mt-3 mt-sm-0" data-bs-toggle="modal" data-bs-target="#addCarModal">
                        <i class="fas fa-plus me-2"></i>Add Car
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-responsive-md">
                            <thead>
                                <tr>
                                    <th><strong>BRAND & MODEL</strong></th>
                                    <th><strong>YEAR</strong></th>
                                    <th><strong>PLATE NO.</strong></th>
                                    <th><strong>CAPACITY/TYPE</strong></th>
                                    <th><strong>DAILY RATE</strong></th>
                                    <th><strong>SECURITY DEPOSIT</strong></th>
                                    <th><strong>STATUS</strong></th>
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
                                    <td>
                                        @if($car->is_available)
                                            <span class="badge light badge-success">Available</span>
                                        @else
                                            <span class="badge light badge-warning">Unavailable</span>
                                        @endif
                                    </td>
                                    @if(auth()->user() && auth()->user()->role == 'admin')
                                    <td>{{ $car->user->name ?? 'N/A' }}</td>
                                    @endif
                                    <td>
                                        <div class="d-flex justify-content-end">
                                            <a href="#" class="btn btn-primary shadow btn-xs sharp me-1" title="Edit" data-bs-toggle="modal" data-bs-target="#editCarModal" onclick="populateEditModal({{ json_encode($car) }})"><i class="fas fa-pencil-alt"></i></a>
                                            <a href="#" class="btn btn-warning shadow btn-xs sharp me-1" title="{{ $car->is_available ? 'Deactivate' : 'Activate' }} Car" data-bs-toggle="modal" data-bs-target="#statusModal{{ $car->id }}"><i class="fas fa-power-off"></i></a>
                                            <button type="button" class="btn btn-danger shadow btn-xs sharp" title="Delete" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $car->id }}">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>
                                        
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="{{ (auth()->user() && auth()->user()->role == 'admin') ? '9' : '8' }}" class="text-center">No cars found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
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
                                    <label class="text-black font-w600 d-block mb-3">Vehicle Photography</label>
                                    <div class="image-placeholder mb-3">
                                        <img id="add_image_preview" src="#" alt="Preview" class="d-none w-100 shadow-sm" style="height: 220px; object-fit: cover; border-radius: 15px;">
                                        <div id="add_image_icon" class="bg-light rounded d-flex align-items-center justify-content-center shadow-inner" style="height: 220px; border: 2px dashed #cbd5e1;">
                                            <div class="text-center">
                                                <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-2"></i>
                                                <p class="mb-0 text-muted font-w500">Upload Car Image</p>
                                                <small class="text-muted">(JPG, PNG max 2MB)</small>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="file" name="image" class="form-control" onchange="previewImage(this, 'add_image_preview', 'add_image_icon')" style="cursor: pointer;">
                                </div>
                                
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
                                    <label class="text-black font-w600 d-block mb-3">Vehicle Photography</label>
                                    <div class="image-placeholder mb-3">
                                        <img id="edit_image_preview" src="#" alt="Preview" class="d-none w-100 shadow-sm" style="height: 220px; object-fit: cover; border-radius: 15px;">
                                        <div id="edit_image_icon" class="bg-light rounded d-flex align-items-center justify-content-center shadow-inner" style="height: 220px; border: 2px dashed #cbd5e1;">
                                            <div class="text-center">
                                                <i class="fas fa-image fa-3x text-muted mb-2"></i>
                                                <p class="mb-0 text-muted font-w500">Vehicle Photo</p>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="file" name="image" class="form-control" onchange="previewImage(this, 'edit_image_preview', 'edit_image_icon')" style="cursor: pointer;">
                                    <small class="text-muted d-block mt-2">Upload a new image to replace the current one.</small>
                                </div>

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


        @if(session('success'))
            Swal.fire({
                title: 'Success!',
                text: "{{ session('success') }}",
                icon: 'success',
                confirmButtonColor: '#eab308'
            });
        @endif

        function populateEditModal(car) {
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
</x-dynamic-component>
