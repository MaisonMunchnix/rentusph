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
                    <div class="table-responsive">
                        <table class="table table-responsive-md text-nowrap">
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
                                        <td>
                                            @if($booking->bookable_type === 'App\Models\Car')
                                                <span class="badge badge-outline-primary btn-xs mb-1">Car</span>
                                                <div class="fs-13">{{ $booking->bookable->brand ?? 'N/A' }} {{ $booking->bookable->model ?? '' }}</div>
                                            @else
                                                <span class="badge badge-outline-info btn-xs mb-1">Property</span>
                                                <div class="fs-13">{{ $booking->bookable->title ?? 'N/A' }}</div>
                                            @endif
                                        </td>
                                        <td><strong>₱{{ number_format($booking->total_price, 2) }}</strong></td>
                                        <td>
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
                                        </td>
                                        <td>
                                            @if($booking->proof_of_payment)
                                                <div class="d-flex align-items-center">
                                                    @if(Str::endsWith($booking->proof_of_payment, '.pdf'))
                                                        <a href="{{ asset('storage/' . $booking->proof_of_payment) }}" target="_blank" class="btn btn-info btn-xs light shadow-none">
                                                            <i class="fas fa-file-pdf me-1"></i> View PDF
                                                        </a>
                                                    @else
                                                        <img src="{{ asset('storage/' . $booking->proof_of_payment) }}" class="proof-preview me-2" alt="Proof" data-bs-toggle="modal" data-bs-target="#viewProofModal{{ $booking->id }}">
                                                        <button type="button" class="btn btn-info btn-xs light shadow-none" data-bs-toggle="modal" data-bs-target="#viewProofModal{{ $booking->id }}">
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
                                                        <form action="{{ route('bookings.status', $booking->id) }}" method="POST">
                                                            @csrf
                                                            @method('PATCH')
                                                            <input type="hidden" name="status" value="confirmed">
                                                            <button type="submit" class="dropdown-item text-success">
                                                                <i class="fas fa-check-circle me-2"></i> Confirm Booking
                                                            </button>
                                                        </form>
                                                    @endif
                                                    <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#bookingDetailsModal{{ $booking->id }}">
                                                        <i class="fas fa-info-circle me-2"></i> View Details
                                                    </a>
                                                </div>
                                            </div>

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
                                                            <div class="d-flex justify-content-between align-items-center">
                                                                <div>
                                                                    <small class="text-muted d-block">Total Amount</small>
                                                                    <h4 class="mb-0 text-primary">₱{{ number_format($booking->total_price, 2) }}</h4>
                                                                </div>
                                                                <div>
                                                                    <small class="text-muted d-block">Current Status</small>
                                                                    <span class="badge light" style="background-color: {{ $statusColor }}22; color: {{ $statusColor }};">
                                                                        {{ ucfirst($booking->status) }}
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
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
                    <div class="mt-3">
                        {{ $bookings->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.admin>
