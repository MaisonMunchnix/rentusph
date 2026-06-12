@php
    $name = Auth::user()->name;
    $words = explode(' ', $name);
    $initials = '';
    if (count($words) > 0) {
        $initials .= strtoupper(substr($words[0], 0, 1));
        if (count($words) > 1) {
            $initials .= strtoupper(substr(end($words), 0, 1));
        }
    }
@endphp

<!-- Nav header start -->
<div class="nav-header" style="background-color: #0a0a0a !important; border: none !important; box-shadow: none !important; display: flex; align-items: center; justify-content: space-between;">
    <a href="{{ url('/') }}" class="brand-logo" style="display: flex; align-items: center; justify-content: flex-start; padding-left: 1rem; text-decoration: none;">
        <img src="{{ asset('images/rentus.png') }}" alt="RentUs Logo" style="max-height: 45px; max-width: 100%; object-fit: contain;">
    </a>
    <div class="nav-control" style="padding-right: 1rem;">
        <div class="hamburger">
            <span class="line"></span><span class="line"></span><span class="line"></span>
        </div>
    </div>
</div>
<!-- Nav header end -->

<!-- Header start -->
<div class="header" style="background-color: #0a0a0a !important; border: none !important; box-shadow: none !important;">
    <div class="header-content">
        <nav class="navbar navbar-expand d-flex align-items-center" style="border: none !important; box-shadow: none !important; padding: 0.5rem 1rem;">
            <div class="collapse navbar-collapse justify-content-end w-100 d-flex" id="navbarSupportedContent">
                <ul class="navbar-nav header-right d-flex align-items-center flex-row">
                    <li class="nav-item dropdown header-profile">
                        <a class="nav-link" href="javascript:void(0);" role="button" data-bs-toggle="dropdown" style="background: transparent; outline: none; box-shadow: none;">
                            <div class="d-flex align-items-center justify-content-center bg-white text-black rounded-circle font-w600" style="width: 40px; height: 40px; font-size: 14px; border: 1px solid rgba(0,0,0,0.1);">
                                {{ $initials }}
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end mt-2">
                            <a href="{{ route('admin.profile') }}" class="dropdown-item ai-icon">
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
