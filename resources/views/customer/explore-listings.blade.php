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
                <div class="listing-card">
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
                            <a href="#" class="btn btn-primary btn-book shadow-none">Book Now</a>
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
                            <a href="#" class="btn btn-success btn-book shadow-none">Book Stay</a>
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
</x-layouts.customer>
