@php
    $layout = auth()->user()->role === 'admin' ? 'layouts.admin' : 'layouts.affiliate';
@endphp

<x-dynamic-component :component="$layout">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header border-0 pb-0 flex-wrap">
                    <h4 class="card-title">Car Management</h4>
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
                                    <th><strong>STATUS</strong></th>
                                    @if(auth()->user() && auth()->user()->role == 'admin')
                                    <th><strong>OWNER</strong></th>
                                    @endif
                                    <th><strong>ACTION</strong></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($cars as $car)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <span class="w-space-no">{{ $car->brand }} {{ $car->model }}</span>
                                        </div>
                                    </td>
                                    <td>{{ $car->year }}</td>
                                    <td>{{ $car->plate_number }}</td>
                                    <td>{{ $car->capacity }} Pax / {{ $car->transmission }}</td>
                                    <td>₱{{ number_format($car->daily_rate, 2) }}</td>
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
                                        <div class="d-flex">
                                            <a href="#" class="btn btn-primary shadow btn-xs sharp me-1" title="Edit" data-bs-toggle="modal" data-bs-target="#editCarModal" onclick="populateEditModal({{ json_encode($car) }})"><i class="fas fa-pencil-alt"></i></a>
                                            <a href="#" class="btn btn-warning shadow btn-xs sharp me-1" title="Toggle Status" onclick="event.preventDefault(); document.getElementById('toggle-status-{{ $car->id }}').submit();"><i class="fas fa-power-off"></i></a>
                                            <a href="#" class="btn btn-danger shadow btn-xs sharp" title="Delete" onclick="event.preventDefault(); if(confirm('Are you sure you want to delete this car?')) document.getElementById('delete-car-{{ $car->id }}').submit();"><i class="fa fa-trash"></i></a>
                                        </div>
                                        
                                        <!-- Actions Hidden Forms -->
                                        <form id="toggle-status-{{ $car->id }}" action="{{ route('cars.toggle-status', $car->id) }}" method="POST" style="display: none;">
                                            @csrf
                                            @method('PATCH')
                                        </form>
                                        <form id="delete-car-{{ $car->id }}" action="{{ route('cars.destroy', $car->id) }}" method="POST" style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="{{ (auth()->user() && auth()->user()->role == 'admin') ? '8' : '7' }}" class="text-center">No cars found.</td>
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
                    <form action="{{ route('cars.store') }}" method="POST">
                        @csrf
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
                        <div class="form-group mb-3">
                            <label class="text-black font-w500">Daily Rate (₱)</label>
                            <input type="number" step="0.01" name="daily_rate" class="form-control" required>
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
                    <form id="editCarForm" method="POST">
                        @csrf
                        @method('PUT')
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
                        <div class="form-group mb-3">
                            <label class="text-black font-w500">Daily Rate (₱)</label>
                            <input type="number" step="0.01" id="edit_daily_rate" name="daily_rate" class="form-control" required>
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
    
    <script>
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
        document.getElementById('edit_description').value = car.description;
        
        // Dynamically update the form action URL
        const form = document.getElementById('editCarForm');
        form.action = `/cars/${car.id}`;
    }
    </script>
</x-dynamic-component>
