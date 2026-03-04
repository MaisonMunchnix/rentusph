<x-layouts.affiliate>
    <x-slot name="styles">
        <link href="{{ asset('vendor/fullcalendar/css/main.min.css') }}" rel="stylesheet">
        <link href="{{ asset('vendor/bootstrap-select/css/bootstrap-select.min.css') }}" rel="stylesheet">
        <style>
            #bookingDetailModal .modal-header { border-bottom: none; }
            .detail-row { display: flex; gap: 12px; margin-bottom: 12px; align-items: flex-start; }
            .detail-icon { 
                width: 32px; height: 32px; border-radius: 8px; 
                display: flex; align-items: center; justify-content: center; 
                font-size: 0.85rem; flex-shrink: 0;
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
                        <div id="external-events" class="my-3">
                            <p class="text-muted">Legend for your booking events on the calendar.</p>
                            
                            <div class="legend-item shadow-sm">
                                <span class="legend-dot bg-warning"></span> Pending
                            </div>
                            <div class="legend-item shadow-sm">
                                <span class="legend-dot bg-success"></span> Confirmed
                            </div>
                            <div class="legend-item shadow-sm">
                                <span class="legend-dot bg-primary"></span> Completed
                            </div>
                            <div class="legend-item shadow-sm">
                                <span class="legend-dot bg-danger"></span> Cancelled
                            </div>
                        </div>

                        <div class="mt-4 pt-3 border-top">
                            <a href="{{ route('bookings.index', ['view' => 'list']) }}" class="btn btn-primary d-block w-100">
                                <i class="fas fa-list me-2"></i> View List
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Booking Detail Modal --}}
    <div class="modal fade" id="bookingDetailModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header pb-0">
                    <div>
                        <h5 class="modal-title font-w700" id="modal_booking_title"></h5>
                        <span class="badge mt-1" id="modal_status_badge" style="border-radius: 50px; font-size: 0.75rem;"></span>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body pt-3">
                    <div class="detail-row">
                        <div class="detail-icon bg-primary-light text-primary"><i class="fas fa-user"></i></div>
                        <div>
                            <div class="detail-label">Customer</div>
                            <div class="detail-value" id="modal_customer"></div>
                            <div class="text-muted small" id="modal_email"></div>
                        </div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-icon bg-info-light text-info"><i class="fas fa-phone"></i></div>
                        <div>
                            <div class="detail-label">Phone</div>
                            <div class="detail-value" id="modal_phone"></div>
                        </div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-icon bg-success-light text-success"><i class="fas fa-calendar-alt"></i></div>
                        <div>
                            <div class="detail-label">Dates</div>
                            <div class="detail-value" id="modal_dates"></div>
                        </div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-icon bg-warning-light text-warning"><i id="modal_type_icon" class="fas fa-car"></i></div>
                        <div>
                            <div class="detail-label" id="modal_type_label">Item</div>
                            <div class="detail-value" id="modal_item"></div>
                        </div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-icon bg-danger-light text-danger"><i class="fas fa-peso-sign"></i></div>
                        <div>
                            <div class="detail-label">Total Amount</div>
                            <div class="detail-value fw-bold" id="modal_total"></div>
                        </div>
                    </div>
                    <div class="detail-row" id="modal_special_row" style="display:none;">
                        <div class="detail-icon bg-dark-light text-dark"><i class="fas fa-comment-alt"></i></div>
                        <div>
                            <div class="detail-label">Special Requests</div>
                            <div class="detail-value" id="modal_special"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <form id="statusUpdateForm" method="POST">
                        @csrf @method('PATCH')
                        <div class="d-flex align-items-center gap-2">
                            <select name="status" id="modal_status_select" class="form-control default-select form-control-sm" style="width:140px;">
                                <option value="pending">Pending</option>
                                <option value="confirmed">Confirmed</option>
                                <option value="completed">Completed</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                            <button type="submit" class="btn btn-primary btn-sm px-3">Update Status</button>
                        </div>
                    </form>
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
                    events: '{{ route("bookings.events") }}',
                    eventClick: function (info) {
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
                            completed: 'bg-primary' 
                        };
                        badge.className = 'badge mt-1 ' + (classMap[p.status] || 'bg-secondary');

                        document.getElementById('modal_customer').textContent = p.customer;
                        document.getElementById('modal_email').textContent    = p.email;
                        document.getElementById('modal_phone').textContent    = p.phone || '—';
                        document.getElementById('modal_dates').textContent    = start + (end !== start ? ' → ' + end : '');
                        document.getElementById('modal_item').textContent     = p.item;
                        document.getElementById('modal_total').textContent    = p.total;
                        document.getElementById('modal_type_label').textContent = p.type;
                        document.getElementById('modal_type_icon').className  = p.type === 'Car' ? 'fas fa-car' : 'fas fa-building';

                        const specialRow = document.getElementById('modal_special_row');
                        if (p.special) {
                            document.getElementById('modal_special').textContent = p.special;
                            specialRow.style.display = 'flex';
                        } else {
                            specialRow.style.display = 'none';
                        }

                        document.getElementById('modal_status_select').value = p.status;
                        // if nice-select is used, we have to update it
                        if($.fn.selectpicker) {
                             $('#modal_status_select').selectpicker('refresh');
                        }

                        document.getElementById('statusUpdateForm').action = '/bookings/' + info.event.id + '/status';

                        var myModal = new bootstrap.Modal(document.getElementById('bookingDetailModal'));
                        myModal.show();
                    },
                    eventDidMount: function(info) {
                        // Apply bootstrap classes to events based on color/status passed from backend
                        if(info.event.backgroundColor === '#eab308') info.el.classList.add('bg-warning', 'border-warning');
                        if(info.event.backgroundColor === '#22c55e') info.el.classList.add('bg-success', 'border-success');
                        if(info.event.backgroundColor === '#ef4444') info.el.classList.add('bg-danger', 'border-danger');
                        if(info.event.backgroundColor === '#3b82f6') info.el.classList.add('bg-primary', 'border-primary');
                        info.el.classList.add('text-white');
                    }
                });

                calendar.render();

                // Handle ajax form submission to avoid reload
                document.getElementById('statusUpdateForm').addEventListener('submit', function (e) {
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
                        }
                    });
                });
            });
        </script>
    </x-slot>
</x-layouts.affiliate>
