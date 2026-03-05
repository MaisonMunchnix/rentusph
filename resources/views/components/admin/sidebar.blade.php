<!-- Sidebar start -->
<div class="dlabnav">
    <div class="dlabnav-scroll d-flex flex-column justify-content-between">
        <ul class="metismenu" id="menu">
            <li class="{{ request()->is('dashboard*') || request()->is('admin-dashboard*') ? 'mm-active active' : '' }}">
                <a class="{{ request()->is('dashboard*') || request()->is('admin-dashboard*') ? 'mm-active active' : '' }}" href="{{ route('dashboard') }}" aria-expanded="false">
                    <i class="fas fa-home"></i>
                    <span class="nav-text">Dashboard</span>
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
            <li class="{{ request()->is('cars*') ? 'mm-active active' : '' }}">
                <a class="{{ request()->is('cars*') ? 'mm-active active' : '' }}" href="{{ route('cars.index') }}" aria-expanded="false">
                    <i class="fas fa-car"></i>
                    <span class="nav-text">Cars</span>
                </a>
            </li>
            <li class="{{ request()->is('properties*') ? 'mm-active active' : '' }}">
                <a class="{{ request()->is('properties*') ? 'mm-active active' : '' }}" href="{{ route('properties.index') }}" aria-expanded="false">
                    <i class="fas fa-building"></i>
                    <span class="nav-text">Properties</span>
                </a>
            </li>
            <li class="{{ request()->is('admin/payments*') ? 'mm-active active' : '' }}">
                <a class="{{ request()->is('admin/payments*') ? 'mm-active active' : '' }}" href="{{ route('admin.payments') }}" aria-expanded="false">
                    <i class="fas fa-credit-card"></i>
                    <span class="nav-text">Payments</span>
                </a>
            </li>
            <li class="{{ request()->is('affiliate-management*') ? 'mm-active active' : '' }}">
                <a class="{{ request()->is('affiliate-management*') ? 'mm-active active' : '' }}" href="{{ route('affiliates.index') }}" aria-expanded="false">
                    <i class="fas fa-users"></i>
                    <span class="nav-text">Affiliates</span>
                    @if($pendingAffiliatesCount > 0)
                        <span class="badge badge-warning badge-circle" style="font-size: 0.7rem; padding: 3px 7px; margin-left: 8px; border-radius: 10px; background-color: #dc3545; color: #fff;">{{ $pendingAffiliatesCount }}</span>
                    @endif
                </a>
            </li>
            <li class="{{ request()->is('admin/customers*') ? 'mm-active active' : '' }}">
                <a class="{{ request()->is('admin/customers*') ? 'mm-active active' : '' }}" href="{{ route('admin.customers') }}" aria-expanded="false">
                    <i class="fas fa-user-friends"></i>
                    <span class="nav-text">Customers</span>
                </a>
            </li>
            <li class="{{ request()->is('admin/reports*') ? 'mm-active active' : '' }}">
                <a class="{{ request()->is('admin/reports*') ? 'mm-active active' : '' }}" href="{{ route('admin.reports') }}" aria-expanded="false">
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
