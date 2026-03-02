<x-layouts.customer title="My Bookings">
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
                                                    @else
                                                        <i class="fas fa-home me-2 text-info"></i>
                                                    @endif
                                                    <span class="w-space-no">{{ $booking->bookable->name ?? 'N/A' }}</span>
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
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item" href="#">View Details</a>
                                                        @if($booking->status === 'pending')
                                                            <a class="dropdown-item text-danger" href="#">Cancel Booking</a>
                                                        @endif
                                                    </div>
                                                </div>
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
                            <a href="{{ url('/') }}" class="btn btn-primary mt-3">Disover Cars & Properties</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-layouts.customer>
