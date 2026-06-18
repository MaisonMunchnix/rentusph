<x-layouts.affiliate>
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-xl-3 col-xxl-3 col-sm-6 mb-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center">
                            <div class="p-3 me-3 bg-success bg-opacity-10 rounded-circle">
                                <i class="fas fa-wallet fs-20 text-success"></i>
                            </div>
                            <div>
                                <p class="mb-1 text-muted fs-14">Total Earnings</p>
                                <h3 class="font-w700 mb-0">₱{{ number_format($totalEarnings, 2) }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-xxl-3 col-sm-6 mb-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center">
                            <div class="p-3 me-3 bg-warning bg-opacity-10 rounded-circle">
                                <i class="fas fa-clock fs-20 text-warning"></i>
                            </div>
                            <div>
                                <p class="mb-1 text-muted fs-14">Pending Balance</p>
                                <h3 class="font-w700 mb-0">₱{{ number_format($pendingEarnings, 2) }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-xxl-3 col-sm-6 mb-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center">
                            <div class="p-3 me-3 rounded-circle" style="background-color: rgba(48, 101, 208, 0.1);">
                                <i class="fas fa-chart-line fs-20" style="color: #3065D0;"></i>
                            </div>
                            <div>
                                <p class="mb-1 text-muted fs-14">This Month</p>
                                <h3 class="font-w700 mb-0">₱{{ number_format($monthlyEarnings, 2) }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-xxl-3 col-sm-6 mb-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center">
                            <div class="p-3 me-3 bg-info bg-opacity-10 rounded-circle">
                                <i class="fas fa-check-circle fs-20 text-info"></i>
                            </div>
                            <div>
                                <p class="mb-1 text-muted fs-14">Completed Bookings</p>
                                <h3 class="font-w700 mb-0">{{ $totalCompletedBookings }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header border-0 pb-0">
                        <h4 class="card-title">Earnings History</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-responsive-md datatable-enabled">
                                <thead>
                                    <tr>
                                        <th><strong>ID</strong></th>
                                        <th><strong>ITEM</strong></th>
                                        <th><strong>BOOKING DATES</strong></th>
                                        <th><strong>TOTAL PRICE</strong></th>
                                        <th><strong>MY EARNINGS</strong></th>
                                        <th><strong>STATUS</strong></th>
                                        <th><strong>DATE</strong></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($earningsHistory as $booking)
                                    <tr>
                                        <td><strong>#{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}</strong></td>
                                        <td>
                                            @if($booking->bookable_type === 'App\Models\Car')
                                                <small class="badge badge-xs light badge-primary me-1">Car</small>
                                            @else
                                                <small class="badge badge-xs light badge-info me-1">Property</small>
                                            @endif
                                            {{ $booking->bookable->brand ?? $booking->bookable->title ?? 'N/A' }}
                                        </td>
                                        <td>{{ $booking->start_date->format('M d') }} - {{ $booking->end_date->format('M d, Y') }}</td>
                                        <td>₱{{ number_format($booking->total_price, 2) }}</td>
                                        <td class="text-success fw-bold">₱{{ number_format($booking->affiliate_earnings, 2) }}</td>
                                        <td>
                                            @if($booking->status === 'completed')
                                                <span class="badge light badge-success">Paid</span>
                                            @else
                                                <span class="badge light badge-warning">Pending</span>
                                            @endif
                                        </td>
                                        <td>{{ $booking->updated_at->format('M d, Y') }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7" class="text-center">No earnings data found.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <!-- Pagination handled by DataTables client-side -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.affiliate>
