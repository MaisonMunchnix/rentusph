<x-layouts.admin>
    <!-- Welcome Section Row -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card bg-white border-0 mb-4 ">
                <div class="card-body p-4 d-flex align-items-center justify-content-between">
                    <div>
                        <h2 class="font-w700 mb-1">Welcome back, Admin!</h2>
                        <p class="text-muted mb-0">Your rental fleet and properties are performing well today. Here's a quick overview.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Row -->
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-hand-holding-usd text-warning fs-24 me-3"></i>
                        <div>
                            <p class="mb-1 text-muted fs-14">Total Commission</p>
                            <h3 class="font-w700 mb-0">₱{{ number_format($totalCommission, 2) }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-calendar-alt text-warning fs-24 me-3"></i>
                        <div>
                            <p class="mb-1 text-muted fs-14">This Month</p>
                            <h3 class="font-w700 mb-0">₱{{ number_format($monthlyCommission, 2) }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-user-shield text-warning fs-24 me-3"></i>
                        <div>
                            <p class="mb-1 text-muted fs-14">Total Affiliates</p>
                            <h3 class="font-w700 mb-0">{{ $totalAffiliates }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-suitcase-rolling text-warning fs-24 me-3"></i>
                        <div>
                            <p class="mb-1 text-muted fs-14">Active Bookings</p>
                            <h3 class="font-w700 mb-0">{{ $activeBookings }}</h3>
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
                            <i class="fas fa-car-side"></i> Add New Vehicle
                        </a>
                        <a href="{{ route('properties.index') }}" class="btn btn-dark d-flex align-items-center gap-2 px-4 py-2 rounded-pill font-w600">
                            <i class="fas fa-building"></i> Register Property
                        </a>
                        <a href="{{ route('bookings.index') }}" class="btn btn-dark d-flex align-items-center gap-2 px-4 py-2 rounded-pill font-w600">
                            <i class="fas fa-plus-circle"></i> Create Booking
                        </a>
                        <a href="{{ route('affiliates.index') }}" class="btn btn-dark d-flex align-items-center gap-2 px-4 py-2 rounded-pill font-w600">
                            <i class="fas fa-user-check"></i> Manage Affiliates
                        </a>
                        <a href="{{ route('admin.reports') }}" class="btn btn-outline-dark d-flex align-items-center gap-2 px-4 py-2 rounded-pill font-w600">
                            <i class="fas fa-chart-line"></i> View Reports
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart and Recent Activity Row -->
    <div class="row">
        <div class="col-xl-8 col-lg-12 mb-4">
            <div class="card h-100">
                <div class="card-header border-0 pb-0 d-flex justify-content-between align-items-center">
                    <h4 class="card-title font-w700">Ongoing & Active Bookings</h4>
                    <a href="{{ route('bookings.index') }}" class="btn btn-link btn-sm text-primary p-0">View All</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr class="text-muted fs-12 text-uppercase">
                                    <th class="ps-4">Customer</th>
                                    <th>Item</th>
                                    <th>Dates</th>
                                    <th class="pe-4 text-end">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($ongoingBookings as $booking)
                                <tr>
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-sm bg-light text-dark rounded-circle me-2 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; font-size: 12px; font-weight: 600;">
                                                {{ substr($booking->customer_name, 0, 1) }}
                                            </div>
                                            <span class="font-w600 text-dark">{{ $booking->customer_name }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="text-muted fs-14">{{ $booking->bookable->brand ?? '' }} {{ $booking->bookable->model ?? $booking->bookable->title ?? 'N/A' }}</span>
                                    </td>
                                    <td>
                                        <span class="text-muted fs-13">
                                            {{ \Carbon\Carbon::parse($booking->start_date)->format('M d') }} - 
                                            {{ $booking->end_date ? \Carbon\Carbon::parse($booking->end_date)->format('M d') : 'N/A' }}
                                        </span>
                                    </td>
                                    <td class="pe-4 text-end">
                                        <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 fs-12">Active</span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5 text-muted">
                                        <i class="fas fa-calendar-check fs-30 mb-3 opacity-20 d-block"></i>
                                        No active bookings at the moment.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-lg-12 mb-4">
            <div class="card">
                <div class="card-header border-0 pb-0">
                    <h4 class="card-title font-w700">Recent Commission</h4>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr class="text-muted fs-12 text-uppercase">
                                    <th class="ps-4">Item</th>
                                    <th>Comm.</th>
                                    <th class="pe-4 text-end">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentBookings as $booking)
                                <tr>
                                    <td class="ps-4">
                                        <span class="font-w600 text-dark">{{ $booking->bookable->brand ?? $booking->bookable->title ?? 'N/A' }}</span>
                                    </td>
                                    <td class="text-success font-w600">₱{{ number_format($booking->platform_commission, 2) }}</td>
                                    <td class="pe-4 text-end">
                                        <span class="badge badge-sm light {{ $booking->status === 'completed' ? 'badge-success' : 'badge-warning' }}">
                                            {{ ucfirst($booking->status) }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer border-0 pt-0 text-center pb-4">
                    <a href="{{ route('bookings.index') }}" class="btn btn-primary btn-sm rounded-pill px-4">View All Activity</a>
                </div>
            </div>
        </div>
    </div>
</x-layouts.admin>

