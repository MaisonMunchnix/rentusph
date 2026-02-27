<x-layouts.affiliate>
    <div class="row">
        <div class="col-xl-6 col-xxl-12">
            <div class="row">
                <div class="col-xl-6 col-sm-6">
                    <div class="card card-tabs">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="me-auto text-dark">
                                    <p class="mb-1">Active Listings</p>
                                    <h2 class="text-primary">0</h2>
                                </div>
                                <div class="icon-box-lg circle" style="background: rgba(234, 179, 8, 0.1);">
                                    <i class="fas fa-car text-primary"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-sm-6">
                    <div class="card card-tabs">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="me-auto text-dark">
                                    <p class="mb-1">Total Earnings</p>
                                    <h2 class="text-warning">$0.00</h2>
                                </div>
                                <div class="icon-box-lg circle" style="background: rgba(255, 159, 67, 0.1);">
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
