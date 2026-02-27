<x-layouts.customer>
    <div class="row">
        <div class="col-xl-6 col-xxl-12">
            <div class="row">
                <div class="col-xl-6 col-sm-6">
                    <div class="card bg-primary card-tabs">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="me-auto text-white">
                                    <p class="mb-1">Active Bookings</p>
                                    <h2 class="text-white">0</h2>
                                </div>
                                <div class="icon-box-lg bg-white circle">
                                    <i class="fas fa-calendar-check text-primary"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-sm-6">
                    <div class="card bg-info card-tabs">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="me-auto text-white">
                                    <p class="mb-1">Total Trips</p>
                                    <h2 class="text-white">0</h2>
                                </div>
                                <div class="icon-box-lg bg-white circle">
                                    <i class="fas fa-car text-info"></i>
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
                    <p>Welcome to your RentUs account. Here you can manage your bookings, view your trip history, and update your profile.</p>
                </div>
            </div>
        </div>
    </div>
</x-layouts.customer>
