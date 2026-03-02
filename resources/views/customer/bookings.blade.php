<x-layouts.customer title="My Bookings">
    <x-slot name="styles">
        <style>
            .table-responsive {
                overflow: visible !important;
            }
        </style>
    </x-slot>
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header border-0 pb-0">
                    <h4 class="card-title">My Bookings</h4>
                </div>
                <div class="card-body">
                    @if(isset($bookings) && $bookings->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-responsive-md">
                                <thead>
                                    <tr>
                                        <th><strong>BOOKING ID</strong></th>
                                        <th><strong>CAR/PROPERTY</strong></th>
                                        <th><strong>DATES</strong></th>
                                        <th><strong>TOTAL PRICE</strong></th>
                                        <th><strong>STATUS</strong></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($bookings as $booking)
                                        <tr>
                                            <td><strong>#BK-{{ $booking->id }}</strong></td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    @if($booking->bookable_type === 'App\Models\Car')
                                                        <i class="fas fa-car me-2 text-primary"></i>
                                                        <span class="w-space-no">{{ $booking->bookable->brand ?? 'N/A' }} {{ $booking->bookable->model ?? '' }}</span>
                                                    @else
                                                        <i class="fas fa-home me-2 text-info"></i>
                                                        <span class="w-space-no">{{ $booking->bookable->title ?? 'N/A' }}</span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>{{ $booking->start_date->format('M d, Y') }} - {{ $booking->end_date->format('M d, Y') }}</td>
                                            <td>₱{{ number_format($booking->total_price, 2) }}</td>
                                            <td>
                                                @php
                                                    $badgeClass = match($booking->status) {
                                                        'pending' => 'badge-warning',
                                                        'confirmed' => 'badge-success',
                                                        'cancelled' => 'badge-danger',
                                                        'completed' => 'badge-info',
                                                        default => 'badge-secondary'
                                                    };
                                                @endphp
                                                <span class="badge light {{ $badgeClass }}">{{ ucfirst($booking->status) }}</span>
                                            </td>
                                            <td>
                                                <div class="dropdown">
                                                    <button type="button" class="btn btn-success light sharp" data-bs-toggle="dropdown">
                                                        <svg width="20px" height="20px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"/><circle fill="#000000" cx="5" cy="12" r="2"/><circle fill="#000000" cx="12" cy="12" r="2"/><circle fill="#000000" cx="19" cy="12" r="2"/></g></svg>
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#viewBookingModal{{ $booking->id }}">Edit Details</a>
                                                        @if($booking->status === 'pending')
                                                            <a class="dropdown-item text-danger" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#cancelBookingModal{{ $booking->id }}">Cancel Booking</a>
                                                        @endif
                                                    </div>
                                                </div>

                                                <!-- View/Edit Modal -->
                                                <div class="modal fade" id="viewBookingModal{{ $booking->id }}" tabindex="-1" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Edit Booking Details - #BK-{{ $booking->id }}</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <form action="{{ route('bookings.update', $booking->id) }}" method="POST">
                                                                @csrf
                                                                @method('PUT')
                                                                <div class="modal-body">
                                                                    <div class="row">
                                                                        <div class="col-md-6 mb-3">
                                                                            <label class="form-label font-w600">Car/Property</label>
                                                                            @if($booking->bookable_type === 'App\Models\Car')
                                                                            <input type="text" class="form-control" value="{{ $booking->bookable->brand ?? 'N/A' }} {{ $booking->bookable->model ?? '' }}" readonly>
                                                                            @else
                                                                            <input type="text" class="form-control" value="{{ $booking->bookable->title ?? 'N/A' }}" readonly>
                                                                            @endif
                                                                        </div>
                                                                        <div class="col-md-6 mb-3">
                                                                            <label class="form-label font-w600">Status</label>
                                                                            <input type="text" class="form-control" value="{{ ucfirst($booking->status) }}" readonly>
                                                                        </div>
                                                                    </div>

                                                                    <hr>
                                                                    <h6 class="mb-3 text-primary">Customer Information</h6>
                                                                    
                                                                    <div class="row">
                                                                        <div class="col-md-6 mb-3">
                                                                            <label class="form-label font-w600">Full Name</label>
                                                                            <input type="text" name="customer_name" class="form-control" value="{{ $booking->customer_name }}" {{ $booking->status !== 'pending' ? 'readonly' : 'required' }}>
                                                                        </div>
                                                                        <div class="col-md-6 mb-3">
                                                                            <label class="form-label font-w600">Email Address</label>
                                                                            <input type="email" name="customer_email" class="form-control" value="{{ $booking->customer_email }}" {{ $booking->status !== 'pending' ? 'readonly' : 'required' }}>
                                                                        </div>
                                                                        <div class="col-md-6 mb-3">
                                                                            <label class="form-label font-w600">Phone Number</label>
                                                                            <input type="text" name="customer_phone" class="form-control" value="{{ $booking->customer_phone }}" {{ $booking->status !== 'pending' ? 'readonly' : 'required' }}>
                                                                        </div>
                                                                        <div class="col-md-6 mb-3">
                                                                            <label class="form-label font-w600">Start Date</label>
                                                                            <input type="date" name="start_date" class="form-control" value="{{ $booking->start_date->format('Y-m-d') }}" {{ $booking->status !== 'pending' ? 'readonly' : 'required' }}>
                                                                        </div>
                                                                        <div class="col-md-6 mb-3">
                                                                            <label class="form-label font-w600">End Date</label>
                                                                            <input type="date" name="end_date" class="form-control" value="{{ $booking->end_date ? $booking->end_date->format('Y-m-d') : '' }}" {{ $booking->status !== 'pending' ? 'readonly' : 'required' }}>
                                                                        </div>
                                                                        <div class="col-md-6 mb-3">
                                                                            <label class="form-label font-w600">Total Price</label>
                                                                            <div class="input-group">
                                                                                <span class="input-group-text">₱</span>
                                                                                <input type="text" class="form-control" value="{{ number_format($booking->total_price, 2) }}" readonly>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="mb-3">
                                                                        <label class="form-label font-w600">Special Requests</label>
                                                                        <textarea name="special_requests" class="form-control" rows="3" {{ $booking->status !== 'pending' ? 'readonly' : '' }}>{{ $booking->special_requests }}</textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                    @if($booking->status === 'pending')
                                                                        <button type="submit" class="btn btn-primary">Save Changes</button>
                                                                    @endif
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Cancel Modal -->
                                                @if($booking->status === 'pending')
                                                <div class="modal fade" id="cancelBookingModal{{ $booking->id }}" tabindex="-1" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Cancel Booking</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                Are you sure you want to cancel your booking for <strong>{{ $booking->bookable->brand ?? $booking->bookable->title ?? 'this item' }}</strong>?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No, Keep it</button>
                                                                <form action="{{ route('bookings.cancel', $booking->id) }}" method="POST">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-danger">Yes, Cancel Booking</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endif


                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <div class="mb-3">
                                <i class="fas fa-calendar-times fs-64 text-muted"></i>
                            </div>
                            <h5>No Bookings Found</h5>
                            <p class="text-muted">You haven't made any bookings yet.</p>
                            <a href="{{ url('/explore-listings') }}" class="btn btn-primary mt-3">Discover Cars & Properties</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-layouts.customer>
