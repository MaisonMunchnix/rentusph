<!-- Sidebar start -->
<div class="dlabnav">
    <div class="dlabnav-scroll d-flex flex-column justify-content-between">
        <ul class="metismenu" id="menu">
            <li class="active">
                <a href="{{ route('admin') }}" aria-expanded="false">
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
            <li class="{{ request()->is('cars*') ? 'active' : '' }}">
                <a href="{{ route('cars.index') }}" aria-expanded="false">
                    <i class="fas fa-car"></i>
                    <span class="nav-text">Cars</span>
                </a>
            </li>
            <li class="{{ request()->is('properties*') ? 'active' : '' }}">
                <a href="{{ route('properties.index') }}" aria-expanded="false">
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
        
        <div class="sidebar-footer px-4 py-3 mt-auto">
            <form method="POST" action="{{ url('logout') }}">
                @csrf
                <button type="submit" class="btn btn-outline-danger btn-block d-flex align-items-center justify-content-center w-100 logout-btn">
                    <i class="fas fa-sign-out-alt me-2"></i>
                    <span class="nav-text">Logout</span>
                </button>
            </form>
        </div>
    </div>
</div>
<!-- Sidebar end -->
