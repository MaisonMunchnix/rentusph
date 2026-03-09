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
                                            <a href="#" class="btn btn-warning shadow btn-xs sharp me-1" title="Toggle Status" onclick="event.preventDefault(); confirmToggleStatus({{ $car->id }}, {{ $car->is_available ? 'true' : 'false' }});"><i class="fas fa-power-off"></i></a>
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
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Car</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('cars.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group mb-3 text-center">
                            <label class="text-black font-w500 d-block">Car Image</label>
                            <div class="image-placeholder mb-2">
                                <img id="add_image_preview" src="#" alt="Preview" class="d-none" style="width: 100%; height: 150px; object-fit: cover; border-radius: 10px;">
                                <div id="add_image_icon" class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 150px;">
                                    <i class="fas fa-image fa-3x text-muted"></i>
                                </div>
                            </div>
                            <input type="file" name="image" class="form-control" onchange="previewImage(this, 'add_image_preview', 'add_image_icon')">
                        </div>
                        <div class="form-group mb-3">
                            <label class="text-black font-w500">Brand</label>
                            <input type="text" name="brand" class="form-control" required>
                        </div>
                        <div class="form-group mb-3">
                            <label class="text-black font-w500">Model</label>
                            <input type="text" name="model" class="form-control" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label class="text-black font-w500">Year</label>
                                <input type="number" name="year" class="form-control" required>
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label class="text-black font-w500">Color</label>
                                <input type="text" name="color" class="form-control">
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label class="text-black font-w500">Plate Number (Unique)</label>
                            <input type="text" name="plate_number" class="form-control" required>
                        </div>
                        <div class="row">
                            <div class="col-md-4 form-group mb-3">
                                <label class="text-black font-w500">Capacity (Pax)</label>
                                <input type="number" name="capacity" class="form-control">
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label class="text-black font-w500">Transmission</label>
                                <select name="transmission" class="form-control">
                                    <option value="Automatic">Automatic</option>
                                    <option value="Manual">Manual</option>
                                </select>
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label class="text-black font-w500">Fuel Type</label>
                                <select name="fuel_type" class="form-control">
                                    <option value="Gas">Gas</option>
                                    <option value="Diesel">Diesel</option>
                                    <option value="Electric">Electric</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label class="text-black font-w500 text-nowrap">Daily Rate (₱) <small class="text-muted">(500-20k)</small></label>
                                <input type="number" step="0.01" name="daily_rate" class="form-control" min="500" max="20000" required>
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label class="text-black font-w500 text-nowrap">Security Deposit (₱) <small class="text-muted">(1k-50k)</small></label>
                                <input type="number" step="0.01" name="security_deposit" class="form-control" value="3000.00" min="1000" max="50000" required>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label class="text-black font-w500">Description</label>
                            <textarea name="description" class="form-control" rows="3"></textarea>
                        </div>
                        <div class="form-group mb-3">
                            <button type="submit" class="btn btn-primary d-block w-100">Add Car</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Edit Car Modal -->
    <div class="modal fade" id="editCarModal">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Car</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editCarForm" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group mb-3 text-center">
                            <label class="text-black font-w500 d-block">Car Image</label>
                            <div class="image-placeholder mb-2">
                                <img id="edit_image_preview" src="#" alt="Preview" class="d-none" style="width: 100%; height: 150px; object-fit: cover; border-radius: 10px;">
                                <div id="edit_image_icon" class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 150px;">
                                    <i class="fas fa-image fa-3x text-muted"></i>
                                </div>
                            </div>
                            <input type="file" name="image" class="form-control" onchange="previewImage(this, 'edit_image_preview', 'edit_image_icon')">
                        </div>
                        <div class="form-group mb-3">
                            <label class="text-black font-w500">Brand</label>
                            <input type="text" id="edit_brand" name="brand" class="form-control" required>
                        </div>
                        <div class="form-group mb-3">
                            <label class="text-black font-w500">Model</label>
                            <input type="text" id="edit_model" name="model" class="form-control" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label class="text-black font-w500">Year</label>
                                <input type="number" id="edit_year" name="year" class="form-control" required>
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label class="text-black font-w500">Color</label>
                                <input type="text" id="edit_color" name="color" class="form-control">
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label class="text-black font-w500">Plate Number</label>
                            <input type="text" id="edit_plate_number" name="plate_number" class="form-control" required>
                        </div>
                        <div class="row">
                            <div class="col-md-4 form-group mb-3">
                                <label class="text-black font-w500">Capacity (Pax)</label>
                                <input type="number" id="edit_capacity" name="capacity" class="form-control">
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label class="text-black font-w500">Transmission</label>
                                <select id="edit_transmission" name="transmission" class="form-control">
                                    <option value="Automatic">Automatic</option>
                                    <option value="Manual">Manual</option>
                                </select>
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label class="text-black font-w500">Fuel Type</label>
                                <select id="edit_fuel_type" name="fuel_type" class="form-control">
                                    <option value="Gas">Gas</option>
                                    <option value="Diesel">Diesel</option>
                                    <option value="Electric">Electric</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label class="text-black font-w500 text-nowrap">Daily Rate (₱) <small class="text-muted">(500-20k)</small></label>
                                <input type="number" step="0.01" id="edit_daily_rate" name="daily_rate" class="form-control" min="500" max="20000" required>
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label class="text-black font-w500 text-nowrap">Security Deposit (₱) <small class="text-muted">(1k-50k)</small></label>
                                <input type="number" step="0.01" id="edit_security_deposit" name="security_deposit" class="form-control" min="1000" max="50000" required>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label class="text-black font-w500">Description</label>
                            <textarea id="edit_description" name="description" class="form-control" rows="3"></textarea>
                        </div>
                        <div class="form-group mb-3">
                            <button type="submit" class="btn btn-primary d-block w-100">Update Car</button>
                        </div>
                    </form>
                </div>
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
            const action = isAvailable ? 'deactivate' : 'activate';
            const color = isAvailable ? '#eab308' : '#22c55e';

            Swal.fire({
                title: 'Are you sure?',
                text: `Do you want to ${action} this car?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: color,
                cancelButtonColor: '#d33',
                confirmButtonText: `Yes, ${action} it!`,
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('toggle-status-' + carId).submit();
                }
            });
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
    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal{{ $car->id }}">
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
                    <p class="mt-2 fs-5">Are you sure you want to delete <strong>{{ $car->brand }} {{ $car->model }}</strong>? This cannot be undone.</p>
                </div>
                <div class="modal-footer border-0 pt-0 justify-content-center">
                    <button type="button" class="btn btn-light btn-sm px-4" data-bs-dismiss="modal">Cancel</button>
                    <form action="{{ route('cars.destroy', $car) }}" method="POST">
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
