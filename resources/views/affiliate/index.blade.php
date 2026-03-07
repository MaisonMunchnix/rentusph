<x-layouts.affiliate>
    <div class="row">
        <!-- Stats Row -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-hand-holding-usd text-warning fs-24 me-3"></i>
                        <div>
                            <p class="mb-1 text-muted fs-14">Total Earnings</p>
                            <h3 class="font-w700 mb-0">₱{{ number_format($totalEarnings, 2) }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-clock text-warning fs-24 me-3"></i>
                        <div>
                            <p class="mb-1 text-muted fs-14">Pending Earnings</p>
                            <h3 class="font-w700 mb-0">₱{{ number_format($pendingEarnings, 2) }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-car-side text-warning fs-24 me-3"></i>
                        <div>
                            <p class="mb-1 text-muted fs-14">Active Listings</p>
                            <h3 class="font-w700 mb-0">{{ $activeListings }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions Row -->
    <div class="row mb-4">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header border-0 pb-0">
                    <h4 class="card-title font-w700">Quick Actions</h4>
                </div>
                <div class="card-body">
                    <div class="d-flex flex-wrap gap-3">
                        <a href="{{ route('cars.index') }}" class="btn btn-dark d-flex align-items-center gap-2 px-4 py-2 rounded-pill font-w600">
                            <i class="fas fa-car-side"></i> Manage Vehicles
                        </a>
                        <a href="{{ route('properties.index') }}" class="btn btn-dark d-flex align-items-center gap-2 px-4 py-2 rounded-pill font-w600">
                            <i class="fas fa-building"></i> Manage Properties
                        </a>
                        <a href="{{ route('bookings.index') }}" class="btn btn-dark d-flex align-items-center gap-2 px-4 py-2 rounded-pill font-w600">
                            <i class="fas fa-calendar-alt"></i> View Bookings
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-12">
            <div class="card h-100">
                <div class="card-header border-0 pb-0">
                    <h4 class="card-title font-w700">Recent Earnings History</h4>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr class="text-muted fs-12 text-uppercase">
                                    <th class="ps-4">Booking #</th>
                                    <th>Item</th>
                                    <th>Total Price</th>
                                    <th>My Earnings</th>
                                    <th class="pe-4 text-end">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentEarnings as $booking)
                                <tr>
                                    <td class="ps-4">
                                        <span class="font-w600 text-dark">#{{ $booking->id }}</span>
                                    </td>
                                    <td>
                                        <span class="text-muted fs-14">{{ $booking->bookable->brand ?? '' }} {{ $booking->bookable->model ?? $booking->bookable->title ?? 'N/A' }}</span>
                                    </td>
                                    <td>₱{{ number_format($booking->total_price, 2) }}</td>
                                    <td class="text-success font-w600">₱{{ number_format($booking->affiliate_earnings, 2) }}</td>
                                    <td class="pe-4 text-end">
                                        @if($booking->status === 'completed')
                                            <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 fs-12">Completed</span>
                                        @else
                                            <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-3 fs-12">{{ ucfirst($booking->status) }}</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">
                                        <i class="fas fa-history fs-30 mb-3 opacity-20 d-block"></i>
                                        No recent earnings found.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.affiliate>
