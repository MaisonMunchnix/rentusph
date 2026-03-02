<x-layouts.admin>
    <x-slot name="styles">
        {{-- FullCalendar --}}
        <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.css" rel="stylesheet">
        <style>
            .fc { font-family: inherit; }

            .fc .fc-toolbar-title { font-size: 1.25rem; font-weight: 700; color: #0f172a; }

            .fc .fc-button-primary {
                background: #eab308 !important;
                border-color: #eab308 !important;
                color: #0f172a !important;
                font-weight: 600;
                border-radius: 8px !important;
                box-shadow: none !important;
            }

            .fc .fc-button-primary:hover, .fc .fc-button-primary:focus {
                background: #ca8a04 !important;
                border-color: #ca8a04 !important;
            }

            .fc .fc-button-primary:disabled {
                opacity: 0.5 !important;
            }

            .fc .fc-today-button {
                border-radius: 50px !important;
                padding: 0.35rem 1rem !important;
            }

            .fc-daygrid-day.fc-day-today {
                background: rgba(234,179,8,0.08) !important;
            }

            .fc-event {
                border-radius: 6px !important;
                border: none !important;
                padding: 2px 6px !important;
                font-size: 0.8rem !important;
                cursor: pointer;
            }

            .legend-item {
                display: flex;
                align-items: center;
                gap: 6px;
                font-size: 0.82rem;
                font-weight: 600;
                color: #475569;
            }

            .legend-dot {
                width: 10px; height: 10px;
                border-radius: 50%;
                flex-shrink: 0;
            }

            #bookingDetailModal .modal-header {
                border-bottom: none;
            }

            .detail-row { 
                display: flex; 
                gap: 12px; 
                margin-bottom: 12px; 
                align-items: flex-start;
            }

            .detail-icon { 
                width: 32px; height: 32px; border-radius: 8px; 
                display: flex; align-items: center; justify-content: center; 
                font-size: 0.85rem; flex-shrink: 0;
                background: rgba(234,179,8,0.12); color: #ca8a04;
            }

            .detail-label { font-size: 0.7rem; text-transform: uppercase; color: #94a3b8; font-weight: 600; }
            .detail-value { font-size: 0.9rem; color: #0f172a; font-weight: 500; }
        </style>
    </x-slot>

    <div class="row">
        <div class="col-12">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <div>
                    <h2 class="font-w700 mb-0">Bookings Calendar</h2>
                    <p class="text-muted mb-0">Visual overview of all customer booking schedules</p>
                </div>
                <div class="d-flex gap-3 align-items-center flex-wrap">
                    <div class="legend-item"><div class="legend-dot" style="background:#eab308"></div> Pending</div>
                    <div class="legend-item"><div class="legend-dot" style="background:#22c55e"></div> Confirmed</div>
                    <div class="legend-item"><div class="legend-dot" style="background:#3b82f6"></div> Completed</div>
                    <div class="legend-item"><div class="legend-dot" style="background:#ef4444"></div> Cancelled</div>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card p-4">
                <div id="calendar"></div>
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
                    <div class="detail-row">
                        <div class="detail-icon"><i class="fas fa-calendar-alt"></i></div>
                        <div>
                            <div class="detail-label">Dates</div>
                            <div class="detail-value" id="modal_dates"></div>
                        </div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-icon"><i id="modal_type_icon" class="fas fa-car"></i></div>
                        <div>
                            <div class="detail-label" id="modal_type_label">Item</div>
                            <div class="detail-value" id="modal_item"></div>
                        </div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-icon"><i class="fas fa-peso-sign"></i></div>
                        <div>
                            <div class="detail-label">Total Amount</div>
                            <div class="detail-value fw-bold" id="modal_total"></div>
                        </div>
                    </div>
                    <div class="detail-row" id="modal_special_row" style="display:none;">
                        <div class="detail-icon"><i class="fas fa-comment-alt"></i></div>
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
                            <select name="status" id="modal_status_select" class="form-control form-control-sm" style="width:auto;">
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
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>
    <script>
        const statusColors = {
            pending:   '#eab308',
            confirmed: '#22c55e',
            cancelled: '#ef4444',
            completed: '#3b82f6',
        };

        document.addEventListener('DOMContentLoaded', function () {
            const calendarEl = document.getElementById('calendar');

            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left:   'prev,next today',
                    center: 'title',
                    right:  'dayGridMonth,timeGridWeek,listMonth'
                },
                height: 'auto',
                events: '{{ route("bookings.events") }}',
                eventClick: function (info) {
                    const p = info.event.extendedProps;
                    const start = info.event.start ? info.event.start.toLocaleDateString('en-PH', { month: 'short', day: 'numeric', year: 'numeric' }) : '—';
                    const endRaw = info.event.end ? new Date(info.event.end.getTime() - 86400000) : null;
                    const end = endRaw ? endRaw.toLocaleDateString('en-PH', { month: 'short', day: 'numeric', year: 'numeric' }) : start;

                    document.getElementById('modal_booking_title').textContent = p.item;

                    const badge = document.getElementById('modal_status_badge');
                    const colorMap = { pending:'#eab308', confirmed:'#22c55e', cancelled:'#ef4444', completed:'#3b82f6' };
                    badge.textContent = p.status.charAt(0).toUpperCase() + p.status.slice(1);
                    badge.style.background = (colorMap[p.status] || '#6b7280') + '22';
                    badge.style.color = colorMap[p.status] || '#6b7280';

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
                    document.getElementById('statusUpdateForm').action = '/bookings/' + info.event.id + '/status';

                    var modal = new bootstrap.Modal(document.getElementById('bookingDetailModal'));
                    modal.show();
                }
            });

            calendar.render();

            // Refresh calendar after status update
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
</x-layouts.admin>
