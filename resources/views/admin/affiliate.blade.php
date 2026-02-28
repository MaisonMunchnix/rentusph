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
                                            @if($affiliate->status === 'approved')
                                                <span class="badge light badge-success">Approved</span>
                                            @elseif($affiliate->status === 'rejected')
                                                <span class="badge light badge-danger">Rejected</span>
                                            @else
                                                <span class="badge light badge-warning">Pending</span>
                                            @endif
                                        </td>
                                        <td>{{ $affiliate->phone ?? 'N/A' }}</td>
                                        <td>{{ $affiliate->address ?? 'N/A' }}</td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center">
                                                @if($affiliate->status === 'approved')
                                                    <a href="javascript:void(0)" class="btn btn-primary btn-xs px-3 me-2">View</a>
                                                    <button type="button" class="btn btn-danger btn-xs px-3" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $affiliate->id }}">
                                                        Delete
                                                    </button>
                                                @else
                                                    @if($affiliate->status !== 'approved')
                                                        <button type="button" class="btn btn-success btn-xs px-3 me-2" data-bs-toggle="modal" data-bs-target="#approveModal{{ $affiliate->id }}">
                                                            Approve
                                                        </button>
                                                    @endif
                                                    @if($affiliate->status !== 'rejected')
                                                        <button type="button" class="btn btn-outline-danger btn-xs px-3" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $affiliate->id }}">
                                                            Reject
                                                        </button>
                                                    @endif
                                                @endif
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- Approve Confirmation Modal -->
                                    <div class="modal fade" id="approveModal{{ $affiliate->id }}">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Confirm Approval</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body text-center py-4">
                                                    <div class="mb-3 text-success">
                                                        <i class="fas fa-check-circle fa-4x"></i>
                                                    </div>
                                                    <p class="mb-0 fs-5">Are you sure you want to approve <strong>{{ $affiliate->name }}</strong> as a partner?</p>
                                                </div>
                                                <div class="modal-footer border-0 pt-0 justify-content-center">
                                                    <button type="button" class="btn btn-danger light btn-sm px-4" data-bs-dismiss="modal">Cancel</button>
                                                    <form action="{{ route('affiliates.approve', $affiliate) }}" method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="btn btn-success btn-sm px-4">Yes, Approve</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Reject Confirmation Modal -->
                                    <div class="modal fade" id="rejectModal{{ $affiliate->id }}">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Confirm Rejection</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body text-center py-4">
                                                    <div class="mb-3 text-danger">
                                                        <i class="fas fa-times-circle fa-4x"></i>
                                                    </div>
                                                    <p class="mb-0 fs-5">Are you sure you want to reject <strong>{{ $affiliate->name }}</strong>?</p>
                                                </div>
                                                <div class="modal-footer border-0 pt-0 justify-content-center">
                                                    <button type="button" class="btn btn-light btn-sm px-4" data-bs-dismiss="modal">Cancel</button>
                                                    <form action="{{ route('affiliates.reject', $affiliate) }}" method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="btn btn-danger btn-sm px-4">Yes, Reject</button>
                                                    </form>
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
