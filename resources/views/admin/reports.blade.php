<x-layouts.admin title="Reports & Analytics">
    <div class="row">
        <!-- Stat Cards -->
        <div class="col-xl-4 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="me-auto">
                            <p class="mb-1 text-primary">Total Bookings (This Month)</p>
                            <h2 class="text-dark">124</h2>
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
                            <h2 class="text-dark">₱45,200</h2>
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
                            <h2 class="text-dark">12</h2>
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
                        <table class="table table-responsive-md">
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
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ asset('images/car-placeholder.png') }}" class="rounded-lg me-2" width="24" alt=""/>
                                            <span class="w-space-no">Toyota Vios 2023</span>
                                        </div>
                                    </td>
                                    <td>John Doe</td>
                                    <td>45</td>
                                    <td>₱15,000</td>
                                    <td><span class="badge light badge-success">Available</span></td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ asset('images/car-placeholder.png') }}" class="rounded-lg me-2" width="24" alt=""/>
                                            <span class="w-space-no">Mitsubishi Mirage</span>
                                        </div>
                                    </td>
                                    <td>Jane Smith</td>
                                    <td>38</td>
                                    <td>₱12,400</td>
                                    <td><span class="badge light badge-success">Available</span></td>
                                </tr>
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
                    data: [23, 11, 22, 27, 13, 22, 37, 21, 44, 22, 30, 45]
                }, {
                    name: 'Revenue (₱)',
                    type: 'line',
                    data: [3000, 2500, 3600, 3000, 4500, 3500, 6400, 5200, 5900, 3600, 3900, 5100]
                }],
                chart: {
                    height: 350,
                    type: 'line',
                    toolbar: { show: false }
                },
                stroke: { width: [0, 4] },
                colors: ['#eab308', '#22c55e'],
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
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
                series: [44, 55, 13, 33],
                chart: {
                    width: '100%',
                    type: 'donut',
                },
                labels: ['Toyota Vios', 'Mitsubishi Mirage', 'Hyundai Accent', 'Honda City'],
                colors: ['#eab308', '#3b82f6', '#22c55e', '#ef4444'],
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
