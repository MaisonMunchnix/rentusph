<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>RentUs | Admin Dashboard</title>
    
    <!-- Favicon icon -->
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/rentus.svg') }}">
    
    <link href="{{ asset('vendor/bootstrap-select/css/bootstrap-select.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/owl-carousel/owl.carousel.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('vendor/nouislider/nouislider.min.css') }}">
    
    <!-- Style css -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    
    <style>
        :root {
            --primary: #eab308;
            --primary-hover: #ca8a04;
        }
        .brand-logo {
            padding: 10px 20px !important;
        }
        .logo-abbr {
            max-width: 40px;
        }
        .brand-title {
            font-size: 20px;
            font-weight: 700;
            color: #000;
            margin-left: 10px;
        }
    </style>
</head>
<body>
    <div id="preloader">
        <div class="lds-ripple">
            <div></div>
            <div></div>
        </div>
    </div>

    <div id="main-wrapper">
        <!-- Nav header start -->
        <div class="nav-header">
            <a href="{{ url('/dashboard') }}" class="brand-logo">
                <img src="{{ asset('images/rentus.svg') }}" alt="RentUs" class="logo-abbr" style="width: 40px;">
                <span class="brand-title">RentUs</span>
            </a>
            <div class="nav-control">
                <div class="hamburger">
                    <span class="line"></span><span class="line"></span><span class="line"></span>
                </div>
            </div>
        </div>
        <!-- Nav header end -->
		
        <!-- Header start -->
        <div class="header">
            <div class="header-content">
                <nav class="navbar navbar-expand">
                    <div class="collapse navbar-collapse justify-content-between">
                        <div class="header-left">
                            <div class="dashboard_bar">
                                Dashboard
                            </div>
                        </div>
                        <ul class="navbar-nav header-right">
                            <li class="nav-item dropdown notification_dropdown">
                                <a class="nav-link bell dz-theme-mode" href="javascript:void(0);">
                                    <i id="icon-light" class="fas fa-sun"></i>
                                    <i id="icon-dark" class="fas fa-moon"></i>
                                </a>
                            </li>
                            <li class="nav-item dropdown header-profile">
                                <a class="nav-link" href="javascript:void(0);" role="button" data-bs-toggle="dropdown">
                                    <img src="{{ asset('images/user.jpg') }}" width="56" alt="">
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a href="#" class="dropdown-item ai-icon">
                                        <svg id="icon-user1" xmlns="http://www.w3.org/2000/svg" class="text-primary" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                        <span class="ms-2">Profile </span>
                                    </a>
                                    <form method="POST" action="{{ url('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item ai-icon">
                                            <svg id="icon-logout" xmlns="http://www.w3.org/2000/svg" class="text-danger" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                                            <span class="ms-2">Logout </span>
                                        </button>
                                    </form>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
        <!-- Header end -->

        <!-- Sidebar start -->
        <div class="dlabnav">
            <div class="dlabnav-scroll">
                <ul class="metismenu" id="menu">
                    <li class="active">
                        <a href="{{ url('/dashboard') }}" aria-expanded="false">
                            <i class="fas fa-home"></i>
                            <span class="nav-text">Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" aria-expanded="false">
                            <i class="fas fa-calendar-check"></i>
                            <span class="nav-text">Bookings</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" aria-expanded="false">
                            <i class="fas fa-car"></i>
                            <span class="nav-text">Cars</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" aria-expanded="false">
                            <i class="fas fa-building"></i>
                            <span class="nav-text">Properties</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" aria-expanded="false">
                            <i class="fas fa-credit-card"></i>
                            <span class="nav-text">Payments</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" aria-expanded="false">
                            <i class="fas fa-users"></i>
                            <span class="nav-text">Accounts/Affiliates</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" aria-expanded="false">
                            <i class="fas fa-file-alt"></i>
                            <span class="nav-text">Reports</span>
                        </a>
                    </li>
                </ul>
                
                <div class="side-bar-profile">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="side-bar-profile-img">
                            <img src="{{ asset('images/user.jpg') }}" alt="">
                        </div>
                        <div class="profile-info1">
                            <h5>Admin User</h5>
                            <span>admin@rentus.com</span>
                        </div>
                    </div>	
                </div>
                
                <div class="copyright">
                    <p>RentUs Admin © 2026 All Rights Reserved</p>
                </div>
            </div>
        </div>
        <!-- Sidebar end -->
		
        <!-- Content body start -->
        <div class="content-body default-height">
            <div class="container-fluid">
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
            </div>
        </div>
        <!-- Content body end -->

        <!-- Footer start -->
        <div class="footer">
            <div class="copyright">
                <p>Copyright © Designed &amp; Developed by RentUs 2026</p>
            </div>
        </div>
        <!-- Footer end -->
    </div>

    <!-- Scripts -->
    <script src="{{ asset('vendor/global/global.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap-select/js/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('vendor/apexchart/apexchart.js') }}"></script>
    <script src="{{ asset('js/custom.min.js') }}"></script>
    <script src="{{ asset('js/dlabnav-init.js') }}"></script>

</body>
</html>
