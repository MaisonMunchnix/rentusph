<x-layouts.customer>
    <x-slot name="styles">
        <link href="{{ asset('vendor/bootstrap-datepicker-master/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
        <style>
            .listing-card {
                background: #ffffff !important;
                border: 1px solid rgba(0, 0, 0, 0.08) !important;
                border-radius: 20px !important;
                padding: 1.5rem !important;
                transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275) !important;
                cursor: pointer;
                position: relative;
                overflow: hidden;
                height: 100%;
                display: flex;
                flex-direction: column;
            }

            .listing-card:hover {
                transform: translateY(-10px) !important;
                border-color: rgba(234, 179, 8, 0.3) !important;
                box-shadow: 0 1rem 2rem rgba(0, 0, 0, 0.1) !important;
            }

            .image-container {
                width: 100%;
                height: 200px;
                border-radius: 12px;
                overflow: hidden;
                margin-bottom: 1.5rem;
                position: relative;
            }

            .listing-image {
                width: 100%;
                height: 100%;
                object-fit: cover;
                transition: transform 0.5s ease;
            }

            .listing-card:hover .listing-image {
                transform: scale(1.08);
            }

            .type-tag {
                position: absolute;
                top: 1rem;
                left: 1rem;
                background: #eab308;
                padding: 0.25rem 0.75rem;
                border-radius: 50px;
                font-size: 0.7rem;
                font-weight: 700;
                color: #0f172a;
                z-index: 2;
                text-transform: uppercase;
            }

            .status-tag {
                position: absolute;
                top: 1rem;
                right: 1rem;
                background: #0f172a;
                padding: 0.25rem 0.75rem;
                border-radius: 50px;
                font-size: 0.75rem;
                font-weight: 600;
                color: #eab308;
                border: 1px solid rgba(234, 179, 8, 0.5);
                z-index: 2;
            }

            .listing-title {
                font-size: 1.25rem;
                font-weight: 700;
                margin-bottom: 0.5rem;
                color: #0f172a;
            }

            .listing-specs {
                display: flex;
                justify-content: space-between;
                font-size: 0.85rem;
                margin-bottom: 1.5rem;
                padding-bottom: 1.5rem;
                border-bottom: 1px solid rgba(0, 0, 0, 0.05);
                margin-top: auto;
            }

            .listing-specs span {
                display: flex;
                align-items: center;
                gap: 0.4rem;
                color: #64748b;
            }

            .listing-footer {
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            .listing-price span {
                font-size: 1.15rem;
                font-weight: 800;
                color: #0f172a;
            }
            
            .search-bar {
                background: #fff;
                border-radius: 15px;
                padding: 20px;
                margin-bottom: 30px;
                box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            }
            
            .btn-book {
                padding: 0.5rem 1.25rem !important;
                border-radius: 50px !important;
                font-weight: 600 !important;
                font-size: 0.85rem !important;
            }

            /* Datepicker Booked Dates Styling */
            .datepicker table tr td.disabled.booked-date,
            .datepicker table tr td.disabled.booked-date:hover {
                background-color: #fee2e2 !important; /* light red */
                color: #ef4444 !important; /* red */
                text-decoration: line-through !important;
                opacity: 1 !important;
                cursor: not-allowed !important;
            }
        </style>
    </x-slot>

    <div class="row">
        <div class="col-xl-12">
            <div class="card mb-4 overflow-hidden">
                <div class="card-body py-5 position-relative">
                    <div style="position: absolute; top: -50px; right: -50px; width: 200px; height: 200px; background: rgba(234, 179, 8, 0.05); border-radius: 50%;"></div>
                    <div style="position: absolute; bottom: -30px; left: 10%; width: 100px; height: 100px; background: rgba(234, 179, 8, 0.03); border-radius: 50%;"></div>
                    
                    <h2 class="mb-2 text-dark font-w700">Welcome home, {{ Auth::user()->name }}!</h2>
                    <p class="text-muted mb-0">Explore our available fleet and premium stays ready for your next trip.</p>
                </div>
            </div>
        </div>

        <div class="col-12 mb-4">
            <div class="search-bar">
                <form action="{{ route('customer.explore') }}" method="GET" class="row align-items-end">
                    <div class="col-md-3 mb-3 mb-md-0">
                        <label class="form-label font-w600">Listing Type</label>
                        <select name="type" class="form-control" onchange="this.form.submit()">
                            <option value="all" {{ request('type') == 'all' ? 'selected' : '' }}>All Listings</option>
                            <option value="car" {{ request('type') == 'car' ? 'selected' : '' }}>Cars Only</option>
                            <option value="property" {{ request('type') == 'property' ? 'selected' : '' }}>Properties Only</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3 mb-md-0">
                        <label class="form-label font-w600">Search</label>
                        <input type="text" name="search" class="form-control" placeholder="Search brand, model, city..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-3 mb-3 mb-md-0">
                        <label class="form-label font-w600">Price Range</label>
                        <select name="price" class="form-control">
                            <option value="">Any Price</option>
                            @if(request('type') == 'car')
                                <option value="1000" {{ request('price') == '1000' ? 'selected' : '' }}>Under ₱1,000</option>
                                <option value="3000" {{ request('price') == '3000' ? 'selected' : '' }}>₱1,000 - ₱3,000</option>
                                <option value="5000" {{ request('price') == '5000' ? 'selected' : '' }}>Above ₱3,000</option>
                            @elseif(request('type') == 'property')
                                <option value="10000" {{ request('price') == '10000' ? 'selected' : '' }}>Under ₱10,000</option>
                                <option value="30000" {{ request('price') == '30000' ? 'selected' : '' }}>₱10,000 - ₱30,000</option>
                                <option value="50000" {{ request('price') == '50000' ? 'selected' : '' }}>Above ₱30,000</option>
                            @else
                                <option disabled>Select Type for Price Filter</option>
                            @endif
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">Filter</button>
                    </div>
                </form>
            </div>
        </div>

        @forelse($listings as $item)
            <div class="col-xl-4 col-md-6 col-sm-12 mb-4">
                <div class="listing-card" 
                    data-type="{{ $item->listing_type }}"
                    @if($item->listing_type == 'car')
                        data-brand="{{ $item->brand }}"
                        data-model="{{ $item->model }}"
                        data-year="{{ $item->year }}"
                        data-color="{{ $item->color }}"
                        data-transmission="{{ $item->transmission }}"
                        data-capacity="{{ $item->capacity }}"
                        data-fuel_type="{{ $item->fuel_type }}"
                        data-daily_rate="{{ number_format($item->daily_rate) }}"
                        data-description="{{ $item->description }}"
                    @else
                        data-title="{{ $item->title }}"
                        data-property_type="{{ $item->type }}"
                        data-address="{{ $item->address }}"
                        data-city="{{ $item->city }}"
                        data-region="{{ $item->region }}"
                        data-bedrooms="{{ $item->bedrooms }}"
                        data-bathrooms="{{ $item->bathrooms }}"
                        data-floor_area="{{ $item->floor_area }}"
                        data-monthly_rate="{{ number_format($item->monthly_rate) }}"
                        data-description="{{ $item->description }}"
                    @endif
                    data-security_deposit="{{ $item->security_deposit }}"
                    data-image="{{ $item->image ? asset($item->image) : '' }}">
                    
                    <div class="image-container">
                        <div class="type-tag">{{ $item->listing_type }}</div>
                        <div class="status-tag">Available</div>
                        @if($item->image)
                            <img src="{{ asset($item->image) }}" class="listing-image" alt="{{ $item->listing_type == 'car' ? $item->brand : $item->title }}">
                        @else
                            <div class="bg-light d-flex align-items-center justify-content-center h-100">
                                <i class="fas {{ $item->listing_type == 'car' ? 'fa-car' : 'fa-home' }} fs-64 text-muted opacity-25"></i>
                            </div>
                        @endif
                    </div>

                    @if($item->listing_type == 'car')
                        <h3 class="listing-title">{{ $item->brand }} {{ $item->model }}</h3>
                        <div class="listing-specs">
                            <span>
                                <i class="fas fa-cog me-1"></i>
                                {{ $item->transmission }}
                            </span>
                            <span>
                                <i class="fas fa-users me-1"></i>
                                {{ $item->capacity }} seats
                            </span>
                            <span>
                                <i class="fas fa-gas-pump me-1"></i>
                                {{ $item->fuel_type }}
                            </span>
                        </div>
                        <div class="listing-footer">
                            <div class="listing-price">
                                <span>₱{{ number_format($item->daily_rate) }}</span><small>/day</small>
                                <div class="text-primary font-w600" style="font-size: 0.75rem;">+ ₱{{ number_format($item->security_deposit) }} refundable deposit</div>
                            </div>
                            <a href="javascript:void(0);" class="btn btn-primary btn-book shadow-none" 
                                data-id="{{ $item->id }}" 
                                data-type="App\Models\Car" 
                                data-name="{{ $item->brand }} {{ $item->model }}" 
                                data-security_deposit="{{ $item->security_deposit }}"
                                data-rate="₱{{ number_format($item->daily_rate) }}/day">Book Now</a>
                        </div>
                    @else
                        <h3 class="listing-title text-truncate">{{ $item->title }}</h3>
                        <p class="text-muted small mb-2">
                            <i class="fas fa-map-marker-alt text-primary me-1"></i>
                            {{ $item->city }}, {{ $item->region }}
                        </p>
                        <div class="listing-specs">
                            <span>
                                <i class="fas fa-building me-1"></i>
                                {{ $item->type }}
                            </span>
                            <span>
                                <i class="fas fa-bed me-1"></i>
                                {{ $item->bedrooms }} BR
                            </span>
                            <span>
                                <i class="fas fa-bath me-1"></i>
                                {{ $item->bathrooms }} BA
                            </span>
                        </div>
                        <div class="listing-footer">
                            <div class="listing-price">
                                <span>₱{{ number_format($item->monthly_rate) }}</span><small>/mo</small>
                                <div class="text-primary font-w600" style="font-size: 0.75rem;">+ ₱{{ number_format($item->security_deposit) }} refundable deposit</div>
                            </div>
                            <a href="javascript:void(0);" class="btn btn-success btn-book shadow-none" 
                                data-id="{{ $item->id }}" 
                                data-type="App\Models\Property" 
                                data-name="{{ $item->title }}" 
                                data-security_deposit="{{ $item->security_deposit }}"
                                data-rate="₱{{ number_format($item->monthly_rate) }}/mo">Book Stay</a>
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <div class="mb-3">
                    <i class="fas fa-search fa-4x text-muted opacity-25"></i>
                </div>
                <h4 class="text-muted">No listings match your criteria.</h4>
            </div>
        @endforelse

        <div class="col-12 mt-4">
            {{ $listings->links() }}
        </div>
    </div>

    <!-- Listing Details Modal -->
    <div class="modal fade" id="detailModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content overflow-hidden">
                <div class="modal-body p-0">
                    <div class="row g-0">
                        <div class="col-md-5">
                            <div class="h-100 bg-light d-flex align-items-center justify-content-center overflow-hidden" style="min-height: 300px;">
                                <img id="detail_image" src="" alt="" class="w-100 h-100" style="object-fit: cover; display: none;">
                                <div id="detail_no_image" class="text-center p-5">
                                    <i class="fas fa-image fa-4x text-muted opacity-25"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="p-4 h-100 d-flex flex-column">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <span id="detail_type" class="badge bg-primary mb-2 text-dark font-w700" style="font-size: 0.65rem; text-transform: uppercase;"></span>
                                        <h3 id="detail_title" class="mb-0 font-w700 text-dark"></h3>
                                    </div>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                
                                <p id="detail_address" class="text-muted small mb-3" style="display:none;">
                                    <i class="fas fa-map-marker-alt text-primary me-1"></i>
                                    <span id="detail_location"></span>
                                </p>

                                <div class="row mb-4" id="car_details" style="display:none;">
                                    <div class="col-4">
                                        <div class="p-2 border rounded-12 text-center bg-light-soft">
                                            <i class="fas fa-cog text-primary mb-1"></i>
                                            <div class="small font-w600" id="detail_transmission"></div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="p-2 border rounded-12 text-center bg-light-soft">
                                            <i class="fas fa-users text-primary mb-1"></i>
                                            <div class="small font-w600" id="detail_capacity"></div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="p-2 border rounded-12 text-center bg-light-soft">
                                            <i class="fas fa-gas-pump text-primary mb-1"></i>
                                            <div class="small font-w600" id="detail_fuel"></div>
                                        </div>
                                    </div>
                                    <div class="col-12 mt-3">
                                        <div class="d-flex justify-content-between small px-1">
                                            <span>Year: <strong id="detail_year"></strong></span>
                                            <span>Color: <strong id="detail_color"></strong></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-4" id="property_details" style="display:none;">
                                    <div class="col-4">
                                        <div class="p-2 border rounded-12 text-center bg-light-soft">
                                            <i class="fas fa-building text-success mb-1"></i>
                                            <div class="small font-w600" id="detail_prop_type"></div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="p-2 border rounded-12 text-center bg-light-soft">
                                            <i class="fas fa-bed text-success mb-1"></i>
                                            <div class="small font-w600" id="detail_bedrooms"></div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="p-2 border rounded-12 text-center bg-light-soft">
                                            <i class="fas fa-bath text-success mb-1"></i>
                                            <div class="small font-w600" id="detail_bathrooms"></div>
                                        </div>
                                    </div>
                                    <div class="col-12 mt-3 text-center">
                                        <span class="small">Floor Area: <strong id="detail_floor_area"></strong> sqm</span>
                                    </div>
                                </div>

                                <div class="mb-4 flex-grow-1">
                                    <h6 class="font-w600 text-dark mb-2">Description</h6>
                                    <p id="detail_description" class="text-muted" style="font-size: 0.9rem; line-height: 1.6;"></p>
                                </div>

                                <div class="d-flex align-items-center justify-content-between border-top pt-3">
                                    <div class="p-2">
                                        <h4 class="mb-0 text-dark font-w800" id="detail_price"></h4>
                                        <span class="text-muted small" id="detail_price_unit"></span>
                                        <div class="mt-2">
                                            <span class="badge badge-md light badge-warning text-dark font-w600" style="font-size: 0.85rem; border: 1px solid rgba(0,0,0,0.05);">
                                                <i class="fas fa-shield-alt me-2 text-primary"></i> +₱<span id="detail_deposit">3,000</span> Refundable Security Deposit
                                            </span>
                                        </div>
                                    </div>
                                    <div id="detail_booking_info" style="display:none;">
                                        <!-- Store relevant ID/Type for button -->
                                        <input type="hidden" id="detail_id">
                                        <input type="hidden" id="detail_full_type">
                                        <input type="hidden" id="detail_deposit_val">
                                        <button type="button" class="btn btn-primary btn-book-from-modal px-4">Book Now</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Booking Modal -->
    <div class="modal fade" id="bookingModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="bookingModalLabel">Book Your Stay</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('bookings.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="bookable_id" id="modal_bookable_id">
                        <input type="hidden" name="bookable_type" id="modal_bookable_type">
                        <input type="hidden" name="security_deposit" id="modal_security_deposit">
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label font-w600">Selected Item</label>
                                <input type="text" id="modal_item_name" class="form-control" readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label font-w600">Rate</label>
                                <input type="text" id="modal_item_rate" class="form-control" readonly>
                            </div>
                        </div>

                        <hr>
                        <h6 class="mb-3 text-primary">Your Information</h6>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label font-w600">Full Name</label>
                                <input type="text" name="customer_name" class="form-control" value="{{ Auth::user()->name }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label font-w600">Email Address</label>
                                <input type="email" name="customer_email" class="form-control" value="{{ Auth::user()->email }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label font-w600">Phone Number</label>
                                <input type="text" name="customer_phone" class="form-control" placeholder="0912-345-6789" value="{{ Auth::user()->phone }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label font-w600">Address</label>
                                <input type="text" name="customer_address" class="form-control" placeholder="Your permanent address" value="{{ Auth::user()->address }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label font-w600">Pickup/Check-in Date</label>
                                <input type="text" name="start_date" id="start_date" class="form-control datepicker-input" required placeholder="YYYY-MM-DD" autocomplete="off">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label font-w600">Return/Check-out Date</label>
                                <input type="text" name="end_date" id="end_date" class="form-control datepicker-input" required placeholder="YYYY-MM-DD" autocomplete="off">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label font-w600">Special Requests (Optional)</label>
                            <textarea name="special_requests" class="form-control" rows="2"></textarea>
                        </div>

                        <div class="card bg-light border-0 mb-0">
                            <div class="card-body p-3">
                                <h6 class="font-w700 mb-3 text-dark">Price Breakdown</h6>
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Rental Amount (<span id="calc_days">0</span> days)</span>
                                    <span class="font-w600 text-dark">₱<span id="calc_rental">0.00</span></span>
                                </div>
                                <div class="d-flex justify-content-between mb-3">
                                    <span class="text-muted">Security Deposit (Refundable)</span>
                                    <span class="font-w600 text-dark">₱<span id="calc_deposit">3,000.00</span></span>
                                </div>
                                <div class="d-flex justify-content-between border-top pt-3">
                                    <span class="font-w700 text-primary h5 mb-0">Total Amount to Prepare</span>
                                    <span class="font-w800 text-primary h4 mb-0">₱<span id="calc_total">0.00</span></span>
                                </div>
                                <div class="alert alert-success light py-2 px-3 mt-3 mb-0 small">
                                    <i class="fas fa-info-circle me-2"></i> <strong>Note:</strong> A ₱<span id="note_deposit">3,000</span> refundable security deposit is included and will be returned after the rental.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Confirm Booking</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Payment Upload Modal (shown after booking is saved) -->
    <div class="modal fade" id="paymentUploadModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 overflow-hidden" style="border-radius: 20px;">
                <div class="modal-body p-0">
                    <div class="row g-0">

                        <!-- LEFT: Payment Instructions -->
                        <div class="col-md-5" style="background: linear-gradient(160deg, #0f172a 0%, #1e293b 100%); padding: 2rem;">
                            <div class="d-flex align-items-center gap-2 mb-3">
                                <div class="d-flex align-items-center justify-content-center bg-warning rounded-circle" style="width:36px;height:36px;min-width:36px;">
                                    <i class="fas fa-check text-dark" style="font-size:0.85rem;"></i>
                                </div>
                                <div>
                                    <div style="font-size:0.7rem;color:rgba(255,255,255,0.5);text-transform:uppercase;letter-spacing:0.08em;">Booking Saved</div>
                                    <div style="font-size:0.95rem;font-weight:700;color:#fff;">
                                        #<span class="js-booking-id">—</span>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3" style="padding:0.75rem 1rem;background:rgba(234,179,8,0.1);border:1px solid rgba(234,179,8,0.3);border-radius:10px;">
                                <div style="font-size:0.75rem;color:rgba(255,255,255,0.5);">Total Amount to Pay</div>
                                <div style="font-size:1.5rem;font-weight:900;color:#eab308;">₱<span class="js-booking-total">—</span></div>
                                <div style="font-size:0.7rem;color:rgba(255,255,255,0.4);">Rental + Refundable Deposit</div>
                            </div>

                            <p style="font-size:0.82rem;color:rgba(255,255,255,0.6);margin-bottom:1.25rem;">
                                Transfer to any of these accounts, then upload your proof below so we can confirm your booking.
                            </p>

                            <!-- Payment accounts -->
                            <div style="display:flex;flex-direction:column;gap:0.6rem;">

                                <div style="background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.08);border-radius:10px;padding:0.75rem 1rem;">
                                    <div style="font-size:0.65rem;font-weight:700;letter-spacing:0.1em;text-transform:uppercase;color:#eab308;margin-bottom:0.25rem;">GCash</div>
                                    <div style="font-size:0.9rem;font-weight:700;color:#fff;">09276736974</div>
                                    <div style="font-size:0.75rem;color:rgba(255,255,255,0.5);">Fatima Stephen</div>
                                </div>

                                <div style="background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.08);border-radius:10px;padding:0.75rem 1rem;">
                                    <div style="font-size:0.65rem;font-weight:700;letter-spacing:0.1em;text-transform:uppercase;color:#eab308;margin-bottom:0.25rem;">BDO</div>
                                    <div style="font-size:0.9rem;font-weight:700;color:#fff;">005090310115</div>
                                    <div style="font-size:0.75rem;color:rgba(255,255,255,0.5);">Fatima M Stephen</div>
                                </div>

                                <div style="background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.08);border-radius:10px;padding:0.75rem 1rem;">
                                    <div style="font-size:0.65rem;font-weight:700;letter-spacing:0.1em;text-transform:uppercase;color:#eab308;margin-bottom:0.25rem;">BPI</div>
                                    <div style="font-size:0.9rem;font-weight:700;color:#fff;">2469187481</div>
                                    <div style="font-size:0.75rem;color:rgba(255,255,255,0.5);">Fatima M Stephen</div>
                                </div>

                                <div style="background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.08);border-radius:10px;padding:0.75rem 1rem;">
                                    <div style="font-size:0.65rem;font-weight:700;letter-spacing:0.1em;text-transform:uppercase;color:#eab308;margin-bottom:0.25rem;">Maya / Maribank</div>
                                    <div style="font-size:0.9rem;font-weight:700;color:#fff;">10907332744</div>
                                    <div style="font-size:0.75rem;color:rgba(255,255,255,0.5);">Fatima M Stephen</div>
                                </div>

                            </div>
                        </div>

                        <!-- RIGHT: Upload Form -->
                        <div class="col-md-7 p-4">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <h5 class="fw-bold text-dark mb-0">Upload Proof of Payment</h5>
                                    <p class="text-muted small mb-0">Screenshot, photo, or PDF of your transfer receipt</p>
                                </div>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>

                            <form id="paymentProofForm" action="" method="POST" enctype="multipart/form-data">
                                @csrf

                                <!-- Drop zone -->
                                <div id="dropZone" style="border:2px dashed #e2e8f0;border-radius:14px;padding:2.5rem 1rem;text-align:center;cursor:pointer;transition:all 0.2s;margin-bottom:1rem;" onclick="document.getElementById('proofFileInput').click()">
                                    <i class="fas fa-cloud-upload-alt fa-2x text-muted mb-2"></i>
                                    <p class="mb-0 text-muted" style="font-size:0.875rem;">Click to browse or drag & drop your file here</p>
                                    <p class="mb-0 text-muted" style="font-size:0.75rem;">JPG, PNG, PDF — max 5MB</p>
                                </div>
                                <input type="file" id="proofFileInput" name="proof_of_payment" class="d-none" accept="image/*,.pdf" required>

                                <!-- Preview -->
                                <div id="filePreview" class="d-none mb-3" style="border:1px solid #e2e8f0;border-radius:10px;padding:0.75rem 1rem;display:flex;align-items:center;gap:0.75rem;">
                                    <i class="fas fa-file-image text-warning fa-lg"></i>
                                    <div class="flex-grow-1">
                                        <div id="fileName" style="font-size:0.85rem;font-weight:600;color:#0f172a;"></div>
                                        <div id="fileSize" style="font-size:0.75rem;color:#64748b;"></div>
                                    </div>
                                    <button type="button" onclick="clearFile()" class="btn-close btn-sm"></button>
                                </div>

                                <button type="submit" class="btn btn-warning fw-bold w-100 py-2 mb-2" id="submitProofBtn" style="border-radius:10px;color:#0f172a;">
                                    <i class="fas fa-paper-plane me-2"></i>Submit Proof of Payment
                                </button>

                                <button type="button" class="btn btn-light w-100 py-2" data-bs-dismiss="modal" style="border-radius:10px;font-size:0.85rem;color:#64748b;">
                                    I'll upload this later from My Bookings
                                </button>
                            </form>

                            <div class="mt-3 p-3" style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:10px;font-size:0.8rem;color:#166534;">
                                <i class="fas fa-info-circle me-2"></i>
                                Your booking is reserved. Once we verify your payment, we'll confirm it via email.
                            </div>

                            <div class="mt-2 p-3" style="background:#fefce8;border:1px solid #fde68a;border-radius:10px;font-size:0.8rem;color:#92400e;">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <strong>Skipping?</strong> You can come back to this page anytime, or go to
                                <a href="{{ route('bookings.index') }}" style="color:#b45309;font-weight:600;text-decoration:underline;">
                                    My Bookings
                                </a>
                                to find the <strong>"Upload Proof"</strong> button next to your pending booking.
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="scripts">
    <script src="{{ asset('vendor/bootstrap-datepicker-master/js/bootstrap-datepicker.min.js') }}"></script>
    <script>
        @if(session('booking_success'))
            $(document).ready(function() {
                // Populate booking details into the payment modal
                const bookingId    = '{{ session("new_booking_id") }}';
                const bookingTotal = '{{ session("new_booking_total") }}';
                const proofRoute   = '{{ url("bookings") }}/' + bookingId + '/proof';

                document.querySelectorAll('.js-booking-id').forEach(el => el.textContent = bookingId);
                document.querySelectorAll('.js-booking-total').forEach(el => el.textContent = bookingTotal);
                document.getElementById('paymentProofForm').action = proofRoute;

                var paymentModal = new bootstrap.Modal(document.getElementById('paymentUploadModal'));
                paymentModal.show();
            });
        @endif

        function initDatepickers(takenDates) {
            $('.datepicker-input').datepicker('destroy');
            
            $('#start_date').datepicker({
                format: 'yyyy-mm-dd',
                startDate: new Date(),
                autoclose: true,
                todayHighlight: true,
                datesDisabled: takenDates,
                beforeShowDay: function(date) {
                    var ymd = date.getFullYear() + "-" + 
                              ("0" + (date.getMonth() + 1)).slice(-2) + "-" + 
                              ("0" + date.getDate()).slice(-2);
                    if (takenDates.indexOf(ymd) !== -1) {
                        return { classes: 'booked-date' };
                    }
                    return {};
                }
            }).on('changeDate', function(e) {
                $('#end_date').datepicker('setStartDate', e.date);
                if ($('#end_date').datepicker('getDate') < e.date) {
                    $('#end_date').datepicker('setDate', e.date);
                }
                calculateTotal();
            });

            $('#end_date').datepicker({
                format: 'yyyy-mm-dd',
                startDate: new Date(),
                autoclose: true,
                todayHighlight: true,
                datesDisabled: takenDates,
                beforeShowDay: function(date) {
                    var ymd = date.getFullYear() + "-" + 
                              ("0" + (date.getMonth() + 1)).slice(-2) + "-" + 
                              ("0" + date.getDate()).slice(-2);
                    if (takenDates.indexOf(ymd) !== -1) {
                        return { classes: 'booked-date' };
                    }
                    return {};
                }
            }).on('changeDate', function(e) {
                calculateTotal();
            });
        }

        function calculateTotal() {
            const startStr = $('#start_date').val();
            const endStr = $('#end_date').val();
            const rateStr = $('#modal_item_rate').val(); // e.g., "₱1,000/day" or "₱30,000/mo"
            const deposit = parseFloat($('#modal_security_deposit').val()) || 0;
            
            if (!startStr || !endStr || !rateStr) return;

            const start = new Date(startStr);
            const end = new Date(endStr);
            const diffTime = Math.abs(end - start);
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) || 1;

            const rate = parseFloat(rateStr.replace(/[^\d.]/g, ''));
            const isMonthly = rateStr.includes('/mo');
            
            let rentalAmount = 0;
            if (isMonthly) {
                rentalAmount = (rate / 30) * diffDays;
            } else {
                rentalAmount = rate * diffDays;
            }

            const total = rentalAmount + deposit;

            $('#calc_days').text(diffDays);
            $('#calc_rental').text(rentalAmount.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2}));
            $('#calc_total').text(total.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2}));
        }

        $(document).on('click', '.btn-book', function(e) {
            e.preventDefault();
            e.stopPropagation(); // Prevent detail modal from opening
            
            const id = $(this).attr('data-id');
            const type = $(this).attr('data-type');
            const name = $(this).attr('data-name');
            const rate = $(this).attr('data-rate');
            const security_deposit = $(this).attr('data-security_deposit');
            const label = type === 'App\\Models\\Car' ? 'Book Car' : 'Book Stay';
 
            $('#modal_bookable_id').val(id);
            $('#modal_bookable_type').val(type);
            $('#modal_item_name').val(name);
            $('#modal_item_rate').val(rate);
            $('#modal_security_deposit').val(security_deposit);
            $('#calc_deposit').text(parseFloat(security_deposit).toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2}));
            $('#note_deposit').text(parseFloat(security_deposit).toLocaleString());
            $('#bookingModalLabel').text(label);

            $.ajax({
                url: '{{ route("bookings.taken-dates") }}',
                method: 'GET',
                data: { bookable_id: id, bookable_type: type },
                success: function(takenDates) {
                    initDatepickers(takenDates);
                    $('#bookingModal').modal('show');
                },
                error: function() {
                    initDatepickers([]);
                    $('#bookingModal').modal('show');
                }
            });
        });

        $(document).on('click', '.listing-card', function() {
            const data = $(this).data();
            const type = data.type;

            // Common fields
            $('#detail_type').text(type);
            $('#detail_description').text(data.description || 'No description available.');
            
            if (data.image) {
                $('#detail_image').attr('src', data.image).show();
                $('#detail_no_image').hide();
            } else {
                $('#detail_image').hide();
                $('#detail_no_image').show();
            }

            if (type === 'car') {
                $('#detail_title').text(data.brand + ' ' + data.model);
                $('#detail_address').hide();
                $('#car_details').show();
                $('#property_details').hide();

                $('#detail_transmission').text(data.transmission);
                $('#detail_capacity').text(data.capacity + ' Seats');
                $('#detail_fuel').text(data.fuel_type);
                $('#detail_year').text(data.year);
                $('#detail_color').text(data.color);
                $('#detail_price').text('₱' + data.daily_rate);
                $('#detail_price_unit').text('per day');
                $('#detail_deposit').text(parseFloat(data.security_deposit).toLocaleString());
                
                // For booking from modal
                $('#detail_id').val($(this).find('.btn-book').data('id'));
                $('#detail_full_type').val('App\\Models\\Car');
                $('#detail_deposit_val').val(data.security_deposit);
                $('.btn-book-from-modal').removeClass('btn-success').addClass('btn-primary').text('Book');
            } else {
                $('#detail_title').text(data.title);
                $('#detail_location').text(data.address + ', ' + data.city + ', ' + data.region);
                $('#detail_address').show();
                $('#car_details').hide();
                $('#property_details').show();

                $('#detail_prop_type').text(data.property_type);
                $('#detail_bedrooms').text(data.bedrooms + ' BR');
                $('#detail_bathrooms').text(data.bathrooms + ' BA');
                $('#detail_floor_area').text(data.floor_area);
                $('#detail_price').text('₱' + data.monthly_rate);
                $('#detail_price_unit').text('per month');
                $('#detail_deposit').text(parseFloat(data.security_deposit).toLocaleString());
                
                // For booking from modal
                $('#detail_id').val($(this).find('.btn-book').data('id'));
                $('#detail_full_type').val('App\\Models\\Property');
                $('#detail_deposit_val').val(data.security_deposit);
                $('.btn-book-from-modal').removeClass('btn-primary').addClass('btn-success').text('Book Stay');
            }
            
            $('#detail_booking_info').show();
            $('#detailModal').modal('show');
        });

        // Handle booking from the detail modal
        $(document).on('click', '.btn-book-from-modal', function() {
            const id = $('#detail_id').val();
            const type = $('#detail_full_type').val();
            const name = $('#detail_title').text();
            const rate = $('#detail_price').text() + '/' + ($('#detail_price_unit').text().includes('day') ? 'day' : 'mo');
            const security_deposit = $('#detail_deposit_val').val();
            const label = type === 'App\\Models\\Car' ? 'Book Car' : 'Book Stay';

            $('#detailModal').modal('hide');

            $('#modal_bookable_id').val(id);
            $('#modal_bookable_type').val(type);
            $('#modal_item_name').val(name);
            $('#modal_item_rate').val(rate);
            $('#modal_security_deposit').val(security_deposit);
            $('#calc_deposit').text(parseFloat(security_deposit).toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2}));
            $('#note_deposit').text(parseFloat(security_deposit).toLocaleString());
            $('#bookingModalLabel').text(label);

            $.ajax({
                url: '{{ route("bookings.taken-dates") }}',
                method: 'GET',
                data: { bookable_id: id, bookable_type: type },
                success: function(takenDates) {
                    initDatepickers(takenDates);
                    setTimeout(() => {
                        $('#bookingModal').modal('show');
                    }, 400); // Wait for detail modal to close
                },
                error: function() {
                    initDatepickers([]);
                    setTimeout(() => {
                        $('#bookingModal').modal('show');
                    }, 400);
                }
            });
        });
    </script>
    <script>
        // ── Payment proof file preview & drag-drop ──
        const proofInput = document.getElementById('proofFileInput');
        const dropZone   = document.getElementById('dropZone');

        if (proofInput) {
            proofInput.addEventListener('change', function() {
                showFilePreview(this.files[0]);
            });
        }

        if (dropZone) {
            dropZone.addEventListener('dragover', e => {
                e.preventDefault();
                dropZone.style.borderColor = '#eab308';
                dropZone.style.background  = 'rgba(234,179,8,0.04)';
            });
            dropZone.addEventListener('dragleave', () => {
                dropZone.style.borderColor = '#e2e8f0';
                dropZone.style.background  = '';
            });
            dropZone.addEventListener('drop', e => {
                e.preventDefault();
                dropZone.style.borderColor = '#e2e8f0';
                dropZone.style.background  = '';
                const file = e.dataTransfer.files[0];
                if (file) {
                    proofInput.files = e.dataTransfer.files;
                    showFilePreview(file);
                }
            });
        }

        function showFilePreview(file) {
            if (!file) return;
            document.getElementById('fileName').textContent = file.name;
            document.getElementById('fileSize').textContent = (file.size / 1024).toFixed(1) + ' KB';
            document.getElementById('dropZone').classList.add('d-none');
            document.getElementById('filePreview').classList.remove('d-none');
        }

        function clearFile() {
            document.getElementById('proofFileInput').value = '';
            document.getElementById('filePreview').classList.add('d-none');
            document.getElementById('dropZone').classList.remove('d-none');
        }
    </script>
    </x-slot>
    @if(isset($intentCar) && $intentCar && !session('booking_success'))
        <!-- Hidden button to trigger booking modal via JS if intent exists -->
        <button id="intent-book-btn" class="btn-book d-none" 
            data-id="{{ $intentCar->id }}" 
            data-type="App\Models\Car" 
            data-name="{{ $intentCar->brand }} {{ $intentCar->model }}" 
            data-security_deposit="{{ $intentCar->security_deposit }}"
            data-rate="₱{{ number_format($intentCar->daily_rate) }}/day"></button>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                setTimeout(() => {
                    const btn = document.getElementById('intent-book-btn');
                    if (btn) {
                        $(btn).trigger('click');
                    }
                }, 500);
            });
            
            // Clean up the URL only AFTER the modal is closed manually
            // This ensures if there are validation errors on form submit, it still pops up
            $('#bookingModal').on('hidden.bs.modal', function () {
                if (window.history.replaceState) {
                    const url = new URL(window.location);
                    url.searchParams.delete('intent_car');
                    window.history.replaceState(null, '', url.toString());
                }
            });
        </script>
    @endif
</x-layouts.customer>
