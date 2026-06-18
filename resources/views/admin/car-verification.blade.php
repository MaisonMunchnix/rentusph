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
        transition: all 0.3s ease;
      }

      .doc-preview-box:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        border-color: #cbd5e1;
        background: #ffffff;
      }

      .doc-preview-box a {
        font-weight: 600;
        font-size: 0.85rem;
        text-decoration: none;
        color: #475569;
        transition: color 0.2s;
      }

      .doc-preview-box a:hover {
        color: #1e293b;
      }

      .car-verify-card {
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        overflow: hidden;
        background: #ffffff;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.03);
        transition: all 0.3s ease;
        margin-bottom: 1.5rem;
      }

      .car-verify-card:hover {
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        transform: translateY(-2px);
      }
      
      .badge-soft-warning {
        background-color: #fef3c7;
        color: #d97706;
        font-weight: 600;
        padding: 0.4em 0.8em;
      }

      .btn-modern {
        border-radius: 50rem;
        padding: 0.5rem 1.25rem;
        font-weight: 600;
        letter-spacing: 0.3px;
        transition: all 0.2s;
      }
      
      .btn-modern:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
      }
      
      .empty-state-container {
        background: #f8fafc;
        border: 1px dashed #cbd5e1;
        border-radius: 20px;
        padding: 4rem 2rem;
      }
    </style>
  </x-slot>

  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header border-0 pb-0">
          <h4 class="card-title"><i class="fas fa-shield-alt me-2 text-primary"></i>Car Verification</h4>
          <p class="text-muted mb-0 small">Review and approve affiliate car listings with uploaded OR/CR documents.</p>
        </div>
        <div class="card-body p-4">
          @if($pendingCars->isEmpty())
            <div class="empty-state-container text-center mx-auto" style="max-width: 600px; margin-top: 1rem;">
              <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-4" style="width: 80px; height: 80px; background: #dcfce7; box-shadow: 0 8px 16px rgba(34, 197, 94, 0.15);">
                <i class="fas fa-check text-success fa-3x"></i>
              </div>
              <h4 class="fw-bold text-dark mb-2">All caught up!</h4>
              <p class="text-muted mb-0">No car listings are currently pending verification. Excellent work!</p>
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
                          <img src="{{ asset($car->image) }}" class="w-100 h-100"
                            style="object-fit: cover; min-height: 180px;" alt="Car Image">
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
                              <h5 class="fw-bold text-dark mb-1">{{ $car->brand }} {{ $car->model }}</h5>
                              <span class="text-secondary small fw-medium"><i class="fas fa-calendar-alt me-1"></i>{{ $car->year }} <span class="mx-1">•</span> <i class="fas fa-hashtag me-1"></i>{{ $car->plate_number }}</span>
                            </div>
                            <span class="badge badge-soft-warning rounded-pill">Pending</span>
                          </div>
                          <div class="mb-3 small text-muted bg-light p-2 rounded-3 d-inline-flex align-items-center">
                            <i class="fas fa-user-circle me-2 text-secondary fa-lg"></i> 
                            <span><strong>{{ $car->user->name ?? 'N/A' }}</strong> &middot; {{ $car->user->email ?? '' }}</span>
                          </div>

                          <div class="small text-muted mb-3">
                            <i class="fas fa-clock me-1"></i>
                            Submitted: {{ $car->created_at ? $car->created_at->format('M d, Y g:i A') : 'N/A' }}
                          </div>
                          {{-- Submitted Documents --}}
                          <div class="row g-2 mb-3">
                            <div class="col-4">
                              <div class="doc-preview-box p-2" style="min-height: 80px;">
                                @if($car->or_file)
                                  <a href="{{ Storage::url($car->or_file) }}" target="_blank">
                                    <i class="fas fa-file-alt fa-2x text-primary d-block mb-1"></i>
                                    OR
                                  </a>
                                @else
                                  <span class="text-muted small"><i class="fas fa-times-circle text-danger me-1"></i>No
                                    OR</span>
                                @endif
                              </div>
                            </div>
                            <div class="col-4">
                              <div class="doc-preview-box p-2" style="min-height: 80px;">
                                @if($car->cr_file)
                                  <a href="{{ Storage::url($car->cr_file) }}" target="_blank">
                                    <i class="fas fa-file-alt fa-2x text-success d-block mb-1"></i>
                                    CR
                                  </a>
                                @else
                                  <span class="text-muted small"><i class="fas fa-times-circle text-danger me-1"></i>No
                                    CR</span>
                                @endif
                              </div>
                            </div>
                            <div class="col-4">
                              <div class="doc-preview-box p-2" style="min-height: 80px;">
                                @if($car->comprehensive_insurance)
                                  <a href="{{ Storage::url($car->comprehensive_insurance) }}" target="_blank">
                                    <i class="fas fa-shield-alt fa-2x text-light d-block mb-1"></i>
                                    Insurance
                                  </a>
                                @else
                                  <span class="text-muted small"><i class="fas fa-times-circle text-danger me-1"></i>No
                                    Ins.</span>
                                @endif
                              </div>
                            </div>
                            <div class="col-6">
                              <div class="doc-preview-box p-2" style="min-height: 80px;">
                                @if($car->user && $car->user->affiliateDetail && $car->user->affiliateDetail->owner_id_1)
                                  <a href="{{ Storage::url($car->user->affiliateDetail->owner_id_1) }}" target="_blank">
                                    <i class="fas fa-id-card fa-2x text-secondary d-block mb-1"></i>
                                    Gov ID 1
                                  </a>
                                @else
                                  <span class="text-muted small"><i class="fas fa-times-circle text-danger me-1"></i>No ID
                                    1</span>
                                @endif
                              </div>
                            </div>
                            <div class="col-6">
                              <div class="doc-preview-box p-2" style="min-height: 80px;">
                                @if($car->user && $car->user->affiliateDetail && $car->user->affiliateDetail->owner_id_2)
                                  <a href="{{ Storage::url($car->user->affiliateDetail->owner_id_2) }}" target="_blank">
                                    <i class="fas fa-id-card fa-2x text-secondary d-block mb-1"></i>
                                    Gov ID 2
                                  </a>
                                @else
                                  <span class="text-muted small"><i class="fas fa-times-circle text-danger me-1"></i>No ID
                                    2</span>
                                @endif
                              </div>
                            </div>
                          </div>

                          {{-- Action Buttons --}}
                          <div class="d-flex gap-2 mt-4">
                            <button type="button" class="btn btn-success btn-modern flex-grow-1" data-bs-toggle="modal"
                              data-bs-target="#approveModal{{ $car->id }}">
                              <i class="fas fa-check-circle me-1"></i> Approve
                            </button>
                            <button type="button" class="btn btn-danger btn-modern flex-grow-1" data-bs-toggle="modal"
                              data-bs-target="#rejectModal{{ $car->id }}">
                              <i class="fas fa-times-circle me-1"></i> Reject
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
              <div class="modal-body p-4">
                <div class="alert alert-danger py-2 px-3 small border-0 rounded-3 mb-3" style="background: #fef2f2; color: #991b1b;">
                  <i class="fas fa-exclamation-triangle me-1"></i> You are about to reject <strong>{{ $car->brand }} {{ $car->model }}</strong> ({{ $car->plate_number }}) submitted by <strong>{{ $car->user->name ?? 'N/A' }}</strong>.
                </div>
                <div class="form-group mb-0">
                  <label class="form-label fw-600 small text-dark">Reason for Rejection <span class="text-danger">*</span></label>
                  <textarea name="rejection_reason" class="form-control bg-light border-0 shadow-none" rows="3"
                    placeholder="e.g. OR/CR documents are unclear, expired, or don't match the listing..."
                    required style="border-radius: 10px; padding: 12px;"></textarea>
                </div>
              </div>
              <div class="modal-footer border-0 pt-0 pb-4 px-4">
                <button type="button" class="btn btn-light btn-modern text-dark" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-danger btn-modern px-4">Confirm Rejection</button>
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
              <div class="modal-body p-4">
                <p class="mb-3 text-secondary">
                  Are you sure you want to approve <strong>{{ $car->brand }} {{ $car->model }}</strong>
                  ({{ $car->plate_number }}) submitted by <strong>{{ $car->user->name ?? 'N/A' }}</strong>?
                </p>
                <div class="alert alert-info py-3 px-3 small border-0 rounded-3 mb-0"
                  style="background: #eff6ff; color: #1e40af;">
                  <div class="d-flex">
                    <i class="fas fa-info-circle fa-lg me-2 mt-1"></i> 
                    <div>This car will become available for customers to rent immediately on the platform.</div>
                  </div>
                </div>
              </div>
              <div class="modal-footer border-0 pt-0 pb-4 px-4">
                <button type="button" class="btn btn-light btn-modern text-dark" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-success btn-modern px-4">Confirm Approval</button>
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