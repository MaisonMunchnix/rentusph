<x-layouts.admin>
    <x-slot name="styles">
        <style>
            .badge-blue {
                background-color: #3065D0 !important;
                color: #fff !important;
            }
        </style>
    </x-slot>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header border-0 pb-0 flex-wrap">
                    <h4 class="card-title">Booking List</h4>
                    <div class="d-flex align-items-center mt-3 mt-sm-0">
                        <a href="{{ route('bookings.index') }}" class="btn btn-primary btn-sm me-2">
                            <i class="fas fa-calendar me-2"></i>Calendar View
                        </a>
                        <form action="{{ route('bookings.index') }}" method="GET" class="d-flex align-items-center">
                            <input type="hidden" name="view" value="list">
                            <select name="status" class="form-control default-select form-control-sm me-2" onchange="this.form.submit()">
                                <option value="">All Status</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                            <select name="car_id" class="form-control default-select form-control-sm me-2" onchange="this.form.submit()">
                                <option value="">All Cars</option>
                                @foreach($cars as $car)
                                    <option value="{{ $car->id }}" {{ request('car_id') == $car->id ? 'selected' : '' }}>
                                        {{ $car->brand }} {{ $car->model }} ({{ $car->plate_number }})
                                    </option>
                                @endforeach
                            </select>
                        </form>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-responsive-md">
                            <thead>
                                <tr>
                                    <th><strong>BOOKING ID</strong></th>
                                    <th><strong>CUSTOMER</strong></th>
                                    <th><strong>ITEM</strong></th>
                                    <th><strong>DATES</strong></th>
                                    <th><strong>ADDRESS</strong></th>
                                    <th><strong>TOTAL</strong></th>
                                    <th><strong>STATUS</strong></th>
                                    <th class="text-end"><strong>ACTION</strong></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($bookings as $booking)
                                <tr>
                                    <td><strong>#{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}</strong></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <span class="w-space-no">{{ $booking->customer_name }}</span>
                                        </div>
                                        <small class="text-muted">{{ $booking->customer_email }}</small>
                                    </td>
                                    <td>
                                        @if($booking->bookable_type === 'App\Models\Car')
                                            <span class="badge badge-xs light badge-primary">Car</span>
                                            {{ $booking->bookable->brand ?? 'N/A' }} {{ $booking->bookable->model ?? '' }}
                                        @else
                                            <span class="badge badge-xs light badge-info">Property</span>
                                            {{ $booking->bookable->title ?? 'N/A' }}
                                        @endif
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($booking->start_date)->format('M d') }} - {{ $booking->end_date ? \Carbon\Carbon::parse($booking->end_date)->format('M d, Y') : 'N/A' }}</td>
                                    <td><small>{{ $booking->customer_address ?? '—' }}</small></td>
                                    <td>₱{{ number_format($booking->total_price, 2) }}</td>
                                    <td>
                                        @php
                                            $statusClasses = [
                                                'pending' => 'badge-warning',
                                                'confirmed' => 'badge-success',
                                                'completed' => 'badge-blue',
                                                'cancelled' => 'badge-danger'
                                            ];
                                        @endphp
                                        <span class="badge light {{ $statusClasses[$booking->status] ?? 'badge-secondary' }}">
                                            {{ ucfirst($booking->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-end">
                                            <div class="dropdown">
                                                <button type="button" class="btn btn-primary light btn-xs sharp" data-bs-toggle="dropdown">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <form action="{{ route('bookings.status', $booking->id) }}" method="POST">
                                                        @csrf @method('PATCH')
                                                        @if($booking->proof_of_payment)
                                                            <button type="submit" name="status" value="confirmed" class="dropdown-item">Confirm</button>
                                                        @else
                                                            <button type="button" class="dropdown-item disabled text-muted" disabled
                                                                title="Cannot confirm: proof of payment not uploaded"
                                                                data-bs-toggle="tooltip" data-bs-placement="left">
                                                                Confirm <i class="fas fa-lock ms-1 small"></i>
                                                            </button>
                                                        @endif
                                                        <button type="submit" name="status" value="completed" class="dropdown-item">Complete</button>
                                                        <button type="submit" name="status" value="cancelled" class="dropdown-item">Cancel</button>
                                                    </form>
                                                    <div class="dropdown-divider"></div>
                                                    <button type="button" class="dropdown-item text-danger"
                                                        onclick="confirmDeleteBooking('{{ route('bookings.destroy', $booking->id) }}')">
                                                        <i class="fas fa-trash-alt me-1"></i> Delete Booking
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center">No bookings found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">
                        {{ $bookings->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Delete Confirmation Modal --}}
    <div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 420px;">
            <div class="modal-content">
                <div class="modal-body text-center pt-4 pb-3 px-4">
                    <div class="mb-3" style="font-size: 2.5rem; color: #ef4444;"><i class="fas fa-trash-alt"></i></div>
                    <h5 class="fw-700 mb-2">Delete Booking?</h5>
                    <p class="text-muted mb-4" style="font-size: 0.9rem;">This will permanently delete the booking and all associated records. <strong>This action cannot be undone.</strong></p>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-outline-secondary flex-fill" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-danger flex-fill" id="confirmDeleteListBtn">
                            <i class="fas fa-trash-alt me-1"></i> Delete
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Hidden delete form --}}
    <form id="deleteBookingListForm" method="POST" style="display:none;">
        @csrf @method('DELETE')
    </form>

    <x-slot name="scripts">
        <script>
            var _deleteAction = '';

            window.confirmDeleteBooking = function(action) {
                _deleteAction = action;
                new bootstrap.Modal(document.getElementById('deleteConfirmModal')).show();
            };

            document.getElementById('confirmDeleteListBtn').addEventListener('click', function () {
                bootstrap.Modal.getInstance(document.getElementById('deleteConfirmModal')).hide();
                const form = document.getElementById('deleteBookingListForm');
                form.action = _deleteAction;
                form.submit();
            });

            // Initialize Bootstrap tooltips
            document.addEventListener('DOMContentLoaded', function () {
                var tooltipEls = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                tooltipEls.forEach(function (el) { new bootstrap.Tooltip(el); });
            });
        </script>
    </x-slot>
</x-layouts.admin>
