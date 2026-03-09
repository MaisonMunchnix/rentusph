<!-- Sidebar start -->
<div class="dlabnav">
    <div class="dlabnav-scroll d-flex flex-column justify-content-between">
        <ul class="metismenu" id="menu">
            <li class="{{ request()->is('dashboard*') ? 'mm-active active' : '' }}">
                <a class="{{ request()->is('dashboard*') ? 'mm-active active' : '' }}" href="{{ route('dashboard') }}" aria-expanded="false">
                    <i class="fas fa-home"></i>
                    <span class="nav-text">Dashboard</span>
                </a>
            </li>
            <li class="{{ request()->is('cars*') ? 'mm-active active' : '' }}">
                <a class="{{ request()->is('cars*') ? 'mm-active active' : '' }}" href="{{ route('cars.index') }}" aria-expanded="false">
                    <i class="fas fa-car"></i>
                    <span class="nav-text">My Cars</span>
                </a>
            </li>
            <li class="{{ request()->is('properties*') ? 'active' : '' }}">
                <a href="{{ route('properties.index') }}" aria-expanded="false">
                    <i class="fas fa-building"></i>
                    <span class="nav-text">My Properties</span>
                </a>
            </li>
            <li class="{{ request()->is('bookings*') ? 'mm-active active' : '' }}">
                <a class="{{ request()->is('bookings*') ? 'mm-active active' : '' }}" href="{{ route('bookings.index') }}" aria-expanded="false">
                    <i class="fas fa-calendar-check"></i>
                    <span class="nav-text">Bookings</span>
                    @if($pendingBookingsCount > 0)
                        <span class="badge badge-danger badge-circle" style="font-size: 0.7rem; padding: 3px 7px; margin-left: 8px; border-radius: 10px; background-color: #dc3545; color: #fff;">{{ $pendingBookingsCount }}</span>
                    @endif
                </a>
            </li>
            <li class="{{ request()->is('affiliate/earnings*') ? 'mm-active active' : '' }}">
                <a class="{{ request()->is('affiliate/earnings*') ? 'mm-active active' : '' }}" href="{{ route('affiliate.earnings') }}" aria-expanded="false">
                    <i class="fas fa-dollar-sign"></i>
                    <span class="nav-text">Earnings</span>
                </a>
            </li>
            <li class="{{ request()->routeIs('admin.profile') ? 'mm-active active' : '' }}">
                <a class="{{ request()->routeIs('admin.profile') ? 'mm-active active' : '' }}" href="{{ route('admin.profile') }}" aria-expanded="false">
                    <i class="fas fa-user"></i>
                    <span class="nav-text">Profile</span>
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
