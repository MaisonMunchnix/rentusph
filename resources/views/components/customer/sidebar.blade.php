<!-- Sidebar start -->
<div class="dlabnav">
    <div class="dlabnav-scroll d-flex flex-column justify-content-between">
        <ul class="metismenu" id="menu">
            <li class="{{ request()->is('explore-listings*') ? 'mm-active active' : '' }}">
                <a class="{{ request()->is('explore-listings*') ? 'mm-active active' : '' }}" href="{{ route('customer.explore') }}" aria-expanded="false">
                    <i class="fas fa-search"></i>
                    <span class="nav-text">Search Rentals</span>
                </a>
            </li>
            <li class="{{ request()->is('bookings*') ? 'mm-active active' : '' }}">
                <a class="{{ request()->is('bookings*') ? 'mm-active active' : '' }}" href="{{ route('bookings.index') }}" aria-expanded="false">
                    <i class="fas fa-calendar-check"></i>
                    <span class="nav-text">My Bookings</span>
                </a>
            </li>
            <li class="{{ request()->is('customer/profile*') ? 'mm-active active' : '' }}">
                <a class="{{ request()->is('customer/profile*') ? 'mm-active active' : '' }}" href="{{ route('customer.profile') }}" aria-expanded="false">
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
