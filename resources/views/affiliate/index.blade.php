<x-layouts.affiliate>
    <div class="row">
        <div class="col-xl-6 col-xxl-12">
            <div class="row">
                <div class="col-xl-6 col-sm-6">
                    <div class="card bg-primary card-tabs">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="me-auto text-white">
                                    <p class="mb-1">Active Listings</p>
                                    <h2 class="text-white">0</h2>
                                </div>
                                <div class="icon-box-lg bg-white circle">
                                    <i class="fas fa-car text-primary"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-sm-6">
                    <div class="card bg-warning card-tabs">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="me-auto text-white">
                                    <p class="mb-1">Total Earnings</p>
                                    <h2 class="text-white">$0.00</h2>
                                </div>
                                <div class="icon-box-lg bg-white circle">
                                    <i class="fas fa-wallet text-warning"></i>
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
                    <h4 class="card-title">Welcome, {{ Auth::user()->name }}!</h4>
                </div>
                <div class="card-body">
                    <p>This is your partner dashboard. From here you can manage your vehicles, view bookings, and track your performance.</p>
                </div>
            </div>
        </div>
    </div>
</x-layouts.affiliate>
