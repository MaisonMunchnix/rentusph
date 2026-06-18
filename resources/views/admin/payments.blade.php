<x-layouts.admin>
    <x-slot name="styles">
        <style>
            .table-responsive {
                overflow: visible !important;
            }
            .btn-xs {
                padding: 0.25rem 0.5rem;
                font-size: 0.75rem;
                line-height: 1.5;
                border-radius: 0.2rem;
            }
            .proof-preview {
                width: 40px;
                height: 40px;
                object-fit: cover;
                border-radius: 4px;
                cursor: pointer;
            }
            .status-dot {
                width: 10px;
                height: 10px;
                border-radius: 50%;
                display: inline-block;
                margin-right: 5px;
            }
            .footer {
                display: none !important;
            }
        </style>
    </x-slot>

    <div class="row">
        <div class="col-xl-12">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <div>
                    <h2 class="font-w700 mb-0">Payment Management</h2>
                    <p class="text-muted mb-0">Review and verify customer booking payments</p>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <!-- Desktop Table View -->
                    <div id="pay-table-view">
                        <!-- Payments Filter Bar -->
                        <div class="d-flex align-items-center gap-3 mb-3 flex-wrap" id="pay-filter-bar">
                            <div class="d-flex align-items-center gap-2">
                                <label class="text-muted small fw-600 mb-0" style="white-space:nowrap;"><i class="fas fa-box me-1"></i>Item</label>
                                <select id="pay-filter-item" class="form-select form-select-sm" style="min-width:130px; border-radius:0.5rem; font-size:0.82rem;">
                                    <option value="">All Items</option>
                                    <option value="car">Car</option>
                                    <option value="property">Property</option>
                                </select>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <label class="text-muted small fw-600 mb-0" style="white-space:nowrap;"><i class="fas fa-circle me-1"></i>Booking Status</label>
                                <select id="pay-filter-status" class="form-select form-select-sm" style="min-width:140px; border-radius:0.5rem; font-size:0.82rem;">
                                    <option value="">All Status</option>
                                    <option value="pending">Pending</option>
                                    <option value="confirmed">Confirmed</option>
                                    <option value="cancelled">Cancelled</option>
                                    <option value="completed">Completed</option>
                                </select>
                            </div>
                            <button id="pay-filter-reset" class="btn btn-outline-secondary btn-sm" style="border-radius:0.5rem; font-size:0.82rem;">
                                <i class="fas fa-times me-1"></i>Reset
                            </button>
                        </div>

                        <div class="table-responsive">
                            <table id="paymentsTable" class="table table-responsive-md text-nowrap datatable-enabled">
                            <thead>
                                <tr>
                                    <th><strong>ID</strong></th>
                                    <th><strong>CUSTOMER</strong></th>
                                    <th><strong>ITEM</strong></th>
                                    <th><strong>TOTAL PRICE</strong></th>
                                    <th><strong>BOOKING STATUS</strong></th>
                                    <th><strong>PROOF OF PAYMENT</strong></th>
                                    <th class="text-center"><strong>ACTIONS</strong></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($bookings as $booking)
                                    <tr>
                                        <td><strong>#{{ $booking->id }}</strong></td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="ms-0">
                                                    <h5 class="fs-14 mb-0">{{ $booking->customer_name }}</h5>
                                                    <p class="fs-12 mb-0 text-muted">{{ $booking->customer_email }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td data-filter-item="{{ $booking->bookable_type === 'App\Models\Car' ? 'car' : 'property' }}">
                                            @if($booking->bookable_type === 'App\Models\Car')
                                                <span class="badge badge-outline-primary btn-xs mb-1">Car</span>
                                                <div class="fs-13">{{ $booking->bookable->brand ?? 'N/A' }} {{ $booking->bookable->model ?? '' }}</div>
                                            @else
                                                <span class="badge badge-outline-secondary btn-xs mb-1">Property</span>
                                                <div class="fs-13">{{ $booking->bookable->title ?? 'N/A' }}</div>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <strong>₱{{ number_format($booking->total_price, 2) }}</strong>
                                                <small class="text-muted" style="font-size: 0.65rem;">
                                                    R: ₱{{ number_format($booking->rental_amount, 2) }} | D: ₱{{ number_format($booking->security_deposit, 2) }}
                                                </small>
                                            </div>
                                        </td>
                                        <td data-filter-status="{{ $booking->status }}">
                                            @php
                                                $statusColor = match($booking->status) {
                                                    'pending' => '#eab308',
                                                    'confirmed' => '#22c55e',
                                                    'cancelled' => '#ef4444',
                                                    'completed' => '#3b82f6',
                                                    default => '#6b7280'
                                                };
                                            @endphp
                                            <span class="badge light" style="background-color: {{ $statusColor }}22; color: {{ $statusColor }};">
                                                <span class="status-dot" style="background-color: {{ $statusColor }};"></span>
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
                                            @if($booking->proof_of_payment)
                                                <div class="d-flex align-items-center">
                                                    @if(Str::endsWith($booking->proof_of_payment, '.pdf'))
                                                        <a href="{{ asset('storage/' . $booking->proof_of_payment) }}" target="_blank" class="btn btn-danger btn-xs light shadow-none">
                                                            <i class="fas fa-file-pdf me-1"></i> View PDF
                                                        </a>
                                                    @else
                                                        <img src="{{ asset('storage/' . $booking->proof_of_payment) }}" class="proof-preview me-2" alt="Proof" data-bs-toggle="modal" data-bs-target="#viewProofModal{{ $booking->id }}">
                                                        <button type="button" class="btn btn-secondary btn-xs light shadow-none" data-bs-toggle="modal" data-bs-target="#viewProofModal{{ $booking->id }}">
                                                            <i class="fas fa-eye me-1"></i> View
                                                        </button>
                                                    @endif
                                                </div>
                                            @else
                                                <span class="text-danger fs-13"><i class="fas fa-times-circle me-1"></i> Not Uploaded</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <div class="dropdown">
                                                <button type="button" class="btn btn-primary light sharp shadow-none" data-bs-toggle="dropdown">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    @if($booking->status === 'pending')
                                                        @if($booking->proof_of_payment)
                                                            <form action="{{ route('bookings.status', $booking->id) }}" method="POST">
                                                                @csrf
                                                                @method('PATCH')
                                                                <input type="hidden" name="status" value="confirmed">
                                                                <button type="submit" class="dropdown-item text-success">
                                                                    <i class="fas fa-check-circle me-2"></i> Confirm Booking
                                                                </button>
                                                            </form>
                                                        @else
                                                            <button type="button" class="dropdown-item text-warning" data-bs-toggle="modal" data-bs-target="#paymentWarningModal{{ $booking->id }}">
                                                                <i class="fas fa-exclamation-triangle me-2"></i> Confirm Booking
                                                            </button>
                                                        @endif
                                                    @endif
                                                    <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#bookingDetailsModal{{ $booking->id }}">
                                                        <i class="fas fa-info-circle me-2"></i> View Details
                                                    </a>
                                                </div>
                                            </div>

                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-5">
                                            <i class="fas fa-credit-card fs-48 text-muted mb-3 d-block"></i>
                                            <h5>No payments found</h5>
                                            <p class="text-muted">When customers book and upload proof, they will appear here.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        </div>
                    </div>

                    <!-- Mobile/Tablet Card View -->
                    <div id="pay-card-view">
                        <div class="row">
                            @forelse($bookings as $booking)
                            <div class="col-md-6 col-12 mb-4">
                                <div class="card border shadow-sm h-100 mb-0">
                                    <div class="card-body p-4">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h6 class="mb-0 text-primary">Booking #{{ $booking->id }}</h6>
                                            @php
                                                $statusColor = match($booking->status) {
                                                    'pending' => '#eab308',
                                                    'confirmed' => '#22c55e',
                                                    'cancelled' => '#ef4444',
                                                    'completed' => '#3b82f6',
                                                    default => '#6b7280'
                                                };
                                            @endphp
                                            <span class="badge light" style="background-color: {{ $statusColor }}22; color: {{ $statusColor }};">
                                                <span class="status-dot" style="background-color: {{ $statusColor }};"></span>
                                                {{ ucfirst($booking->status) }}
                                            </span>
                                        </div>
                                        
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="me-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                                <i class="fas fa-user text-primary fa-lg"></i>
                                            </div>
                                            <div>
                                                <h5 class="fs-15 mb-0">{{ $booking->customer_name }}</h5>
                                                <p class="fs-13 mb-0 text-muted">{{ $booking->customer_email }}</p>
                                            </div>
                                        </div>
                                        
                                        <div class="row mb-3 bg-light rounded p-2 mx-0">
                                            <div class="col-6 px-2 border-end">
                                                <small class="text-muted d-block mb-1">Item</small>
                                                @if($booking->bookable_type === 'App\Models\Car')
                                                    <span class="badge badge-outline-primary btn-xs mb-1">Car</span>
                                                    <div class="fs-13 font-w600 text-dark">{{ $booking->bookable->brand ?? 'N/A' }} {{ $booking->bookable->model ?? '' }}</div>
                                                @else
                                                    <span class="badge badge-outline-secondary btn-xs mb-1">Property</span>
                                                    <div class="fs-13 font-w600 text-dark">{{ $booking->bookable->title ?? 'N/A' }}</div>
                                                @endif
                                            </div>
                                            <div class="col-6 px-2">
                                                <small class="text-muted d-block mb-1">Total Price</small>
                                                <strong class="text-dark">₱{{ number_format($booking->total_price, 2) }}</strong>
                                                <small class="text-muted d-block" style="font-size: 0.65rem;">
                                                    R: ₱{{ number_format($booking->rental_amount, 2) }}<br>D: ₱{{ number_format($booking->security_deposit, 2) }}
                                                </small>
                                            </div>
                                        </div>
                                        
                                        @if($booking->status === 'completed')
                                            <div class="mb-3 px-2">
                                                <small class="text-success fw-bold d-block" style="font-size: 0.75rem;">Refunded: ₱{{ number_format($booking->deposit_refunded, 2) }}</small>
                                                @if($booking->deposit_deducted > 0)
                                                    <small class="text-danger d-block" style="font-size: 0.75rem;">Deducted: ₱{{ number_format($booking->deposit_deducted, 2) }}</small>
                                                @endif
                                            </div>
                                        @endif
                                        
                                        <div class="mb-3">
                                            <small class="text-muted d-block mb-2">Proof of Payment</small>
                                            @if($booking->proof_of_payment)
                                                <div class="d-flex align-items-center">
                                                    @if(Str::endsWith($booking->proof_of_payment, '.pdf'))
                                                        <a href="{{ asset('storage/' . $booking->proof_of_payment) }}" target="_blank" class="btn btn-outline-danger btn-sm flex-grow-1">
                                                            <i class="fas fa-file-pdf me-1"></i> View PDF
                                                        </a>
                                                    @else
                                                        <img src="{{ asset('storage/' . $booking->proof_of_payment) }}" class="proof-preview me-3 border" alt="Proof" data-bs-toggle="modal" data-bs-target="#viewProofModal{{ $booking->id }}">
                                                        <button type="button" class="btn btn-outline-secondary btn-sm flex-grow-1" data-bs-toggle="modal" data-bs-target="#viewProofModal{{ $booking->id }}">
                                                            <i class="fas fa-eye me-1"></i> View Image
                                                        </button>
                                                    @endif
                                                </div>
                                            @else
                                                <span class="text-white fs-14 bg-danger-light p-2 rounded d-block text-center"><i class="fas fa-times-circle me-1"></i> Not Uploaded</span>
                                            @endif
                                        </div>
                                        
                                        <div class="d-flex gap-2 pt-3 border-top">
                                            <button type="button" class="btn btn-outline-primary btn-sm flex-grow-1" data-bs-toggle="modal" data-bs-target="#bookingDetailsModal{{ $booking->id }}">
                                                <i class="fas fa-info-circle me-1"></i> Details
                                            </button>
                                            
                                            @if($booking->status === 'pending')
                                                @if($booking->proof_of_payment)
                                                    <form action="{{ route('bookings.status', $booking->id) }}" method="POST" class="flex-grow-1 m-0">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="status" value="confirmed">
                                                        <button type="submit" class="btn btn-success btn-sm w-100">
                                                            <i class="fas fa-check-circle me-1"></i> Confirm
                                                        </button>
                                                    </form>
                                                @else
                                                    <button type="button" class="btn btn-warning btn-sm flex-grow-1" data-bs-toggle="modal" data-bs-target="#paymentWarningModal{{ $booking->id }}">
                                                        <i class="fas fa-exclamation-triangle me-1"></i> Confirm
                                                    </button>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="col-12 text-center py-5">
                                <i class="fas fa-credit-card fa-3x text-muted mb-3 d-block"></i>
                                <h5 class="text-muted">No payments found.</h5>
                            </div>
                            @endforelse
                        </div>
                    </div>
                    <!-- Pagination handled by DataTables client-side -->
                </div>
            </div>
        </div>
    </div>

    <script>
        function applyPaymentsResponsiveView() {
            var tableView = document.getElementById('pay-table-view');
            var cardView = document.getElementById('pay-card-view');
            if (!tableView || !cardView) return;
            if (window.innerWidth >= 992) {
                tableView.style.setProperty('display', 'block', 'important');
                cardView.style.setProperty('display', 'none', 'important');
            } else {
                tableView.style.setProperty('display', 'none', 'important');
                cardView.style.setProperty('display', 'block', 'important');
            }
        }
        applyPaymentsResponsiveView();
        window.addEventListener('resize', applyPaymentsResponsiveView);
    </script>

    @foreach($bookings as $booking)
        <!-- Payment Warning Modal -->
        @if(!$booking->proof_of_payment)
        <div class="modal fade" id="paymentWarningModal{{ $booking->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Action Restricted</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center py-4">
                        <i class="fas fa-exclamation-triangle text-warning mb-3" style="font-size: 3rem;"></i>
                        <h4 class="mb-2">Proof of Payment Required</h4>
                        <p class="text-muted px-3">This booking cannot be confirmed because the customer has not yet uploaded their proof of payment.</p>
                        <p class="mb-0 text-dark">Please wait for the customer to upload their receipt or bank transfer confirmation.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">I Understand</button>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Proof Modal -->
        @if($booking->proof_of_payment && !Str::endsWith($booking->proof_of_payment, '.pdf'))
        <div class="modal fade" id="viewProofModal{{ $booking->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Proof of Payment - #{{ $booking->id }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center p-0">
                        <img src="{{ asset('storage/' . $booking->proof_of_payment) }}" class="img-fluid" alt="Proof of Payment">
                    </div>
                    <div class="modal-footer">
                        <a href="{{ asset('storage/' . $booking->proof_of_payment) }}" download class="btn btn-primary btn-sm">
                            <i class="fas fa-download me-1"></i> Download
                        </a>
                        <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Booking Details Modal -->
        <div class="modal fade" id="bookingDetailsModal{{ $booking->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Booking details - #{{ $booking->id }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @php
                            $statusColor = match($booking->status) {
                                'pending' => '#eab308',
                                'confirmed' => '#22c55e',
                                'cancelled' => '#ef4444',
                                'completed' => '#3b82f6',
                                default => '#6b7280'
                            };
                        @endphp
                        <div class="row mb-3">
                            <div class="col-6">
                                <small class="text-muted d-block">Booking Dates</small>
                                <strong>{{ $booking->start_date->format('M d, Y') }} - {{ $booking->end_date->format('M d, Y') }}</strong>
                            </div>
                            <div class="col-6">
                                <small class="text-muted d-block">Customer Phone</small>
                                <strong>{{ $booking->customer_phone ?? 'N/A' }}</strong>
                            </div>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted d-block">Special Requests</small>
                            <p class="mb-0">{{ $booking->special_requests ?? 'No special requests' }}</p>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <small class="text-muted d-block">Total Amount</small>
                                <h4 class="mb-0 text-primary">₱{{ number_format($booking->total_price, 2) }}</h4>
                                <small class="text-muted" style="font-size: 0.75rem;">
                                    Rental: ₱{{ number_format($booking->rental_amount, 2) }} + Deposit: ₱{{ number_format($booking->security_deposit, 2) }}
                                </small>
                            </div>
                            <div class="text-end">
                                <small class="text-muted d-block">Current Status</small>
                                <span class="badge light" style="background-color: {{ $statusColor }}22; color: {{ $statusColor }};">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            </div>
                        </div>

                        @if($booking->status === 'completed')
                            <div class="bg-light p-3 rounded">
                                <h6 class="font-w600 text-primary mb-3" style="font-size: 0.85rem;">Deposit Settlement</h6>
                                <div class="row">
                                    <div class="col-6 mb-2">
                                        <small class="text-muted d-block">Deducted</small>
                                        <span class="fw-bold text-danger">₱{{ number_format($booking->deposit_deducted, 2) }}</span>
                                    </div>
                                    <div class="col-6 mb-2">
                                        <small class="text-muted d-block">Refunded</small>
                                        <span class="fw-bold text-success">₱{{ number_format($booking->deposit_refunded, 2) }}</span>
                                    </div>
                                </div>
                                @if($booking->inspection && $booking->inspection->notes)
                                    <div class="mt-2 pt-2 border-top">
                                        <small class="text-muted d-block mb-1">Inspection Notes</small>
                                        <p class="mb-0 fs-12 italic text-dark">"{{ $booking->inspection->notes }}"</p>
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <x-slot name="scripts">
    <script>
    $(document).ready(function() {
        var payTable = $('#paymentsTable').DataTable();
        if (!payTable) return;

        var filterItem = '';
        var filterStatus = '';

        $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
            if (settings.nTable.id !== 'paymentsTable') return true;
            var row = $(payTable.row(dataIndex).node());
            var rowItem   = row.find('td[data-filter-item]').data('filter-item')   || '';
            var rowStatus = row.find('td[data-filter-status]').data('filter-status') || '';
            var itemOk   = filterItem   === '' || rowItem   === filterItem;
            var statusOk = filterStatus === '' || rowStatus === filterStatus;
            return itemOk && statusOk;
        });

        $('#pay-filter-item').on('change', function() {
            filterItem = $(this).val();
            payTable.draw();
        });

        $('#pay-filter-status').on('change', function() {
            filterStatus = $(this).val();
            payTable.draw();
        });

        $('#pay-filter-reset').on('click', function() {
            filterItem = '';
            filterStatus = '';
            $('#pay-filter-item').val('');
            $('#pay-filter-status').val('');
            payTable.draw();
        });
    });
    </script>
    </x-slot>
</x-layouts.admin>
