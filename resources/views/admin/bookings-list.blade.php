<x-layouts.admin>
    <x-slot name="styles">
        <style>
            .badge-blue {
                background-color: #88c3ffb9 !important;
                color: #0063c5ff !important;
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
                        <form action="{{ route('bookings.index') }}" method="GET" class="row g-2 align-items-center">
                            <input type="hidden" name="view" value="list">
                            <div class="col-auto">
                                <input type="text" name="search" class="form-control form-control-sm" placeholder="Search customer..." value="{{ request('search') }}">
                            </div>
                            <div class="col-auto">
                                <select name="status" class="form-control default-select form-control-sm" onchange="this.form.submit()">
                                    <option value="">All Status</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                            </div>
                            <div class="col-auto">
                                <select name="car_id" class="form-control default-select form-control-sm" onchange="this.form.submit()">
                                    <option value="">All Cars</option>
                                    @foreach($cars as $car)
                                        <option value="{{ $car->id }}" {{ request('car_id') == $car->id ? 'selected' : '' }}>
                                            {{ $car->brand }} {{ $car->model }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-auto">
                                <select name="property_id" class="form-control default-select form-control-sm" onchange="this.form.submit()">
                                    <option value="">All Properties</option>
                                    @foreach($properties as $property)
                                        <option value="{{ $property->id }}" {{ request('property_id') == $property->id ? 'selected' : '' }}>
                                            {{ $property->title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-auto">
                                <button type="submit" class="btn btn-primary btn-sm">Filter</button>
                                @if(request()->hasAny(['search', 'status', 'car_id', 'property_id']))
                                    <a href="{{ route('bookings.index', ['view' => 'list']) }}" class="btn btn-light btn-sm ms-1">Reset</a>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-responsive-md datatable-enabled">
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
                                            <span class="badge light badge-primary text-dark">
                                                {{ $booking->bookable->brand ?? 'N/A' }} {{ $booking->bookable->model ?? '' }}
                                            </span>
                                        @else
                                            <span class="badge dark badge-dark">
                                                {{ $booking->bookable->title ?? 'N/A' }}
                                            </span>
                                        @endif
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($booking->start_date)->format('M d') }} - {{ $booking->end_date ? \Carbon\Carbon::parse($booking->end_date)->format('M d, Y') : 'N/A' }}</td>
                                    <td><small>{{ $booking->customer_address ?? '—' }}</small></td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <strong>₱{{ number_format($booking->total_price, 2) }}</strong>
                                            <small class="text-muted" style="font-size: 0.65rem;">
                                                R: ₱{{ number_format($booking->rental_amount, 2) }} | D: ₱{{ number_format($booking->security_deposit, 2) }}
                                            </small>
                                        </div>
                                    </td>
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
                                        @if($booking->status === 'completed')
                                            <div class="mt-1" style="line-height: 1.2;">
                                                <small class="text-success fw-bold" style="font-size: 0.6rem;">Ref: ₱{{ number_format($booking->deposit_refunded, 2) }}</small>
                                                @if($booking->deposit_deducted > 0)
                                                    <br><small class="text-danger" style="font-size: 0.6rem;">Ded: ₱{{ number_format($booking->deposit_deducted, 2) }}</small>
                                                @endif
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-end">
                                            <div class="dropdown">
                                                <button type="button" class="btn btn-primary light btn-xs sharp" data-bs-toggle="dropdown">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    @if($booking->status === 'pending')
                                                        @if($booking->proof_of_payment)
                                                            <button type="button" class="dropdown-item" 
                                                                onclick="openStatusModal('{{ $booking->id }}', 'confirmed', '{{ $booking->total_price }}')">Confirm</button>
                                                        @else
                                                            <button type="button" class="dropdown-item disabled text-muted" disabled
                                                                title="Cannot confirm: proof of payment not uploaded"
                                                                data-bs-toggle="tooltip" data-bs-placement="left">
                                                                Confirm <i class="fas fa-lock ms-1 small"></i>
                                                            </button>
                                                        @endif
                                                    @endif

                                                    @if($booking->status === 'confirmed')
                                                        <button type="button" class="dropdown-item"
                                                            onclick="openStatusModal('{{ $booking->id }}', 'completed', '{{ $booking->rental_amount }}', '{{ $booking->security_deposit }}')">Complete</button>
                                                    @endif

                                                    @if($booking->status === 'pending' || $booking->status === 'confirmed')
                                                        <form action="{{ route('bookings.status', $booking->id) }}" method="POST" class="d-inline">
                                                            @csrf @method('PATCH')
                                                            <button type="submit" name="status" value="cancelled" class="dropdown-item">Cancel</button>
                                                        </form>
                                                    @endif
                                                    <div class="dropdown-divider"></div>
                                                    <button type="button" class="dropdown-item text-danger"
                                                        onclick="confirmDeleteBooking('{{ route('bookings.destroy', $booking->id) }}', '{{ route('bookings.status', $booking->id) }}')">
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
                    <!-- Pagination handled by DataTables client-side -->
                </div>
            </div>
        </div>
    </div>

    {{-- Delete/Cancel Confirmation Modal --}}
    <div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 440px;">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-700">Manage Booking</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body px-4 pb-4 pt-2">
                    <p class="text-muted mb-4" style="font-size: 0.9rem;">Would you like to <strong>cancel</strong> this booking (recommended), or <strong>delete</strong> it permanently?</p>
                    <div class="d-grid gap-2">
                        <button type="button" class="btn btn-warning" id="confirmCancelListBtn">
                            <i class="fas fa-ban me-2"></i> Cancel Booking
                        </button>
                        <button type="button" class="btn btn-outline-danger flex-fill" id="confirmDeleteListBtn"
                                onclick="document.getElementById('deleteBookingListForm').submit()">
                            <i class="fas fa-trash-alt me-2"></i> Delete Permanently
                        </button>
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Keep Booking</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Status Update Modal --}}
    <div class="modal fade" id="statusUpdateModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-700" id="statusModalTitle">Update Booking Status</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="statusUpdateForm" method="POST">
                    @csrf @method('PATCH')
                    <input type="hidden" name="status" id="modal_status_value">
                    <div class="modal-body">
                        <!-- Confirmation Section -->
                        <div id="confirmSection" style="display:none;">
                            <div class="alert alert-info py-2 small mb-3">
                                <i class="fas fa-info-circle me-1"></i> Verify and finalize the rental amounts below.
                            </div>
                            <div class="row">
                                <div class="col-6 mb-3">
                                    <label class="form-label small fw-bold">Rental Amount (₱)</label>
                                    <input type="number" name="rental_amount" id="modal_rental_amount" class="form-control" step="0.01">
                                </div>
                                <div class="col-6 mb-3">
                                    <label class="form-label small fw-bold">Security Deposit (₱)</label>
                                    <input type="number" name="security_deposit" id="modal_security_deposit" class="form-control" step="0.01" value="3000">
                                </div>
                            </div>
                        </div>

                        <!-- Completion/Inspection Section -->
                        <div id="completeSection" style="display:none;">
                            <h6 class="detail-label mb-3">Return Inspection Report</h6>
                            <div class="d-flex gap-2 mb-3">
                                <button type="button" class="btn btn-outline-success flex-fill active condition-btn good" onclick="setCondition('good')">
                                    <i class="fas fa-check-circle me-1"></i> Good
                                </button>
                                <button type="button" class="btn btn-outline-danger flex-fill condition-btn damaged" onclick="setCondition('damaged')">
                                    <i class="fas fa-exclamation-triangle me-1"></i> Damaged
                                </button>
                            </div>
                            <input type="hidden" name="inspection_condition" id="inspection_condition" value="good">
                            
                            <div id="damageDeductionInput" class="mb-3" style="display:none;">
                                <label class="form-label small fw-bold text-danger">Damage Deduction (₱)</label>
                                <input type="number" name="deposit_deducted" id="modal_deposit_deducted" class="form-control border-danger" step="0.01" placeholder="0.00">
                                <small class="text-muted">Will be deducted from the <span id="deposit_label">₱0</span> deposit.</small>
                            </div>

                            <div class="mb-3">
                                <label class="form-label small fw-bold">Inspection Notes</label>
                                <textarea name="inspection_notes" class="form-control" rows="2" placeholder="Describe condition..."></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0 pt-0">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update Status</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Hidden delete form --}}
    <form id="deleteBookingListForm" method="POST" style="display:none;">
        @csrf @method('DELETE')
    </form>

    <x-slot name="scripts">
        <script>
            window.confirmDeleteBooking = function(deleteUrl, cancelUrl) {
                const form = document.getElementById('deleteBookingListForm');
                form.action = deleteUrl;
                // Store cancel URL on the modal for the cancel button
                document.getElementById('deleteConfirmModal').dataset.cancelUrl = cancelUrl || '';
                const modal = new bootstrap.Modal(document.getElementById('deleteConfirmModal'));
                modal.show();
            };

            document.getElementById('confirmCancelListBtn').addEventListener('click', function () {
                const cancelUrl = document.getElementById('deleteConfirmModal').dataset.cancelUrl;
                if (!cancelUrl) return;

                const formData = new FormData();
                formData.append('_token', '{{ csrf_token() }}');
                formData.append('_method', 'PATCH');
                formData.append('status', 'cancelled');

                fetch(cancelUrl, {
                    method: 'POST',
                    body: formData,
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                }).then(r => {
                    if (r.ok || r.redirected) {
                        bootstrap.Modal.getInstance(document.getElementById('deleteConfirmModal')).hide();
                        window.location.reload();
                    } else {
                        alert('Could not cancel this booking. It may already be completed.');
                    }
                }).catch(err => {
                    console.error(err);
                    alert('An unexpected error occurred.');
                });
            });

            window.openStatusModal = function(id, status, rental = '', deposit = '3000') {
                const form = document.getElementById('statusUpdateForm');
                form.action = `/bookings/${id}/status`;
                document.getElementById('modal_status_value').value = status;
                
                document.getElementById('statusModalTitle').textContent = status === 'confirmed' ? 'Confirm Booking' : 'Complete Booking';
                
                document.getElementById('confirmSection').style.display = status === 'confirmed' ? 'block' : 'none';
                document.getElementById('completeSection').style.display = status === 'completed' ? 'block' : 'none';
                
                if (status === 'confirmed') {
                    document.getElementById('modal_rental_amount').value = rental;
                    document.getElementById('modal_security_deposit').value = deposit;
                } else if (status === 'completed') {
                    document.getElementById('deposit_label').textContent = '₱' + Number(deposit).toLocaleString();
                    setCondition('good');
                }
                
                new bootstrap.Modal(document.getElementById('statusUpdateModal')).show();
            };

            window.setCondition = function(val) {
                document.getElementById('inspection_condition').value = val;
                document.querySelectorAll('.condition-btn').forEach(btn => btn.classList.remove('active'));
                document.querySelector(`.condition-btn.${val}`).classList.add('active');
                
                const damageInput = document.getElementById('damageDeductionInput');
                damageInput.style.display = val === 'damaged' ? 'block' : 'none';
            };

            // Initialize Bootstrap tooltips
            document.addEventListener('DOMContentLoaded', function () {
                var tooltipEls = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                tooltipEls.forEach(function (el) { new bootstrap.Tooltip(el); });
            });
        </script>
    </x-slot>
</x-layouts.admin>
