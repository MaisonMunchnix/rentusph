<x-layouts.admin>
  <div class="container-fluid">

    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header border-0 pb-0">
            <h4 class="card-title">Affiliates</h4>
          </div>
          <div class="card-body">
            <!-- Desktop Table View -->
            <div id="aff-table-view">
              <div class="table-responsive">
                <table class="table table-responsive-md">
                <thead>
                  <tr>
                    <th style="width:80px;"><strong>#</strong></th>
                    <th><strong>NAME</strong></th>
                    <th><strong>EMAIL</strong></th>
                    <th class="text-center"><strong>STATUS</strong></th>
                    <th><strong>PHONE</strong></th>
                    <th><strong>ADDRESS</strong></th>
                    <th class="text-center"><strong>ACTION</strong></th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($affiliates as $affiliate)
                    <tr>
                      <td><strong>{{ $loop->iteration }}</strong></td>
                      <td>{{ $affiliate->name }}</td>
                      <td>{{ $affiliate->email }}</td>
                      <td class="text-center">
                        @php
                          $detail = $affiliate->affiliateDetail;
                          $status = $detail ? $detail->status : 'pending';
                        @endphp
                        @if($status === 'approved')
                          <span class="badge light badge-success">Approved</span>
                        @elseif($status === 'rejected')
                          <span class="badge light badge-danger">Rejected</span>
                        @else
                          <span class="badge light badge-warning">Pending</span>
                          @if($detail && $detail->vehicles_submitted)
                            <div class="small text-muted mt-1"><i class="fas fa-check-circle text-success"></i> Vehicles Sent
                            </div>
                          @else
                            <div class="small text-muted mt-1"><i class="fas fa-clock"></i> Awaiting Vehicles</div>
                          @endif
                        @endif
                      </td>
                      <td>{{ $affiliate->phone ?? 'N/A' }}</td>
                      <td>{{ $affiliate->address ?? 'N/A' }}</td>
                      <td class="text-center">
                        <div class="d-flex justify-content-center">
                          <button type="button" class="btn btn-primary btn-xs px-3 me-2" data-bs-toggle="modal"
                            data-bs-target="#reviewModal{{ $affiliate->id }}">
                            Review
                          </button>

                          <button type="button" class="btn btn-danger btn-xs px-3" data-bs-toggle="modal"
                            data-bs-target="#deleteModal{{ $affiliate->id }}">
                            Delete
                          </button>
                        </div>
                      </td>
                    </tr>
                  @empty
                    <tr>
                        <td colspan="7" class="text-center">No affiliates found.</td>
                    </tr>
                  @endforelse
                </tbody>
              </table>
              </div>
            </div>

            <!-- Mobile/Tablet Card View -->
            <div id="aff-card-view">
                <div class="row">
                    @forelse($affiliates as $affiliate)
                    <div class="col-md-6 col-12 mb-4">
                        <div class="card border shadow-sm h-100 mb-0">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="me-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                        <i class="fas fa-user-tie text-primary fa-2x"></i>
                                    </div>
                                    <div>
                                        <h5 class="mb-1 text-primary">{{ $affiliate->name }}</h5>
                                        <span class="text-muted d-block fs-14">
                                            @php
                                              $detail = $affiliate->affiliateDetail;
                                              $status = $detail ? $detail->status : 'pending';
                                            @endphp
                                            @if($status === 'approved')
                                              <span class="badge light badge-success badge-sm">Approved</span>
                                            @elseif($status === 'rejected')
                                              <span class="badge light badge-danger badge-sm">Rejected</span>
                                            @else
                                              <span class="badge light badge-warning badge-sm">Pending</span>
                                            @endif
                                        </span>
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <div class="d-flex align-items-start mb-2">
                                        <i class="fas fa-envelope text-muted mt-1 me-2" style="width: 20px;"></i>
                                        <span class="text-dark">{{ $affiliate->email }}</span>
                                    </div>
                                    <div class="d-flex align-items-start mb-2">
                                        <i class="fas fa-phone-alt text-muted mt-1 me-2" style="width: 20px;"></i>
                                        <span class="text-dark">{{ $affiliate->phone ?? 'N/A' }}</span>
                                    </div>
                                    <div class="d-flex align-items-start mb-2">
                                        <i class="fas fa-map-marker-alt text-muted mt-1 me-2" style="width: 20px;"></i>
                                        <span class="text-dark">{{ $affiliate->address ?? 'N/A' }}</span>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <small class="text-muted d-block mb-1">Application Status</small>
                                    @if($status === 'pending')
                                      @if($detail && $detail->vehicles_submitted)
                                        <span class="text-success fs-14"><i class="fas fa-check-circle me-1"></i> Vehicles Sent</span>
                                      @else
                                        <span class="text-warning fs-14"><i class="fas fa-clock me-1"></i> Awaiting Vehicles</span>
                                      @endif
                                    @elseif($status === 'approved')
                                        <span class="text-success fs-14"><i class="fas fa-check-circle me-1"></i> Active Affiliate</span>
                                    @else
                                        <span class="text-danger fs-14"><i class="fas fa-times-circle me-1"></i> Rejected</span>
                                    @endif
                                </div>
                                
                                <div class="d-flex gap-2 pt-3 border-top">
                                    <button type="button" class="btn btn-outline-primary btn-sm flex-grow-1" data-bs-toggle="modal" data-bs-target="#reviewModal{{ $affiliate->id }}">
                                        <i class="fas fa-search me-1"></i> Review
                                    </button>
                                    <button type="button" class="btn btn-outline-danger btn-sm flex-grow-1" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $affiliate->id }}">
                                        <i class="fas fa-trash me-1"></i> Delete
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-12 text-center py-5">
                        <i class="fas fa-users-slash fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">No affiliates found.</h5>
                    </div>
                    @endforelse
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <script>
        function applyAffiliateResponsiveView() {
            var tableView = document.getElementById('aff-table-view');
            var cardView = document.getElementById('aff-card-view');
            if (!tableView || !cardView) return;
            if (window.innerWidth >= 992) {
                tableView.style.setProperty('display', 'block', 'important');
                cardView.style.setProperty('display', 'none', 'important');
            } else {
                tableView.style.setProperty('display', 'none', 'important');
                cardView.style.setProperty('display', 'block', 'important');
            }
        }
        applyAffiliateResponsiveView();
        window.addEventListener('resize', applyAffiliateResponsiveView);
    </script>

    @foreach($affiliates as $affiliate)
      @php
        $detail = $affiliate->affiliateDetail;
        $status = $detail ? $detail->status : 'pending';
      @endphp
      <!-- Review and Action Modal -->
      <div class="modal fade" id="reviewModal{{ $affiliate->id }}">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Review Application - {{ $affiliate->name }}</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-md-6">
                  <h6 class="fw-bold mb-3">Personal Information</h6>
                  <p class="mb-1 text-muted small">Full Name</p>
                  <p class="mb-3 fw-bold">{{ $affiliate->name }}</p>

                  <p class="mb-1 text-muted small">Email Address</p>
                  <p class="mb-3">{{ $affiliate->email }}</p>

                  <p class="mb-1 text-muted small">Phone Number</p>
                  <p class="mb-3">{{ $affiliate->phone ?? 'N/A' }}</p>

                  <p class="mb-1 text-muted small">Home Address</p>
                  <p class="mb-3">{{ $affiliate->address ?? 'N/A' }}</p>

                  @if($detail && ($detail->owner_id_1 || $detail->owner_id_2))
                    <p class="mb-1 text-muted small">Government IDs</p>
                    <div class="d-flex gap-2 mb-0">
                      @if($detail->owner_id_1)
                        <a href="{{ Storage::url($detail->owner_id_1) }}" target="_blank"
                          class="badge badge-primary text-white border text-decoration-none" style="font-size: 0.75rem;"><i
                            class="fas fa-id-card me-1"></i> View ID 1</a>
                      @endif
                      @if($detail->owner_id_2)
                        <a href="{{ Storage::url($detail->owner_id_2) }}" target="_blank"
                          class="badge badge-primary text-white border text-decoration-none" style="font-size: 0.75rem;"><i
                            class="fas fa-id-card me-1"></i> View ID 2</a>
                      @endif
                    </div>
                  @endif
                  
                  @php
                    $insuredCars = $affiliate->cars->filter(function($c) { return !empty($c->comprehensive_insurance); });
                  @endphp
                  @if($insuredCars->isNotEmpty())
                    <p class="mb-1 text-muted small mt-3">Comprehensive Insurance</p>
                    <div class="d-flex gap-2 mb-0 flex-wrap">
                      @foreach($insuredCars as $ic)
                        <a href="{{ Storage::url($ic->comprehensive_insurance) }}" target="_blank"
                          class="badge text-warning border text-decoration-none" style="font-size: 0.75rem;"><i
                            class="fas fa-shield-alt me-1"></i> {{ $ic->brand }} {{ $ic->model }}</a>
                      @endforeach
                    </div>
                  @endif
                </div>
                <div class="col-md-6 border-start">
                  <h6 class="fw-bold mb-3">Submitted Vehicles</h6>
                  <div class="submitted-vehicles-list" style="max-height:300px; overflow-y:auto; padding-right:8px;">
                  @forelse($affiliate->cars as $car)
                    <div class="card bg-light border-0 mb-2">
                      <div class="card-body p-2">
                        <div class="d-flex align-items-center mb-1">
                          @if($car->image)
                            <img
                              src="{{ str_contains($car->image, '/') ? asset($car->image) : asset('images/cars/' . $car->image) }}"
                              class="rounded me-2" style="width: 46px; height: 46px; object-fit: cover;">
                          @endif
                          <div>
                            <p class="mb-0 fw-bold" style="font-size:0.9rem;">{{ $car->brand }} {{ $car->model }} ({{ $car->year }})</p>
                            <p class="mb-0 text-muted small" style="font-size:0.75rem;">Plate: {{ $car->plate_number }}</p>
                          </div>
                        </div>
                        <div class="d-flex gap-2 flex-wrap">
                          @if($car->or_file)
                            <a href="{{ Storage::url($car->or_file) }}" target="_blank"
                              class="badge text-secondary border text-decoration-none" style="font-size: 0.7rem;"><i
                                class="fas fa-file-alt me-1"></i> View OR</a>
                          @endif
                          @if($car->cr_file)
                            <a href="{{ Storage::url($car->cr_file) }}" target="_blank"
                              class="badge text-secondary border text-decoration-none" style="font-size: 0.7rem;"><i
                                class="fas fa-file-alt me-1"></i> View CR</a>
                          @endif
                          @if($car->comprehensive_insurance)
                            <a href="{{ Storage::url($car->comprehensive_insurance) }}" target="_blank"
                              class="badge text-warning border text-decoration-none" style="font-size: 0.7rem;"><i
                                class="fas fa-shield-alt me-1"></i> View Insurance</a>
                          @endif
                        </div>
                      </div>
                    </div>
                  @empty
                    <div class="text-center py-3 bg-light rounded">
                      <i class="fas fa-car-side fa-3x text-muted mb-2"></i>
                      <p class="text-muted mb-0">No vehicles submitted yet.</p>
                    </div>
                  @endforelse
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer bg-light justify-content-between">
              <div>
                Status:
                @if($status === 'approved')
                  <span class="badge light badge-success">Approved</span>
                @elseif($status === 'rejected')
                  <span class="badge light badge-danger">Rejected</span>
                @else
                  <span class="badge light badge-warning">Pending</span>
                @endif
              </div>
              <div class="d-flex">
                <button type="button" class="btn btn-secondary light btn-sm me-2" data-bs-dismiss="modal">Close</button>

                @if($status !== 'rejected')
                  <form action="{{ route('affiliates.reject', $affiliate) }}" method="POST" class="me-2">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-danger btn-sm px-2">Reject Application</button>
                  </form>
                @endif

                @if($status !== 'approved')
                  <form action="{{ route('affiliates.approve', $affiliate) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-success btn-sm">Approve</button>
                  </form>
                @endif
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Delete Confirmation Modal -->
      <div class="modal fade" id="deleteModal{{ $affiliate->id }}">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Confirm Deletion</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center py-4">
              <div class="mb-3 text-danger">
                <i class="fas fa-exclamation-triangle fa-4x"></i>
              </div>
              <p class="mb-0 fs-5 text-danger fw-bold">Warning: Permanent Action</p>
              <p class="mt-2 fs-5">Are you sure you want to delete <strong>{{ $affiliate->name }}</strong>? This cannot be
                undone.</p>
            </div>
            <div class="modal-footer border-0 pt-0 justify-content-center">
              <button type="button" class="btn btn-light btn-sm px-4" data-bs-dismiss="modal">Cancel</button>
              <form action="{{ route('affiliates.destroy', $affiliate) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm px-4">Yes, Delete Permanently</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    @endforeach
  </div>
</x-layouts.admin>