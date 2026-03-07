<x-layouts.admin>
    <x-slot name="styles">
        <style>
            .profile-card {
                background: #ffffff !important;
                border: 0 !important;
                border-radius: 10px !important;
                padding: 2rem !important;
                box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05), 0 1px 2px rgba(0, 0, 0, 0.03) !important;
            }

            .form-label {
                font-weight: 600;
                color: #0f172a;
                margin-bottom: 0.5rem;
            }

            .form-control {
                border-radius: 8px;
                padding: 0.6rem 1rem;
                border: 1px solid rgba(0, 0, 0, 0.1);
                background-color: #f8fafc;
            }

            .form-control:focus {
                border-color: #f59e0b; /* text-warning color */
                box-shadow: 0 0 0 0.25rem rgba(245, 158, 11, 0.25);
                background-color: #ffffff;
            }

            .section-title {
                font-size: 1.25rem;
                font-weight: 700;
                color: #0f172a;
                margin-bottom: 1.25rem;
                padding-bottom: 0.75rem;
                border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            }

            .btn-save {
                background-color: #f59e0b !important;
                border-color: #f59e0b !important;
                color: #ffffff !important;
                font-weight: 600;
                padding: 0.6rem 1.5rem;
                border-radius: 50px;
                transition: all 0.3s ease;
            }

            .btn-save:hover {
                transform: translateY(-1px);
                box-shadow: 0 4px 6px rgba(245, 158, 11, 0.2);
            }
        </style>
    </x-slot>

    <div class="row justify-content-center pt-4">
        <div class="col-xl-8 col-lg-10">
            <div class="d-flex align-items-center mb-4">
                <div class="avatar-placeholder me-3">
                    <div style="width: 50px; height: 50px; border-radius: 50%; background: #f59e0b; color: #ffffff; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; font-weight: 700;">
                        @php
                            $words = explode(' ', $user->name);
                            $initials = '';
                            if (count($words) > 0) {
                                $initials .= strtoupper(substr($words[0], 0, 1));
                                if (count($words) > 1) {
                                    $initials .= strtoupper(substr(end($words), 0, 1));
                                }
                            }
                        @endphp
                        {{ $initials }}
                    </div>
                </div>
                <div>
                    <h2 class="font-w700 mb-0 fs-24">Admin Profile</h2>
                    <p class="text-muted mb-0 fs-14">Manage your administrative account settings</p>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert" style="border-radius: 8px;">
                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert" style="border-radius: 8px;">
                    <ul class="mb-0 ps-3">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form action="{{ route('admin.profile.update') }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="profile-card mb-4 mt-2">
                    <h3 class="section-title">Personal Information</h3>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="name">Full Name</label>
                            <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="email">Email Address</label>
                            <input type="email" id="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                        </div>
                    </div>
                </div>

                <div class="profile-card mb-4">
                    <h3 class="section-title">Change Password</h3>
                    <p class="text-muted small mb-4">Leave these fields blank if you do not wish to change your password.</p>
                    
                    <div class="mb-3">
                        <label class="form-label" for="current_password">Current Password</label>
                        <input type="password" id="current_password" name="current_password" class="form-control" placeholder="Enter current password">
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="new_password">New Password</label>
                            <input type="password" id="new_password" name="new_password" class="form-control" placeholder="Enter new password">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="new_password_confirmation">Confirm New Password</label>
                            <input type="password" id="new_password_confirmation" name="new_password_confirmation" class="form-control" placeholder="Confirm new password">
                        </div>
                    </div>
                </div>

                <div class="text-end mb-5">
                    <button type="submit" class="btn btn-save"><i class="fas fa-save me-2"></i>Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.admin>
