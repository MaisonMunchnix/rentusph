<x-layouts.admin>
    <div class="container-fluid">
        
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header border-0 pb-0">
                        <h4 class="card-title">Affiliates</h4>
                    </div>
                    <div class="card-body">
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
                                    @foreach($affiliates as $affiliate)
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
                                                    <div class="small text-muted mt-1"><i class="fas fa-check-circle text-success"></i> Vehicles Sent</div>
                                                @else
                                                    <div class="small text-muted mt-1"><i class="fas fa-clock"></i> Awaiting Vehicles</div>
                                                @endif
                                            @endif
                                        </td>
                                        <td>{{ $affiliate->phone ?? 'N/A' }}</td>
                                        <td>{{ $affiliate->address ?? 'N/A' }}</td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center">
                                                @php
                                                    $detail = $affiliate->affiliateDetail;
                                                    $status = $detail ? $detail->status : 'pending';
                                                @endphp
                                                
                                                <button type="button" class="btn btn-primary btn-xs px-3 me-2" data-bs-toggle="modal" data-bs-target="#reviewModal{{ $affiliate->id }}">
                                                    Review
                                                </button>

                                                <button type="button" class="btn btn-danger btn-xs px-3" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $affiliate->id }}">
                                                    Delete
                                                </button>
                                            </div>
                                        </td>
                                    </tr>

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
                                                            <p class="mb-0">{{ $affiliate->address ?? 'N/A' }}</p>
                                                        </div>
                                                        <div class="col-md-6 border-start">
                                                            <h6 class="fw-bold mb-3">Submitted Vehicles</h6>
                                                            @forelse($affiliate->cars as $car)
                                                                <div class="card bg-light border-0 mb-3">
                                                                    <div class="card-body p-3">
                                                                        <div class="d-flex align-items-center">
                                                                            @if($car->image)
                                                                                <img src="{{ str_contains($car->image, '/') ? asset($car->image) : asset('images/cars/' . $car->image) }}" class="rounded me-3" style="width: 60px; height: 60px; object-fit: cover;">
                                                                            @endif
                                                                            <div>
                                                                                <p class="mb-0 fw-bold">{{ $car->brand }} {{ $car->model }} ({{ $car->year }})</p>
                                                                                <p class="mb-0 text-muted small">Plate: {{ $car->plate_number }}</p>
                                                                                <p class="mb-0 text-primary small">Daily Rate: ₱{{ number_format($car->daily_rate, 2) }}</p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @empty
                                                                <div class="text-center py-4 bg-light rounded">
                                                                    <i class="fas fa-car-side fa-3x text-muted mb-2"></i>
                                                                    <p class="text-muted mb-0">No vehicles submitted yet.</p>
                                                                </div>
                                                            @endforelse
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
                                                    <p class="mt-2 fs-5">Are you sure you want to delete <strong>{{ $affiliate->name }}</strong>? This cannot be undone.</p>
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
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.admin>
