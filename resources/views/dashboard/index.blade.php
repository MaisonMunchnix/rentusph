<x-layouts.admin>
    <div class="row">
        <div class="col-xl-12">
            <div class="row">
                <div class="col-xl-6">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card tryal-gradient" style="background: linear-gradient(212.43deg, #eab308 19.43%, #fbbf24 87.63%);">
                                <div class="card-body tryal row">
                                    <div class="col-xl-7 col-sm-7">
                                        <h2 class="mb-0 text-white">Welcome back, Admin!</h2>
                                        <span class="text-white opacity-75">Your rental fleet and properties are performing well today. Check the latest statistics below.</span>
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
                                    <h4 class="card-title">Project Statistics</h4>
                                </div>
                                <div class="card-body">
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
                                        <h4 class="mb-3 text-nowrap">Total Clients</h4>
                                        <div class="d-flex align-items-center">
                                            <h2 class="fs-32 font-w700 mb-0 counter">68</h2>
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
                                            <div class="progress-bar bg-warning progress-animated" style="width: 40%; height:8px;" role="progressbar"></div>
                                        </div>
                                    </div>
                                    <div>
                                        <h2 class="fs-32 font-w700 mb-0">42</h2>
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
