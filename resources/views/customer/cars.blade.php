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

            .car-card:hover {
                transform: translateY(-10px) !important;
                border-color: rgba(234, 179, 8, 0.3) !important;
                box-shadow: 0 1rem 2rem rgba(0, 0, 0, 0.1) !important;
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

            .btn-book {
                padding: 0.5rem 1.25rem !important;
                border-radius: 50px !important;
                font-weight: 600 !important;
                font-size: 0.85rem !important;
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
                    <h2 class="font-w700 mb-0">Explore Available Cars</h2>
                    <p class="text-muted mb-0">Find the perfect ride for your next journey</p>
                </div>
            </div>
        </div>

        <div class="col-12 mb-4">
            <div class="search-bar">
                <form action="{{ route('customer.cars') }}" method="GET" class="row align-items-end">
                    <div class="col-md-4 mb-3 mb-md-0">
                        <label class="form-label font-w600">Search</label>
                        <input type="text" name="search" class="form-control" placeholder="Brand or model..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-3 mb-3 mb-md-0">
                        <label class="form-label font-w600">Transmission</label>
                        <select name="transmission" class="form-control">
                            <option value="">All Types</option>
                            <option value="Automatic" {{ request('transmission') == 'Automatic' ? 'selected' : '' }}>Automatic</option>
                            <option value="Manual" {{ request('transmission') == 'Manual' ? 'selected' : '' }}>Manual</option>
                        </select>
                    </div>
                    <div class="col-md-3 mb-3 mb-md-0">
                        <label class="form-label font-w600">Price Range</label>
                        <select name="price" class="form-control">
                            <option value="">Any Price</option>
                            <option value="1000" {{ request('price') == '1000' ? 'selected' : '' }}>Under ₱1,000</option>
                            <option value="3000" {{ request('price') == '3000' ? 'selected' : '' }}>₱1,000 - ₱3,000</option>
                            <option value="5000" {{ request('price') == '5000' ? 'selected' : '' }}>Above ₱3,000</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">Filter</button>
                    </div>
                </form>
            </div>
        </div>

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
                            <i class="fas fa-cog me-1"></i>
                            {{ $car->transmission }}
                        </span>
                        <span>
                            <i class="fas fa-users me-1"></i>
                            {{ $car->capacity }} Seats
                        </span>
                        <span>
                            <i class="fas fa-gas-pump me-1"></i>
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
                <div class="mb-3">
                    <i class="fas fa-car-side fa-4x text-muted opacity-25"></i>
                </div>
                <h4 class="text-muted">No cars match your criteria.</h4>
            </div>
        @endforelse

        <div class="col-12 mt-4">
            {{ $cars->links() }}
        </div>
    </div>
</x-layouts.customer>
