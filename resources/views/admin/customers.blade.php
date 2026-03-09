<x-layouts.admin>
    <div class="container-fluid">
        
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header border-0 pb-0">
                        <h4 class="card-title">Customers</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-responsive-md">
                                <thead>
                                    <tr>
                                        <th style="width:80px;"><strong>#</strong></th>
                                        <th><strong>NAME</strong></th>
                                        <th><strong>EMAIL</strong></th>
                                        <th><strong>PHONE</strong></th>
                                        <th><strong>ADDRESS</strong></th>
                                        <th><strong>JOINED DATE</strong></th>
                                        <th class="text-center"><strong>ACTION</strong></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($customers as $customer)
                                    <tr>
                                        <td><strong>{{ $loop->iteration }}</strong></td>
                                        <td>{{ $customer->name }}</td>
                                        <td>{{ $customer->email }}</td>
                                        <td>{{ $customer->phone ?? 'N/A' }}</td>
                                        <td>{{ $customer->address ?? 'N/A' }}</td>
                                        <td>{{ $customer->created_at->format('M d, Y') }}</td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center">
                                                <a href="javascript:void(0)" class="btn btn-primary btn-xs px-3 me-2">View</a>
                                                <button type="button" class="btn btn-danger btn-xs px-3" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $customer->id }}">
                                                    Delete
                                                </button>
                                            </div>
                                        </td>
                                    </tr>

                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @foreach($customers as $customer)
    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal{{ $customer->id }}">
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
                    <p class="mt-2 fs-5">Are you sure you want to delete customer <strong>{{ $customer->name }}</strong>? This cannot be undone.</p>
                </div>
                <div class="modal-footer border-0 pt-0 justify-content-center">
                    <button type="button" class="btn btn-light btn-sm px-4" data-bs-dismiss="modal">Cancel</button>
                    <form action="{{ route('affiliates.destroy', $customer) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm px-4">Yes, Delete Permanently</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</x-layouts.admin>
