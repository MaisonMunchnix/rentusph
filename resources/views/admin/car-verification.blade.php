<x-layouts.admin>
    <x-slot name="styles">
        <link href="{{ asset('vendor/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet">
        <style>
            .doc-preview-box {
                border: 2px dashed #e2e8f0;
                border-radius: 12px;
                padding: 14px;
                text-align: center;
                background: #f8fafc;
                min-height: 90px;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            .doc-preview-box a {
                font-weight: 600;
                font-size: 0.85rem;
            }
            .car-verify-card {
                border: 1px solid #e2e8f0;
                border-radius: 16px;
                overflow: hidden;
                box-shadow: 0 2px 12px rgba(0,0,0,0.05);
                transition: box-shadow 0.2s;
                margin-bottom: 1.5rem;
            }
            .car-verify-card:hover { box-shadow: 0 6px 24px rgba(0,0,0,0.1); }
        </style>
    </x-slot>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header border-0 pb-0">
                    <h4 class="card-title"><i class="fas fa-shield-alt me-2 text-primary"></i>Car Verification</h4>
                    <p class="text-muted mb-0 small">Review and approve affiliate car listings with uploaded OR/CR documents.</p>
                </div>
                <div class="card-body">
                    @if($pendingCars->isEmpty())
                        <div class="text-center py-5">
                            <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                            <h5 class="fw-700">All caught up!</h5>
                            <p class="text-muted">No car listings are pending verification.</p>
                        </div>
                    @else
                        <div class="row">
                            @foreach($pendingCars as $car)
                            <div class="col-xl-6">
                                <div class="car-verify-card">
                                    <div class="row g-0">
                                        {{-- Car Image --}}
                                        <div class="col-md-5" style="min-height: 180px; background: #f1f5f9;">
                                            @if($car->image)
                                                <img src="{{ asset($car->image) }}" class="w-100 h-100" style="object-fit: cover; min-height: 180px;" alt="Car Image">
                                            @else
                                                <div class="d-flex align-items-center justify-content-center h-100" style="min-height: 180px;">
                                                    <i class="fas fa-car fa-3x text-muted"></i>
                                                </div>
                                            @endif
                                        </div>
                                        {{-- Car Info --}}
                                        <div class="col-md-7">
                                            <div class="p-3">
                                                <div class="d-flex justify-content-between align-items-start mb-2">
                                                    <div>
                                                        <h5 class="fw-700 mb-0">{{ $car->brand }} {{ $car->model }}</h5>
                                                        <small class="text-muted">{{ $car->year }} · {{ $car->plate_number }}</small>
                                                    </div>
                                                    <span class="badge light badge-warning">Pending</span>
                                                </div>
                                                <div class="mb-2 small text-muted">
                                                    <i class="fas fa-user me-1"></i> <strong>{{ $car->user->name ?? 'N/A' }}</strong> ({{ $car->user->email ?? '' }})
                                                </div>

                                                {{-- OR / CR Documents --}}
                                                <div class="row g-2 mb-3">
                                                    <div class="col-6">
                                                        <div class="doc-preview-box">
                                                            @if($car->or_file)
                                                                <a href="{{ Storage::url($car->or_file) }}" target="_blank">
                                                                    <i class="fas fa-file-alt fa-2x text-primary d-block mb-1"></i>
                                                                    View OR
                                                                </a>
                                                            @else
                                                                <span class="text-muted small"><i class="fas fa-times-circle text-danger me-1"></i>OR Not Uploaded</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="doc-preview-box">
                                                            @if($car->cr_file)
                                                                <a href="{{ Storage::url($car->cr_file) }}" target="_blank">
                                                                    <i class="fas fa-file-alt fa-2x text-success d-block mb-1"></i>
                                                                    View CR
                                                                </a>
                                                            @else
                                                                <span class="text-muted small"><i class="fas fa-times-circle text-danger me-1"></i>CR Not Uploaded</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>

                                                {{-- Action Buttons --}}
                                                <div class="d-flex gap-2">
                                                    <button type="button" class="btn btn-success btn-sm w-50"
                                                        data-bs-toggle="modal" data-bs-target="#approveModal{{ $car->id }}">
                                                        <i class="fas fa-check me-1"></i> Approve
                                                    </button>
                                                    <button type="button" class="btn btn-danger btn-sm w-50"
                                                        data-bs-toggle="modal" data-bs-target="#rejectModal{{ $car->id }}">
                                                        <i class="fas fa-times me-1"></i> Reject
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @if(!$pendingCars->isEmpty())
        @foreach($pendingCars as $car)
        {{-- Reject Modal --}}
        <div class="modal fade" id="rejectModal{{ $car->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" style="max-width: 440px;">
                <div class="modal-content">
                    <div class="modal-header border-0 pb-0">
                        <h5 class="modal-title fw-700 text-danger"><i class="fas fa-times-circle me-2"></i>Reject Car Listing</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="{{ route('cars.verify', $car->id) }}" method="POST">
                        @csrf @method('PATCH')
                        <input type="hidden" name="action" value="reject">
                        <div class="modal-body">
                            <p class="text-muted small mb-3">
                                You are rejecting <strong>{{ $car->brand }} {{ $car->model }}</strong> ({{ $car->plate_number }}) submitted by <strong>{{ $car->user->name ?? 'N/A' }}</strong>.
                            </p>
                            <div class="form-group">
                                <label class="form-label fw-600 small">Reason for Rejection <span class="text-danger">*</span></label>
                                <textarea name="rejection_reason" class="form-control" rows="3"
                                    placeholder="e.g. OR/CR documents are unclear, expired, or don't match the listing..." required></textarea>
                            </div>
                        </div>
                        <div class="modal-footer border-0 pt-0">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-danger px-4">Confirm Rejection</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Approve Modal --}}
        <div class="modal fade" id="approveModal{{ $car->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" style="max-width: 440px;">
                <div class="modal-content">
                    <div class="modal-header border-0 pb-0">
                        <h5 class="modal-title fw-700 text-success"><i class="fas fa-check-circle me-2"></i>Approve Car Listing</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="{{ route('cars.verify', $car->id) }}" method="POST">
                        @csrf @method('PATCH')
                        <input type="hidden" name="action" value="approve">
                        <div class="modal-body">
                            <p class="mb-3">
                                Are you sure you want to approve <strong>{{ $car->brand }} {{ $car->model }}</strong> ({{ $car->plate_number }}) submitted by <strong>{{ $car->user->name ?? 'N/A' }}</strong>?
                            </p>
                            <div class="alert alert-info py-2 px-3 small border-0" style="background: rgba(59, 130, 246, 0.1); color: #1d4ed8;">
                                <i class="fas fa-info-circle me-1"></i> This car will become available for customers to rent immediately.
                            </div>
                        </div>
                        <div class="modal-footer border-0 pt-0">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-success px-4">Confirm Approval</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    @endif

    <x-slot name="scripts">
        <script src="{{ asset('vendor/sweetalert2/sweetalert2.min.js') }}"></script>
        <script>
            @if($errors->any())
                let errorMessages = '';
                @foreach ($errors->all() as $error)
                    errorMessages += '{{ $error }}<br>';
                @endforeach
                Swal.fire({
                    html: `
                    <div class="py-2 text-center">
                        <div class="mb-3 text-danger">
                            <i class="fas fa-exclamation-triangle fa-3x"></i>
                        </div>
                        <p class="mb-0 fs-5 text-danger fw-bold">Verification Error!</p>
                        <p class="mt-2 text-muted fs-6">${errorMessages}</p>
                    </div>
                    `,
                    showConfirmButton: true,
                    confirmButtonText: 'Okay',
                    buttonsStyling: false,
                    customClass: {
                        confirmButton: 'btn btn-danger px-4',
                        popup: 'rounded-lg border-0 shadow-sm'
                    }
                });
            @endif

            @if(session('success'))
                @if(str_contains(session('success'), 'has been approved'))
                    Swal.fire({
                        title: 'Vehicle Approved!',
                        html: `{{ session('success') }}<br><br><b>Note:</b> The car is now live for users. You can toggle its availability at any time from the <a href="{{ route('cars.index') }}" class="text-primary fw-bold">main car list</a>.`,
                        icon: 'success',
                        confirmButtonColor: '#10b981',
                        confirmButtonText: 'Got it!'
                    });
                @else
                    Swal.fire({
                        title: 'Success!',
                        text: "{{ session('success') }}",
                        icon: 'success',
                        confirmButtonColor: '#eab308'
                    });
                @endif
            @endif
        </script>
    </x-slot>
</x-layouts.admin>
