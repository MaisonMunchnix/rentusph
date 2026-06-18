<x-layouts.admin title="Reports & Analytics">
    <div class="row">
        <!-- Stat Cards -->
        <div class="col-xl-4 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="me-auto">
                            <p class="mb-1 text-primary">Total Bookings (This Month)</p>
                            <h2 class="text-dark">{{ number_format($totalBookingsThisMonth) }}</h2>
                        </div>
                        <div class="icon-box-lg bg-light-warning circle">
                            <i class="fas fa-calendar-check text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="me-auto">
                            <p class="mb-1 text-success">Total Revenue (This Month)</p>
                            <h2 class="text-dark">₱{{ number_format($totalRevenueThisMonth, 2) }}</h2>
                        </div>
                        <div class="icon-box-lg bg-light-success circle">
                            <i class="fas fa-wallet text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="me-auto">
                            <p class="mb-1 text-info">Active Deliveries</p>
                            <h2 class="text-dark">{{ number_format($activeDeliveries) }}</h2>
                        </div>
                        <div class="icon-box-lg bg-light-info circle">
                            <i class="fas fa-car text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="col-xl-8">
            <div class="card">
                <div class="card-header border-0 pb-0">
                    <h4 class="card-title">Bookings & Revenue Summary</h4>
                </div>
                <div class="card-body">
                    <div id="bookingRevenueChart"></div>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card">
                <div class="card-header border-0 pb-0">
                    <h4 class="card-title">Most Rented Cars</h4>
                </div>
                <div class="card-body">
                    <div id="popularCarsChart"></div>
                </div>
            </div>
        </div>

        <!-- Tabular List -->
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Top Performing Cars</h4>
                </div>
                <div class="card-body pb-0">
                    <div class="table-responsive">
                        <table class="table table-responsive-md datatable-enabled">
                            <thead>
                                <tr>
                                    <th><strong>CAR</strong></th>
                                    <th><strong>OWNER</strong></th>
                                    <th><strong>BOOKINGS</strong></th>
                                    <th><strong>REVENUE</strong></th>
                                    <th><strong>STATUS</strong></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($topPerformingCars as $car)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="{{ $car->image ? asset('storage/' . $car->image) : asset('images/car-placeholder.png') }}" class="rounded-lg me-2" width="24" alt=""/>
                                                <span class="w-space-no">{{ $car->brand }} {{ $car->model }}</span>
                                            </div>
                                        </td>
                                        <td>{{ $car->user->name ?? 'N/A' }}</td>
                                        <td>{{ $car->bookings_count }}</td>
                                        <td>₱{{ number_format($car->bookings_sum_total_price ?? 0, 2) }}</td>
                                        <td>
                                            @if($car->is_available)
                                                <span class="badge light badge-success">Available</span>
                                            @else
                                                <span class="badge light badge-danger">Unavailable</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">No car data available</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="scripts">
        <script src="{{ asset('vendor/apexchart/apexchart.js') }}"></script>
        <script>
            // Bookings & Revenue Chart
            var options = {
                series: [{
                    name: 'Bookings',
                    type: 'column',
                    data: @json($chartBookings)
                }, {
                    name: 'Revenue (₱)',
                    type: 'line',
                    data: @json($chartRevenue)
                }],
                chart: {
                    height: 350,
                    type: 'line',
                    toolbar: { show: false }
                },
                stroke: { width: [0, 4] },
                colors: ['#eab308', '#22c55e'],
                labels: @json($chartLabels),
                xaxis: { type: 'category' },
                yaxis: [{
                    title: { text: 'Bookings' },
                }, {
                    opposite: true,
                    title: { text: 'Revenue (₱)' }
                }]
            };
            var chart = new ApexCharts(document.querySelector("#bookingRevenueChart"), options);
            chart.render();

            // Popular Cars Chart
            var options2 = {
                series: @json($popularCarsSeries),
                chart: {
                    width: '100%',
                    type: 'donut',
                },
                labels: @json($popularCarsLabels),
                colors: ['#eab308', '#3b82f6', '#22c55e', '#ef4444', '#a855f7'],
                plotOptions: {
                    pie: {
                        donut: {
                            size: '65%'
                        }
                    }
                },
                legend: { position: 'bottom' }
            };
            var chart2 = new ApexCharts(document.querySelector("#popularCarsChart"), options2);
            chart2.render();
        </script>
    </x-slot>
</x-layouts.admin>
