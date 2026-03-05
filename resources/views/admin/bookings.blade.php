<x-layouts.admin>
    <x-slot name="styles">
        <link href="{{ asset('vendor/fullcalendar/css/main.min.css') }}" rel="stylesheet">
        <link href="{{ asset('vendor/bootstrap-select/css/bootstrap-select.min.css') }}" rel="stylesheet">
        <style>
            #bookingDetailModal .modal-header { border-bottom: none; }
            .detail-row { display: flex; gap: 12px; margin-bottom: 12px; align-items: flex-start; }
            .detail-icon { 
                width: 24px; 
                display: flex; align-items: center; justify-content: center; 
                font-size: 1.1rem; flex-shrink: 0;
                margin-top: 2px;
                color: #f1bc19 !important;
                background: transparent !important;
            }
            .detail-label { font-size: 0.7rem; text-transform: uppercase; color: #94a3b8; font-weight: 600; }
            .detail-value { font-size: 0.9rem; color: #0f172a; font-weight: 500; }
            
            /* Fillow Calendar Specific Overrides */
            .fc-daygrid-event {
                cursor: pointer;
            }
            .legend-item {
                font-weight: 600;
                font-size: 0.85rem;
                display: flex;
                align-items: center;
                gap: 8px;
                padding: 10px 15px;
                border-radius: 8px;
                margin-bottom: 10px;
                background: #f8f9fa;
                color: #495057;
            }
            .legend-dot {
                width: 12px;
                height: 12px;
                border-radius: 50%;
                display: inline-block;
            }
            .item-image-container {
                width: 100%;
                height: 120px;
                border-radius: 12px;
                overflow: hidden;
                margin-bottom: 15px;
                background: #f1f5f9;
                border: 1px solid #e2e8f0;
            }
            .item-image-container img {
                width: 100%; height: 100%; object-fit: cover;
            }
            .status-cta-container {
                display: flex;
                align-items: stretch;
                gap: 0;
                background: #f8fafc;
                border-radius: 12px;
                padding: 4px;
                border: 1px solid #e2e8f0;
                width: 100%;
            }
            .status-select-wrapper {
                flex-grow: 1;
                position: relative;
            }
            .status-select-wrapper select {
                border: none !important;
                background: transparent !important;
                height: 48px;
                font-weight: 600;
                font-size: 0.9rem;
                padding-left: 15px;
                cursor: pointer;
                box-shadow: none !important;
                color: #0f172a !important;
            }
            /* Target bootstrap-select if it's being used */
            .status-select-wrapper .bootstrap-select .dropdown-toggle {
                border: none !important;
                background: transparent !important;
                height: 48px;
                color: #0f172a !important;
                font-weight: 600;
                padding-left: 15px;
            }
            .status-select-wrapper .bootstrap-select .dropdown-toggle .filter-option-inner-inner {
                color: #0f172a !important;
            }
            .status-select-wrapper .bootstrap-select .dropdown-menu .dropdown-item {
                color: #0f172a !important;
            }
            .status-select-wrapper .bootstrap-select .dropdown-menu .dropdown-item.active,
            .status-select-wrapper .bootstrap-select .dropdown-menu .dropdown-item:hover {
                background-color: var(--primary-light);
                color: #000 !important;
            }
            .btn-update-status {
                line-height: 1;
                padding: 0 20px;
                text-align: center;
                display: flex;
                flex-direction: column;
                justify-content: center;
                height: 48px;
                border-radius: 10px !important;
                white-space: nowrap;
                min-width: 100px;
            }
            .btn-update-status span {
                font-size: 0.9rem;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: 0.5px;
            }
            
            /* Inspection Section Styles */
            .inspection-container {
                background: #f8fafc;
                border: 1px solid #e2e8f0;
                border-radius: 12px;
                padding: 15px;
                margin-top: 15px;
            }
            .condition-toggle {
                display: flex;
                gap: 10px;
                margin-bottom: 12px;
            }
            .condition-btn {
                flex: 1;
                text-align: center;
                padding: 8px;
                border-radius: 8px;
                border: 1px solid #e2e8f0;
                cursor: pointer;
                font-weight: 600;
                font-size: 0.85rem;
                transition: all 0.2s;
                background: #fff;
                color: #64748b;
            }
            .condition-btn i { margin-right: 5px; }
            .condition-btn.active.good {
                background: #dcfce7;
                color: #15803d;
                border-color: #15803d;
            }
            .condition-btn.active.damaged {
                background: #fee2e2;
                color: #b91c1c;
                border-color: #b91c1c;
            }
            .inspection-notes {
                border-radius: 8px;
                font-size: 0.85rem;
                border: 1px solid #e2e8f0;
            }
            .payment-input-group {
                margin-top: 10px;
            }
            .payment-input-label {
                font-size: 0.75rem;
                font-weight: 600;
                color: #64748b;
                margin-bottom: 4px;
                display: block;
            }
            .payment-input {
                font-weight: 600;
                color: #0f172a;
                border-radius: 8px;
                border: 1px solid #e2e8f0;
            }
            .bg-blue {
                background-color: #3065D0 !important;
                color: #fff !important;
            }
            .badge-blue {
                background-color: #3065D0 !important;
                color: #fff !important;
            }
        </style>
    </x-slot>

    <div class="row">
        <div class="col-xl-9 col-xxl-8">
            <div class="card">
                <div class="card-body">
                    <div id="calendar" class="app-fullcalendar"></div>
                </div>
            </div>
        </div>
          <div class="col-xl-3 col-xxl-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-intro-title">Booking Status</h4>

                    <div class="">
                        <div class="mb-4">
                            <label class="form-label font-w600">Filter by Car</label>
                            <select id="carFilter" class="form-control default-select">
                                <option value="">All Cars</option>
                                @foreach($cars as $car)
                                    <option value="{{ $car->id }}">
                                        {{ $car->brand }} {{ $car->model }} ({{ $car->plate_number }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div id="external-events" class="my-3">
                            <p class="text-muted">Legend for booking events on the calendar.</p>
                            
                            <div class="legend-item shadow-sm">
                                <span class="legend-dot bg-warning"></span> Pending
                            </div>
                            <div class="legend-item shadow-sm">
                                <span class="legend-dot bg-success"></span> Confirmed
                            </div>
                            <div class="legend-item shadow-sm">
                                <span class="legend-dot bg-blue"></span> Completed
                            </div>
                            <div class="legend-item shadow-sm">
                                <span class="legend-dot bg-danger"></span> Cancelled
                            </div>
                        </div>

                        <div class="mt-4 pt-3 border-top">
                            <a href="{{ route('bookings.index', ['view' => 'list']) }}" class="btn btn-primary d-block w-100">
                                <i class="fas fa-list me-2"></i> Table View
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Booking Detail Modal --}}
    <div class="modal fade" id="bookingDetailModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header pb-0">
                    <div>
                        <h5 class="modal-title font-w700" id="modal_booking_title"></h5>
                        <span class="badge mt-1" id="modal_status_badge" style="border-radius: 50px; font-size: 0.75rem;"></span>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body pt-3">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="item-image-container mb-3" style="aspect-ratio: 16/9; height: auto; min-height: 180px;">
                                <img src="" id="modal_item_image" alt="Item Image" style="object-fit: cover; width: 100%; height: 100%; border-radius: 8px;">
                            </div>
                            
                            {{-- Specific Details stack here --}}
                            <div class="detail-row">
                                <div class="detail-icon"><i class="fas fa-calendar-alt"></i></div>
                                <div>
                                    <div class="detail-label">Dates</div>
                                    <div class="detail-value" id="modal_dates"></div>
                                </div>
                            </div>
                            <div class="detail-row">
                                <div class="detail-icon"><i class="fas fa-peso-sign"></i></div>
                                <div>
                                    <div class="detail-label">Total Amount</div>
                                    <div class="detail-value fw-bold text-success fs-4" id="modal_total"></div>
                                    <div class="text-muted fw-semi-bold" style="font-size: 0.75rem;" id="modal_total_breakdown"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7 border-start">
                            <div class="detail-row">
                                <div class="detail-icon"><i class="fas fa-user"></i></div>
                                <div>
                                    <div class="detail-label">Customer</div>
                                    <div class="detail-value" id="modal_customer"></div>
                                    <div class="text-muted small" id="modal_email"></div>
                                </div>
                            </div>
                            
                            <div class="detail-row">
                                <div class="detail-icon"><i class="fas fa-phone"></i></div>
                                <div>
                                    <div class="detail-label">Phone</div>
                                    <div class="detail-value" id="modal_phone"></div>
                                </div>
                            </div>

                            <div class="detail-row" id="modal_address_row">
                                <div class="detail-icon"><i class="fas fa-map-marker-alt"></i></div>
                                <div>
                                    <div class="detail-label">Address</div>
                                    <div class="detail-value" id="modal_address"></div>
                                </div>
                            </div>

                            <div class="detail-row">
                                <div class="detail-icon"><i id="modal_type_icon" class="fas fa-car"></i></div>
                                <div>
                                    <div class="detail-label" id="modal_type_label">Item</div>
                                    <div class="detail-value" id="modal_item"></div>
                                </div>
                            </div>

                            <div class="detail-row" id="modal_proof_row">
                                <div class="detail-icon"><i class="fas fa-receipt"></i></div>
                                <div>
                                    <div class="detail-label">Proof of Payment</div>
                                    <div class="detail-value" id="modal_proof_status"></div>
                                </div>
                            </div>

                            <div class="detail-row" id="modal_special_row" style="display:none;">
                                <div class="detail-icon"><i class="fas fa-comment-alt"></i></div>
                                <div>
                                    <div class="detail-label">Special Requests</div>
                                    <div class="detail-value" id="modal_special"></div>
                                </div>
                            </div>

                            <div id="commissionBreakdown" style="display:none; margin-top: 15px; padding-top: 15px; border-top: 1px dashed #e2e8f0;">
                                <div class="detail-row">
                                    <div class="detail-icon"><i class="fas fa-money-bill-wave"></i></div>
                                    <div class="flex-fill">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="detail-label">Rental Amount</span>
                                            <span class="detail-value" id="modal_rental_amount_display">₱0.00</span>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center mt-1">
                                            <span class="detail-label">System Commission (<span id="modal_commission_rate">0</span>%)</span>
                                            <span class="detail-value text-danger" id="modal_commission_display">-₱0.00</span>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center mt-1 pt-1 border-top">
                                            <span class="detail-label">Affiliate Earnings</span>
                                            <span class="detail-value text-success" id="modal_earnings_display">₱0.00</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="detail-row mt-2" id="modal_deposit_row">
                                    <div class="detail-icon"><i class="fas fa-shield-alt"></i></div>
                                    <div class="flex-fill d-flex justify-content-between align-items-center">
                                        <span class="detail-label">Security Deposit (Held)</span>
                                        <span class="detail-value" id="modal_deposit_display">₱0.00</span>
                                    </div>
                                </div>
                                <div id="settlementSummary" style="display:none; margin-top: 10px; padding: 10px; background: #f8fafc; border-radius: 8px;">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <span class="small font-w600 text-muted">Damage Deduction</span>
                                        <span class="small font-w700 text-danger" id="modal_deducted_display">₱0.00</span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center border-top pt-1">
                                        <span class="small font-w600 text-muted">Customer Refund</span>
                                        <span class="small font-w700 text-primary" id="modal_refunded_display">₱0.00</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <form id="statusUpdateForm" method="POST" class="w-100">
                        @csrf @method('PATCH')
                        <div class="status-cta-container">
                            <div class="status-select-wrapper">
                                <select name="status" id="modal_status_select" class="form-control default-select">
                                    <option value="pending">Pending</option>
                                    <option value="confirmed">Confirmed</option>
                                    <option value="completed">Completed</option>
                                    <option value="cancelled">Cancelled</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary btn-update-status">
                                <span>Update</span>
                            </button>
                        </div>

                        <div id="paymentSection" class="inspection-container" style="display: none;">
                            <h6 class="detail-label mb-3">Payment Confirmation Details</h6>
                            <div class="row">
                                <div class="col-6 payment-input-group">
                                    <label class="payment-input-label">Actual Rental Amount (₱)</label>
                                    <input type="number" name="rental_amount" id="modal_rental_amount" class="form-control payment-input" step="0.01" placeholder="0.00">
                                </div>
                                <div class="col-6 payment-input-group">
                                    <label class="payment-input-label">Security Deposit (₱)</label>
                                    <input type="number" name="security_deposit" id="modal_security_deposit" class="form-control payment-input" step="0.01" placeholder="0.00">
                                </div>
                            </div>
                        </div>

                            <div id="inspectionSection" class="inspection-container" style="display: none;">
                                <h6 class="detail-label mb-3">Return Inspection Report</h6>
                                <div class="condition-toggle">
                                    <div class="condition-btn good active" onclick="setCondition('good')">
                                        <i class="fas fa-check-circle"></i> Clean / Good
                                    </div>
                                    <div class="condition-btn damaged" onclick="setCondition('damaged')">
                                        <i class="fas fa-exclamation-triangle"></i> Damaged / Issues
                                    </div>
                                </div>
                                <input type="hidden" name="inspection_condition" id="inspection_condition" value="good">
                                
                                <div id="damageDeductionNotice" class="mt-3 mb-3 alert alert-danger py-2 px-3 small shadow-sm" style="display:none; border-left: 4px solid #b91c1c;">
                                    <i class="fas fa-exclamation-circle me-1"></i> <strong>Note:</strong> When marked as damaged, the security deposit (₱<span id="modal_deposit_val">3,000</span>) will <strong>not</strong> be refunded.
                                </div>

                                <textarea name="inspection_notes" class="form-control inspection-notes" rows="2" placeholder="Describe any new scratches, fuel level, or issues..."></textarea>
                            </div>
                    </form>
                    <div class="w-100 text-center mt-3">
                        <form id="deleteBookingForm" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button type="button" class="btn btn-link text-danger p-0" onclick="confirmDelete()">
                                <i class="fas fa-trash-alt me-1"></i> Delete Booking Permanently
                            </button>
                        </form>
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
                        <button type="button" class="btn btn-danger flex-fill" id="confirmDeleteBtn">
                            <i class="fas fa-trash-alt me-1"></i> Delete
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="scripts">
        <script src="{{ asset('vendor/moment/moment.min.js') }}"></script>
        <script src="{{ asset('vendor/fullcalendar/js/main.min.js') }}"></script>
        
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var calendarEl = document.getElementById('calendar');

                var calendar = new FullCalendar.Calendar(calendarEl, {
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek,timeGridDay'
                    },
                    initialView: 'dayGridMonth',
                    navLinks: true,
                    editable: false,
                    selectable: false,
                    nowIndicator: true,
                    events: {
                        url: '{{ route("bookings.events") }}',
                        extraParams: function() {
                            const filter = document.getElementById('carFilter');
                            return {
                                car_id: filter ? filter.value : ''
                            };
                        }
                    },
                    eventClick: function (info) {
                        const statusSelect = document.getElementById('modal_status_select');
                        const p = info.event.extendedProps;
                        const start = info.event.start ? new Date(info.event.start).toLocaleDateString('en-PH', { month: 'short', day: 'numeric', year: 'numeric' }) : '—';
                        
                        let end = start;
                        if (info.event.end) {
                            // FullCalendar exclusive end date correction
                            const endDate = new Date(info.event.end);
                            endDate.setDate(endDate.getDate() - 1);
                            end = endDate.toLocaleDateString('en-PH', { month: 'short', day: 'numeric', year: 'numeric' });
                        }

                        document.getElementById('modal_booking_title').textContent = p.item;

                        const badge = document.getElementById('modal_status_badge');
                        badge.textContent = p.status.charAt(0).toUpperCase() + p.status.slice(1);
                        
                        // Map status to bootstrap bg classes for badge
                        const classMap = { 
                            pending: 'bg-warning', 
                            confirmed: 'bg-success', 
                            cancelled: 'bg-danger', 
                            completed: 'bg-blue' 
                        };
                        badge.className = 'badge mt-1 ' + (classMap[p.status] || 'bg-secondary');

                        document.getElementById('modal_customer').textContent = p.customer;
                        document.getElementById('modal_email').textContent    = p.email;
                        document.getElementById('modal_phone').textContent    = p.phone || '—';
                        
                        const addressRow = document.getElementById('modal_address_row');
                        if (p.address) {
                            document.getElementById('modal_address').textContent = p.address;
                            addressRow.style.display = '';
                        } else {
                            addressRow.style.display = 'none';
                        }
                        
                        document.getElementById('modal_dates').textContent    = start + (end !== start ? ' → ' + end : '');
                        document.getElementById('modal_item').textContent     = p.item;
                        document.getElementById('modal_total').textContent    = p.total;
                        
                        const rental = parseFloat(p.rental_amount || 0);
                        const deposit = parseFloat(p.security_deposit || 0);
                        document.getElementById('modal_total_breakdown').textContent = `Rental: ₱${rental.toLocaleString(undefined, {minimumFractionDigits:2})} + Deposit: ₱${deposit.toLocaleString(undefined, {minimumFractionDigits:2})}`;
                        document.getElementById('modal_type_label').textContent = p.type;
                        document.getElementById('modal_type_icon').className  = p.type === 'Car' ? 'fas fa-car' : 'fas fa-building';
                        document.getElementById('modal_item_image').src = p.image_url;

                        const proofStatus = document.getElementById('modal_proof_status');
                        const hasProof = p.proof_url && p.proof_url.length > 0;
                        if (hasProof) {
                            proofStatus.innerHTML = `<a href="${p.proof_url}" target="_blank" class="text-primary fw-bold" style="text-decoration: underline;">View Attachment</a>`;
                        } else {
                            proofStatus.innerHTML = `<span class="text-danger small fw-bold">Not Uploaded</span>`;
                        }

                        // Disable "Confirmed" option if no proof of payment
                        const confirmedOption = document.querySelector('#modal_status_select option[value="confirmed"]');
                        if (confirmedOption) {
                            if (!hasProof) {
                                confirmedOption.disabled = true;
                                confirmedOption.textContent = 'Confirmed (requires proof of payment)';
                            } else {
                                confirmedOption.disabled = false;
                                confirmedOption.textContent = 'Confirmed';
                            }
                        }

                        // Store hasProof flag on the select for use by change listener
                        statusSelect.dataset.hasProof = hasProof ? '1' : '0';
                        
                        // Handle Payment Data Display
                        const paymentSection = document.getElementById('paymentSection');
                        const rentalInput = document.getElementById('modal_rental_amount');
                        const depositInput = document.getElementById('modal_security_deposit');
                        
                        if (p.rental_amount || p.security_deposit || p.status === 'confirmed' || p.status === 'completed') {
                            paymentSection.style.display = 'block';
                            rentalInput.value = p.rental_amount || '';
                            depositInput.value = p.security_deposit || '';
                        } else {
                            paymentSection.style.display = 'none';
                        }

                        // Handle Inspection Data Display
                        const inspectionSection = document.getElementById('inspectionSection');
                        if (p.inspection) {
                            inspectionSection.style.display = 'block';
                            document.querySelector('#inspectionSection .detail-label').textContent = 'Inspection Report (Stored)';
                            setCondition(p.inspection.condition);
                            document.querySelector('.inspection-notes').value = p.inspection.notes || '';
                        } else if (p.status === 'completed') {
                            inspectionSection.style.display = 'block';
                            document.querySelector('#inspectionSection .detail-label').textContent = 'Return Inspection Report';
                            setCondition('good');
                            document.querySelector('.inspection-notes').value = '';
                        } else {
                            inspectionSection.style.display = 'none';
                        }

                        const specialRow = document.getElementById('modal_special_row');
                        if (p.special) {
                            document.getElementById('modal_special').textContent = p.special;
                            specialRow.style.display = 'flex';
                        } else {
                            specialRow.style.display = 'none';
                        }

                        document.getElementById('modal_status_select').value = p.status;
                        
                        // Handle Commission Breakdown Display
                        const commissionSection = document.getElementById('commissionBreakdown');
                        // Store raw values for toggleSections pre-filling
                        statusSelect.dataset.totalRaw = p.total.replace(/[^\d.-]/g, '');
                        
                        if (p.rental_amount || p.status === 'pending') {
                            const r = p.rental_amount || (p.total_raw - 3000); // fallback for legacy
                            const d = p.security_deposit || 3000;
                            commissionSection.style.display = 'block';
                            document.getElementById('modal_rental_amount_display').textContent = '₱' + Number(r).toLocaleString();
                            document.getElementById('modal_commission_rate').textContent = p.commission_rate || 20;
                            
                            // Estimate commission if not yet confirmed
                            const platformComm = p.platform_commission || (r * (p.commission_rate || 20) / 100);
                            const affiliateEarn = p.affiliate_earnings || (r - platformComm);

                            document.getElementById('modal_commission_display').textContent = '-₱' + Number(platformComm).toLocaleString();
                            document.getElementById('modal_earnings_display').textContent = '₱' + Number(affiliateEarn).toLocaleString();
                            document.getElementById('modal_deposit_display').textContent = '₱' + Number(d).toLocaleString();

                            const settlementSection = document.getElementById('settlementSummary');
                            if (p.status === 'completed') {
                                settlementSection.style.display = 'block';
                                document.getElementById('modal_deducted_display').textContent = '₱' + Number(p.deposit_deducted || 0).toLocaleString();
                                document.getElementById('modal_refunded_display').textContent = '₱' + Number(p.deposit_refunded || p.security_deposit).toLocaleString();
                            } else {
                                settlementSection.style.display = 'none';
                            }
                        } else {
                            commissionSection.style.display = 'none';
                        }

                        // if nice-select is used, we have to update it
                        if($.fn.selectpicker) {
                             $('#modal_status_select').selectpicker('refresh');
                        }

                        document.getElementById('statusUpdateForm').action = '/bookings/' + info.event.id + '/status';
                        document.getElementById('deleteBookingForm').action = '/bookings/' + info.event.id;

                        var myModal = new bootstrap.Modal(document.getElementById('bookingDetailModal'));
                        myModal.show();
                        
                        // Sync sections
                        setTimeout(toggleSections, 100);
                    },
                    eventDidMount: function(info) {
                        // Apply bootstrap classes to events based on color/status passed from backend
                        if(info.event.backgroundColor === '#eab308') info.el.classList.add('bg-warning', 'border-warning');
                        if(info.event.backgroundColor === '#22c55e') info.el.classList.add('bg-success', 'border-success');
                        if(info.event.backgroundColor === '#ef4444') info.el.classList.add('bg-danger', 'border-danger');
                        if(info.event.backgroundColor === '#3065D0') info.el.classList.add('bg-blue', 'border-blue');
                        info.el.classList.add('text-white');
                    }
                });

                calendar.render();

                // Handle car filter change
                const filterEl = document.getElementById('carFilter');
                if (filterEl) {
                    filterEl.addEventListener('change', function() {
                        calendar.refetchEvents();
                    });
                }

                // Toggle sections based on status
                const statusSelect = document.getElementById('modal_status_select');
                const inspectionSection = document.getElementById('inspectionSection');
                const paymentSection = document.getElementById('paymentSection');
                
                // Warning element for missing proof
                let proofWarning = document.getElementById('modal_proof_warning');
                if (!proofWarning) {
                    proofWarning = document.createElement('div');
                    proofWarning.id = 'modal_proof_warning';
                    proofWarning.className = 'alert alert-warning py-2 px-3 mt-2 small fw-bold';
                    proofWarning.innerHTML = '<i class="fas fa-exclamation-triangle me-1"></i> Cannot confirm: customer has not uploaded proof of payment.';
                    proofWarning.style.display = 'none';
                    document.querySelector('.status-cta-container').after(proofWarning);
                }

                function toggleSections() {
                    if (!statusSelect) return;
                    
                    const status = statusSelect.value;
                    const hasProof = statusSelect.dataset.hasProof === '1';

                    // Show warning if trying to select confirmed without proof
                    if (status === 'confirmed' && !hasProof) {
                        proofWarning.style.display = 'block';
                        // Revert selection without triggering infinite loop
                        statusSelect.value = 'pending';
                        if ($.fn.selectpicker) $(statusSelect).selectpicker('refresh');
                        return;
                    } else {
                        proofWarning.style.display = 'none';
                    }

                    if (status === 'completed') {
                        $(inspectionSection).slideDown();
                    } else {
                        $(inspectionSection).slideUp();
                    }
                    
                    if (status === 'confirmed' || status === 'completed') {
                        $(paymentSection).slideDown();
                        
                        // Pre-fill if empty and confirmed
                        if (status === 'confirmed') {
                            const rentalInput = document.getElementById('modal_rental_amount');
                            const depositInput = document.getElementById('modal_security_deposit');
                            if (!rentalInput.value) rentalInput.value = statusSelect.dataset.totalRaw || '';
                            if (!depositInput.value) depositInput.value = '3000';
                        }
                    } else {
                        $(paymentSection).slideUp();
                    }
                }

                if (statusSelect) {
                    statusSelect.addEventListener('change', toggleSections);
                    // For bootstrap-select
                    $(statusSelect).on('changed.bs.select', toggleSections);
                }

                window.setCondition = function(val) {
                    const conditionInput = document.getElementById('inspection_condition');
                    if (conditionInput) conditionInput.value = val;
                    document.querySelectorAll('.condition-btn').forEach(btn => btn.classList.remove('active'));
                    const activeBtn = document.querySelector(`.condition-btn.${val}`);
                    if (activeBtn) activeBtn.classList.add('active');

                    // Show notice for damaged items
                    const damageNotice = document.getElementById('damageDeductionNotice');
                    if (damageNotice) {
                        if (val === 'damaged') {
                            const depositVal = document.getElementById('modal_security_deposit').value || '3,000';
                            const displayVal = document.getElementById('modal_deposit_val');
                            if (displayVal) displayVal.textContent = Number(depositVal).toLocaleString();
                            $(damageNotice).slideDown();
                        } else {
                            $(damageNotice).slideUp();
                        }
                    }
                };

                // Handle ajax form submission to avoid reload
                const updateForm = document.getElementById('statusUpdateForm');
                if (updateForm) {
                    updateForm.addEventListener('submit', function (e) {
                        e.preventDefault();
                        const form = this;
                        fetch(form.action, {
                            method: 'POST',
                            body: new FormData(form),
                            headers: { 'X-Requested-With': 'XMLHttpRequest' }
                        }).then(r => {
                            if (r.ok || r.redirected) {
                                bootstrap.Modal.getInstance(document.getElementById('bookingDetailModal')).hide();
                                calendar.refetchEvents();
                            } else {
                                return r.json().then(data => {
                                    alert('Error: ' + (data.message || 'Validation failed. Please check your inputs.'));
                                });
                            }
                        }).catch(err => {
                            console.error(err);
                            alert('An unexpected error occurred. Please try again.');
                        });
                    });
                }

                window.confirmDelete = function() {
                    const detailModal = bootstrap.Modal.getInstance(document.getElementById('bookingDetailModal'));
                    if (detailModal) detailModal.hide();

                    const deleteModal = new bootstrap.Modal(document.getElementById('deleteConfirmModal'));
                    deleteModal.show();
                };

                document.getElementById('confirmDeleteBtn').addEventListener('click', function () {
                    bootstrap.Modal.getInstance(document.getElementById('deleteConfirmModal')).hide();
                    const form = document.getElementById('deleteBookingForm');
                    fetch(form.action, {
                        method: 'POST',
                        body: new FormData(form),
                        headers: { 'X-Requested-With': 'XMLHttpRequest' }
                    }).then(r => {
                        if (r.ok || r.redirected) {
                            calendar.refetchEvents();
                        }
                    });
                });
            });
        </script>
    </x-slot>
</x-layouts.admin>
