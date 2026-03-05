<x-layouts.admin>
    <div class="row">
        <div class="col-xl-12">
            <div class="row">
                <div class="col-xl-6">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-body tryal row">
                                    <div class="col-xl-7 col-sm-7">
                                        <h2 class="mb-0 text-dark">Welcome back, Admin!</h2>
                                        <span class="text-muted">Your rental fleet and properties are performing well today. Check the latest statistics below.</span>
                                    </div>
                                    <div class="col-xl-5 col-sm-5">
                                        <img src="{{ asset('images/chart.png') }}" alt="" class="sd-shape">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Add some essential stats here -->
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-header border-0 pb-0 flex-wrap">
                                    <h4 class="card-title">System Financial Overview</h4>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex align-items-end justify-content-between mb-4">
                                        <div>
                                            <h4 class="fs-18 font-w500 text-muted mb-1">Total System Commission</h4>
                                            <h2 class="fs-32 font-w700 mb-0 text-success">₱{{ number_format($totalCommission, 2) }}</h2>
                                        </div>
                                        <div class="text-end">
                                            <h4 class="fs-16 font-w500 text-muted mb-1">This Month</h4>
                                            <h3 class="fs-22 font-w600 mb-0">₱{{ number_format($monthlyCommission, 2) }}</h3>
                                        </div>
                                    </div>
                                    <div id="chartBar" class="chartBar"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="row">
                        <div class="col-xl-6 col-sm-6">
                            <div class="card">
                                <div class="card-body card-padding d-flex align-items-center justify-content-between">
                                    <div>
                                        <h4 class="mb-3 text-nowrap">Total Affiliates</h4>
                                        <div class="d-flex align-items-center">
                                            <h2 class="fs-32 font-w700 mb-0 counter">{{ $totalAffiliates }}</h2>
                                        </div>
                                    </div>
                                    <div id="columnChart"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-sm-6">
                            <div class="card">
                                <div class="card-body card-padding d-flex align-items-center justify-content-between">
                                    <div class="w-75">
                                        <h4 class="mb-3 text-nowrap">Active Bookings</h4>
                                        <div class="progress default-progress">
                                            @php $percent = $activeBookings > 0 ? min(100, ($activeBookings / 100) * 100) : 0; @endphp
                                            <div class="progress-bar bg-warning progress-animated" style="width: {{ $percent }}%; height:8px;" role="progressbar"></div>
                                        </div>
                                    </div>
                                    <div>
                                        <h2 class="fs-32 font-w700 mb-0">{{ $activeBookings }}</h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-12 mt-2">
                            <div class="card">
                                <div class="card-header border-0 pb-0">
                                    <h4 class="card-title">Recent Commission History</h4>
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-responsive-md small mb-0">
                                            <thead>
                                                <tr>
                                                    <th>Item</th>
                                                    <th>Total</th>
                                                    <th>Commission</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($recentBookings as $booking)
                                                <tr>
                                                    <td>{{ $booking->bookable->brand ?? $booking->bookable->title ?? 'N/A' }}</td>
                                                    <td>₱{{ number_format($booking->total_price, 2) }}</td>
                                                    <td class="text-danger">₱{{ number_format($booking->platform_commission, 2) }}</td>
                                                    <td><span class="badge badge-xs light {{ $booking->status === 'completed' ? 'badge-info' : 'badge-success' }}">{{ ucfirst($booking->status) }}</span></td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.admin>
