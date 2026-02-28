<x-layouts.customer>
    <x-slot name="styles">
        <style>
            .property-card {
                background: #ffffff !important;
                border: 1px solid rgba(0, 0, 0, 0.08) !important;
                border-radius: 20px !important;
                padding: 1.5rem !important;
                transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275) !important;
                cursor: pointer;
                position: relative;
                overflow: hidden;
                height: 100%;
            }

            .property-card:hover {
                transform: translateY(-10px) !important;
                border-color: rgba(234, 179, 8, 0.3) !important;
                box-shadow: 0 1rem 2rem rgba(0, 0, 0, 0.1) !important;
            }

            .property-image-container {
                width: 100%;
                height: 220px;
                border-radius: 12px;
                overflow: hidden;
                margin-bottom: 1.5rem;
                position: relative;
            }

            .property-image {
                width: 100%;
                height: 100%;
                object-fit: cover;
                transition: transform 0.5s ease;
            }

            .property-card:hover .property-image {
                transform: scale(1.08);
            }

            .property-tag {
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

            .property-title {
                font-size: 1.25rem;
                font-weight: 700;
                margin-bottom: 0.5rem;
                color: #0f172a;
            }

            .property-location {
                font-size: 0.85rem;
                color: #64748b;
                margin-bottom: 1rem;
                display: flex;
                align-items: center;
                gap: 0.4rem;
            }

            .property-specs {
                display: flex;
                justify-content: space-between;
                font-size: 0.85rem;
                margin-bottom: 1.5rem;
                padding-bottom: 1.5rem;
                border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            }

            .property-specs span {
                display: flex;
                align-items: center;
                gap: 0.4rem;
                color: #64748b;
            }

            .property-footer {
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            .property-price span {
                font-size: 1.15rem;
                font-weight: 800;
                color: #0f172a;
            }

            .btn-book {
                padding: 0.5rem 1.25rem !important;
                border-radius: 50px !important;
                font-weight: 600 !important;
                font-size: 0.85rem !important;
                background: #eab308 !important;
                border-color: #eab308 !important;
            }
            
            .search-bar {
                background: #fff;
                border-radius: 15px;
                padding: 20px;
                margin-bottom: 30px;
                box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            }
        </style>
    </x-slot>

    <div class="row">
        <div class="col-12">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <div>
                    <h2 class="font-w700 mb-0">Browse Properties</h2>
                    <p class="text-muted mb-0">Explore premium stays for your next trip</p>
                </div>
            </div>
        </div>

        <div class="col-12 mb-4">
            <div class="search-bar">
                <form action="{{ route('customer.properties') }}" method="GET" class="row align-items-end">
                    <div class="col-md-4 mb-3 mb-md-0">
                        <label class="form-label font-w600">Search</label>
                        <input type="text" name="search" class="form-control" placeholder="City, region, or title..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-3 mb-3 mb-md-0">
                        <label class="form-label font-w600">Type</label>
                        <select name="type" class="form-control">
                            <option value="">All Types</option>
                            <option value="Apartment" {{ request('type') == 'Apartment' ? 'selected' : '' }}>Apartment</option>
                            <option value="House" {{ request('type') == 'House' ? 'selected' : '' }}>House</option>
                            <option value="Condo" {{ request('type') == 'Condo' ? 'selected' : '' }}>Condo</option>
                        </select>
                    </div>
                    <div class="col-md-3 mb-3 mb-md-0">
                        <label class="form-label font-w600">Price Range</label>
                        <select name="price" class="form-control">
                            <option value="">Any Price</option>
                            <option value="10000" {{ request('price') == '10000' ? 'selected' : '' }}>Under ₱10,000</option>
                            <option value="30000" {{ request('price') == '30000' ? 'selected' : '' }}>₱10,000 - ₱30,000</option>
                            <option value="50000" {{ request('price') == '50000' ? 'selected' : '' }}>Above ₱30,000</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">Filter</button>
                    </div>
                </form>
            </div>
        </div>

        @forelse($properties as $property)
            <div class="col-xl-4 col-md-6 col-sm-12 mb-4">
                <div class="property-card">
                    <div class="property-image-container">
                        <div class="property-tag">Featured</div>
                        @if($property->image)
                            <img src="{{ asset($property->image) }}" class="property-image" alt="{{ $property->title }}">
                        @else
                            <div class="bg-light d-flex align-items-center justify-content-center h-100">
                                <i class="fas fa-home fs-64 text-muted opacity-25"></i>
                            </div>
                        @endif
                    </div>
                    <h3 class="property-title text-truncate">{{ $property->title }}</h3>
                    <div class="property-location">
                        <i class="fas fa-map-marker-alt text-primary"></i>
                        {{ $property->city }}, {{ $property->region }}
                    </div>
                    <div class="property-specs">
                        <span>
                            <i class="fas fa-building me-1"></i>
                            {{ $property->type }}
                        </span>
                        <span>
                            <i class="fas fa-bed me-1"></i>
                            {{ $property->bedrooms }} BR
                        </span>
                        <span>
                            <i class="fas fa-bath me-1"></i>
                            {{ $property->bathrooms }} BA
                        </span>
                    </div>
                    <div class="property-footer">
                        <div class="property-price">
                            <span>₱{{ number_format($property->monthly_rate) }}</span><small>/mo</small>
                        </div>
                        <a href="#" class="btn btn-success btn-book shadow-none">Book Stay</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <div class="mb-3">
                    <i class="fas fa-city fa-4x text-muted opacity-25"></i>
                </div>
                <h4 class="text-muted">No properties match your criteria.</h4>
            </div>
        @endforelse

        <div class="col-12 mt-4">
            {{ $properties->links() }}
        </div>
    </div>
</x-layouts.customer>
