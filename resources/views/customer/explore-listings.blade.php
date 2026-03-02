<x-layouts.customer>
    <x-slot name="styles">
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
                            </div>
                            <a href="javascript:void(0);" class="btn btn-primary btn-book shadow-none" 
                                data-id="{{ $item->id }}" 
                                data-type="App\Models\Car" 
                                data-name="{{ $item->brand }} {{ $item->model }}" 
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
                            </div>
                            <a href="javascript:void(0);" class="btn btn-success btn-book shadow-none" 
                                data-id="{{ $item->id }}" 
                                data-type="App\Models\Property" 
                                data-name="{{ $item->title }}" 
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
                                    </div>
                                    <div id="detail_booking_info" style="display:none;">
                                        <!-- Store relevant ID/Type for button -->
                                        <input type="hidden" id="detail_id">
                                        <input type="hidden" id="detail_full_type">
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
                                <input type="text" name="customer_phone" class="form-control" value="{{ Auth::user()->phone }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label font-w600">Pickup/Check-in Date</label>
                                <input type="date" name="start_date" class="form-control" required min="{{ date('Y-m-d') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label font-w600">Return/Check-out Date</label>
                                <input type="date" name="end_date" class="form-control" required min="{{ date('Y-m-d') }}">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label font-w600">Special Requests (Optional)</label>
                            <textarea name="special_requests" class="form-control" rows="3"></textarea>
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

    <x-slot name="scripts">
    <script>
        $(document).on('click', '.btn-book', function(e) {
            e.preventDefault();
            e.stopPropagation(); // Prevent detail modal from opening
            
            const id = $(this).attr('data-id');
            const type = $(this).attr('data-type');
            const name = $(this).attr('data-name');
            const rate = $(this).attr('data-rate');
            const label = type === 'App\\Models\\Car' ? 'Book Car' : 'Book Stay';

            $('#modal_bookable_id').val(id);
            $('#modal_bookable_type').val(type);
            $('#modal_item_name').val(name);
            $('#modal_item_rate').val(rate);
            $('#bookingModalLabel').text(label);

            $('#bookingModal').modal('show');
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
                
                // For booking from modal
                $('#detail_id').val($(this).find('.btn-book').data('id'));
                $('#detail_full_type').val('App\\Models\\Car');
                $('.btn-book-from-modal').removeClass('btn-success').addClass('btn-primary').text('Book Now');
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
                
                // For booking from modal
                $('#detail_id').val($(this).find('.btn-book').data('id'));
                $('#detail_full_type').val('App\\Models\\Property');
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
            const label = type === 'App\\Models\\Car' ? 'Book Car' : 'Book Stay';

            $('#detailModal').modal('hide');

            $('#modal_bookable_id').val(id);
            $('#modal_bookable_type').val(type);
            $('#modal_item_name').val(name);
            $('#modal_item_rate').val(rate);
            $('#bookingModalLabel').text(label);

            setTimeout(() => {
                $('#bookingModal').modal('show');
            }, 400); // Wait for detail modal to close
        });
    </script>
    </x-slot>
</x-layouts.customer>
