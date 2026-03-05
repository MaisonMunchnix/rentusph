<x-layouts.affiliate>
    <div class="row">
        <div class="col-xl-6 col-xxl-12">
            <div class="row">
                <div class="col-xl-4 col-sm-4">
                    <div class="card card-tabs">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="me-auto text-dark">
                                    <p class="mb-1 text-muted small">Total Earnings</p>
                                    <h2 class="text-success font-w700 mb-0">₱{{ number_format($totalEarnings, 2) }}</h2>
                                </div>
                                <div class="icon-box-sm circle bg-success-light">
                                    <i class="fas fa-wallet text-success"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-sm-4">
                    <div class="card card-tabs">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="me-auto text-dark">
                                    <p class="mb-1 text-muted small">Pending Earnings</p>
                                    <h2 class="text-warning font-w700 mb-0">₱{{ number_format($pendingEarnings, 2) }}</h2>
                                </div>
                                <div class="icon-box-sm circle bg-warning-light">
                                    <i class="fas fa-clock text-warning"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-sm-4">
                    <div class="card card-tabs">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="me-auto text-dark">
                                    <p class="mb-1 text-muted small">Active Listings</p>
                                    <h2 class="text-primary font-w700 mb-0">{{ $activeListings }}</h2>
                                </div>
                                <div class="icon-box-sm circle bg-primary-light">
                                    <i class="fas fa-car text-primary"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header border-0 pb-0">
                    <h4 class="card-title">Recent Earnings History</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-responsive-md small">
                            <thead>
                                <tr>
                                    <th><strong>BOOKING #</strong></th>
                                    <th><strong>ITEM</strong></th>
                                    <th><strong>TOTAL PRICE</strong></th>
                                    <th><strong>MY EARNINGS</strong></th>
                                    <th><strong>STATUS</strong></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentEarnings as $booking)
                                <tr>
                                    <td>#{{ $booking->id }}</td>
                                    <td>{{ $booking->bookable->brand ?? $booking->bookable->title ?? 'N/A' }}</td>
                                    <td>₱{{ number_format($booking->total_price, 2) }}</td>
                                    <td class="text-success font-w600">₱{{ number_format($booking->affiliate_earnings, 2) }}</td>
                                    <td>
                                        <span class="badge badge-xs light {{ $booking->status === 'completed' ? 'badge-success' : 'badge-warning' }}">
                                            {{ ucfirst($booking->status) }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.affiliate>
