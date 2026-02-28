<x-layouts.customer>
    <x-slot name="styles">
        <style>
            .car-card {
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

            .car-card::before {
                content: '';
                position: absolute;
                top: 0; left: -100%;
                width: 50%; height: 100%;
                background: linear-gradient(90deg, transparent, rgba(255,255,255,0.6), transparent);
                transition: 0.5s;
                transform: skewX(-25deg);
                z-index: 1;
            }

            .car-card:hover {
                transform: translateY(-10px) !important;
                border-color: rgba(234, 179, 8, 0.3) !important;
                box-shadow: 0 1rem 2rem rgba(0, 0, 0, 0.1) !important;
            }
            
            .car-card:hover::before {
                left: 150%;
            }

            .car-image-container {
                width: 100%;
                height: 200px;
                border-radius: 12px;
                overflow: hidden;
                margin-bottom: 1.5rem;
                position: relative;
            }

            .car-image {
                width: 100%;
                height: 100%;
                object-fit: cover;
                transition: transform 0.5s ease;
            }

            .car-card:hover .car-image {
                transform: scale(1.08);
            }

            .car-tag {
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

            .car-name {
                font-size: 1.25rem;
                font-weight: 700;
                margin-bottom: 0.5rem;
                color: #0f172a;
            }

            .car-specs {
                display: flex;
                justify-content: space-between;
                font-size: 0.85rem;
                margin-bottom: 1.5rem;
                padding-bottom: 1.5rem;
                border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            }

            .car-specs span {
                display: flex;
                align-items: center;
                gap: 0.4rem;
                color: #64748b;
            }

            .car-specs svg {
                width: 16px;
                height: 16px;
                fill: none;
                stroke: currentColor;
                stroke-width: 2;
            }

            .car-footer {
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            .car-price span {
                font-size: 1.15rem;
                font-weight: 800;
                color: #0f172a;
            }

            .car-price small {
                font-weight: 400;
                color: #64748b;
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

        <!-- Available Cars Section -->
        <div class="col-xl-12">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h4 class="mb-0 font-w700">Available Cars</h4>
                <a href="{{ route('customer.cars') }}" class="text-primary font-w600">View All <i class="fas fa-arrow-right ms-1"></i></a>
            </div>
            <div class="row">
                @forelse($cars as $car)
                    <div class="col-xl-4 col-md-6 col-sm-12 mb-4">
                        <div class="car-card">
                            <div class="car-image-container">
                                <div class="car-tag">Available</div>
                                @if($car->image)
                                    <img src="{{ asset($car->image) }}" class="car-image" alt="{{ $car->brand }}">
                                @else
                                    <div class="bg-light d-flex align-items-center justify-content-center h-100">
                                        <i class="fas fa-car fs-64 text-muted opacity-25"></i>
                                    </div>
                                @endif
                            </div>
                            <h3 class="car-name">{{ $car->brand }} {{ $car->model }}</h3>
                            <div class="car-specs">
                                <span>
                                    <svg viewBox="0 0 24 24"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                                    {{ $car->transmission }}
                                </span>
                                <span>
                                    <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                                    {{ $car->capacity }} Seats
                                </span>
                                <span>
                                    <svg viewBox="0 0 24 24"><path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path><polyline points="13 2 13 9 20 9"></polyline></svg>
                                    {{ $car->fuel_type }}
                                </span>
                            </div>
                            <div class="car-footer">
                                <div class="car-price">
                                    <span>₱{{ number_format($car->daily_rate) }}</span><small>/day</small>
                                </div>
                                <a href="#" class="btn btn-primary btn-book shadow-none">Book Now</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <p class="text-muted">No cars available at the moment.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Featured Properties Section -->
        <div class="col-xl-12 mt-4">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h4 class="mb-0 font-w700">Featured Properties</h4>
                <a href="{{ route('customer.properties') }}" class="text-primary font-w600">View All <i class="fas fa-arrow-right ms-1"></i></a>
            </div>
            <div class="row">
                @forelse($properties as $property)
                    <div class="col-xl-4 col-md-6 col-sm-12 mb-4">
                        <div class="car-card">
                            <div class="car-image-container">
                                <div class="car-tag">Featured</div>
                                @if($property->image)
                                    <img src="{{ asset($property->image) }}" class="car-image" alt="{{ $property->title }}">
                                @else
                                    <div class="bg-light d-flex align-items-center justify-content-center h-100">
                                        <i class="fas fa-home fs-64 text-muted opacity-25"></i>
                                    </div>
                                @endif
                            </div>
                            <h3 class="car-name text-truncate">{{ $property->title }}</h3>
                            <div class="car-specs">
                                <span>
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                                    {{ $property->type }}
                                </span>
                                <span>
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 20h20M2 14h20M2 8h20M2 2h20"></path></svg>
                                    {{ $property->bedrooms }} BR
                                </span>
                                <span>
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2v20M5 5l7 7 7-7"></path></svg>
                                    Luxury
                                </span>
                            </div>
                            <div class="car-footer">
                                <div class="car-price">
                                    <span>₱{{ number_format($property->monthly_rate) }}</span><small>/mo</small>
                                </div>
                                <a href="#" class="btn btn-success btn-book shadow-none">Book Stay</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <p class="text-muted">No properties available at the moment.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-layouts.customer>
