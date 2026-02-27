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
                                    <th><strong>MONTHLY RATE</strong></th>
                                    <th><strong>STATUS</strong></th>
                                    @if(auth()->user() && auth()->user()->role == 'admin')
                                    <th><strong>OWNER</strong></th>
                                    @endif
                                    <th><strong>ACTION</strong></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($properties as $property)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <span class="w-space-no"><strong>{{ $property->title }}</strong><br><small>{{ $property->type }}</small></span>
                                        </div>
                                    </td>
                                    <td>{{ $property->city }}, {{ $property->region }}</td>
                                    <td>{{ $property->bedrooms }} BR | {{ $property->bathrooms }} BA | {{ $property->floor_area }} sqm</td>
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
                                        <div class="d-flex">
                                            <a href="#" class="btn btn-primary shadow btn-xs sharp me-1" title="Edit" data-bs-toggle="modal" data-bs-target="#editPropertyModal" onclick="populateEditModal({{ json_encode($property) }})"><i class="fas fa-pencil-alt"></i></a>
                                            <a href="#" class="btn btn-warning shadow btn-xs sharp me-1" title="Toggle Status" onclick="event.preventDefault(); document.getElementById('toggle-status-{{ $property->id }}').submit();"><i class="fas fa-power-off"></i></a>
                                            <a href="#" class="btn btn-danger shadow btn-xs sharp" title="Delete" onclick="event.preventDefault(); if(confirm('Are you sure you want to delete this property?')) document.getElementById('delete-property-{{ $property->id }}').submit();"><i class="fa fa-trash"></i></a>
                                        </div>
                                        
                                        <!-- Actions Hidden Forms -->
                                        <form id="toggle-status-{{ $property->id }}" action="{{ route('properties.toggle-status', $property->id) }}" method="POST" style="display: none;">
                                            @csrf
                                            @method('PATCH')
                                        </form>
                                        <form id="delete-property-{{ $property->id }}" action="{{ route('properties.destroy', $property->id) }}" method="POST" style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
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
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Property</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('properties.store') }}" method="POST">
                        @csrf
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
                                <label class="text-black font-w500">Bedrooms</label>
                                <input type="number" name="bedrooms" class="form-control">
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label class="text-black font-w500">Bathrooms</label>
                                <input type="number" name="bathrooms" class="form-control">
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label class="text-black font-w500">Floor Area (sqm)</label>
                                <input type="number" name="floor_area" class="form-control">
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label class="text-black font-w500">Monthly Rate (₱)</label>
                            <input type="number" step="0.01" name="monthly_rate" class="form-control" required>
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
                    <form id="editPropertyForm" method="POST">
                        @csrf
                        @method('PUT')
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
                                <label class="text-black font-w500">Bedrooms</label>
                                <input type="number" id="edit_bedrooms" name="bedrooms" class="form-control">
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label class="text-black font-w500">Bathrooms</label>
                                <input type="number" id="edit_bathrooms" name="bathrooms" class="form-control">
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label class="text-black font-w500">Floor Area (sqm)</label>
                                <input type="number" id="edit_floor_area" name="floor_area" class="form-control">
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label class="text-black font-w500">Monthly Rate (₱)</label>
                            <input type="number" step="0.01" id="edit_monthly_rate" name="monthly_rate" class="form-control" required>
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
        document.getElementById('edit_monthly_rate').value = property.monthly_rate;
        document.getElementById('edit_description').value = property.description;
        
        // Dynamically update the form action URL
        const form = document.getElementById('editPropertyForm');
        form.action = `/properties/${property.id}`;
    }
    </script>
</x-dynamic-component>
