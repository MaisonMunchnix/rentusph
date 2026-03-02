<x-layouts.admin>
    <x-slot name="styles">
        <style>
            .badge-pending   { background: rgba(234,179,8,0.15);  color: #ca8a04; }
            .badge-confirmed { background: rgba(34,197,94,0.15);  color: #15803d; }
            .badge-cancelled { background: rgba(239,68,68,0.15);  color: #b91c1c; }
            .badge-completed { background: rgba(59,130,246,0.15); color: #1d4ed8; }
            .status-badge {
                padding: 0.3rem 0.75rem;
                border-radius: 50px;
                font-size: 0.78rem;
                font-weight: 600;
            }
            .search-bar {
                background: #fff;
                border-radius: 15px;
                padding: 16px 20px;
                margin-bottom: 24px;
                box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            }
            .type-pill {
                font-size: 0.7rem;
                font-weight: 700;
                padding: 0.2rem 0.6rem;
                border-radius: 50px;
                text-transform: uppercase;
            }
            .type-car      { background: rgba(234,179,8,0.15); color: #92400e; }
            .type-property { background: rgba(99,102,241,0.15); color: #4338ca; }
        </style>
    </x-slot>

    <div class="row">
        <div class="col-12">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <div>
                    <h2 class="font-w700 mb-0">All Bookings</h2>
                    <p class="text-muted mb-0">Manage and review customer bookings</p>
                </div>
                <span class="badge bg-dark text-white px-3 py-2" style="border-radius:50px;">
                    {{ $bookings->total() }} total
                </span>
            </div>
        </div>

        {{-- Filters --}}
        <div class="col-12">
            <div class="search-bar">
                <form action="{{ route('bookings.index') }}" method="GET" class="row align-items-end g-2">
                    <div class="col-md-4">
                        <label class="form-label font-w600 mb-1">Search Customer</label>
                        <input type="text" name="search" class="form-control" placeholder="Name or email..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label font-w600 mb-1">Type</label>
                        <select name="type" class="form-control">
                            <option value="">All Types</option>
                            <option value="car"      {{ request('type') == 'car'      ? 'selected' : '' }}>Cars</option>
                            <option value="property" {{ request('type') == 'property' ? 'selected' : '' }}>Properties</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label font-w600 mb-1">Status</label>
                        <select name="status" class="form-control">
                            <option value="">All Statuses</option>
                            <option value="pending"   {{ request('status') == 'pending'   ? 'selected' : '' }}>Pending</option>
                            <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">Filter</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Table --}}
        <div class="col-12">
            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead style="background:#f8f9fa;">
                                <tr>
                                    <th class="ps-4">ID</th>
                                    <th>Customer</th>
                                    <th>Item</th>
                                    <th>Dates</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th class="pe-4">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($bookings as $booking)
                                    <tr>
                                        <td class="ps-4">
                                            <strong class="text-muted">#BK-{{ $booking->id }}</strong>
                                        </td>
                                        <td>
                                            <div class="font-w600">{{ $booking->customer_name }}</div>
                                            <small class="text-muted">{{ $booking->customer_email }}</small>
                                        </td>
                                        <td>
                                            @php $isCar = $booking->bookable_type === 'App\Models\Car'; @endphp
                                            <span class="type-pill {{ $isCar ? 'type-car' : 'type-property' }}">
                                                {{ $isCar ? 'Car' : 'Property' }}
                                            </span>
                                            <div class="mt-1 font-w600 small">
                                                @if($isCar)
                                                    {{ $booking->bookable->brand ?? 'N/A' }} {{ $booking->bookable->model ?? '' }}
                                                @else
                                                    {{ $booking->bookable->title ?? 'N/A' }}
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <div class="small">{{ \Carbon\Carbon::parse($booking->start_date)->format('M d, Y') }}</div>
                                            @if($booking->end_date)
                                                <div class="small text-muted">to {{ \Carbon\Carbon::parse($booking->end_date)->format('M d, Y') }}</div>
                                            @endif
                                        </td>
                                        <td>
                                            <strong>₱{{ number_format($booking->total_price, 2) }}</strong>
                                        </td>
                                        <td>
                                            @php
                                                $cls = match($booking->status) {
                                                    'pending'   => 'badge-pending',
                                                    'confirmed' => 'badge-confirmed',
                                                    'cancelled' => 'badge-cancelled',
                                                    'completed' => 'badge-completed',
                                                    default     => ''
                                                };
                                            @endphp
                                            <span class="status-badge {{ $cls }}">{{ ucfirst($booking->status) }}</span>
                                        </td>
                                        <td class="pe-4">
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-light" data-bs-toggle="dropdown">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li>
                                                        <button class="dropdown-item"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#statusModal"
                                                            data-id="{{ $booking->id }}"
                                                            data-name="{{ $isCar ? ($booking->bookable->brand ?? '') . ' ' . ($booking->bookable->model ?? '') : ($booking->bookable->title ?? 'N/A') }}"
                                                            data-customer="{{ $booking->customer_name }}"
                                                            data-status="{{ $booking->status }}">
                                                            <i class="fas fa-edit me-2 text-primary"></i> Update Status
                                                        </button>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-5">
                                            <i class="fas fa-calendar-times fa-3x text-muted opacity-25 mb-3 d-block"></i>
                                            <h5 class="text-muted">No bookings found.</h5>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="mt-4">
                {{ $bookings->withQueryString()->links() }}
            </div>
        </div>
    </div>

    {{-- Update Status Modal --}}
    <div class="modal fade" id="statusModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update Booking Status</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="statusForm" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="modal-body">
                        <p class="text-muted mb-3">
                            Booking for <strong id="status_item"></strong> by <strong id="status_customer"></strong>.
                        </p>
                        <div class="mb-3">
                            <label class="form-label font-w600">New Status</label>
                            <select name="status" id="status_select" class="form-control">
                                <option value="pending">Pending</option>
                                <option value="confirmed">Confirmed</option>
                                <option value="completed">Completed</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Status</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <x-slot name="scripts">
    <script>
        document.getElementById('statusModal').addEventListener('show.bs.modal', function (event) {
            const btn = event.relatedTarget;
            document.getElementById('status_item').textContent     = btn.dataset.name;
            document.getElementById('status_customer').textContent = btn.dataset.customer;
            document.getElementById('status_select').value         = btn.dataset.status;
            document.getElementById('statusForm').action           = '/bookings/' + btn.dataset.id + '/status';
        });
    </script>
    </x-slot>
</x-layouts.admin>
