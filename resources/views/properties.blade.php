<x-layouts.public title="RentUs | Premier Stays">
  <x-slot name="styles">
    <style>
      .hero-mini {
        background: #0a0a0a;
        padding: 4rem 5%;
        text-align: center;
        color: #fff;
        margin-bottom: 4rem;
      }
      .fleet {
        padding: 0 5% 8rem;
      }
      .fleet-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 380px));
        gap: 2.5rem;
        justify-content: flex-start;
      }
      .car-card {
        background: var(--glass-bg);
        border: 1px solid var(--glass-border);
        border-radius: 20px;
        padding: 1.5rem;
        backdrop-filter: var(--glass-blur);
        transition: all 0.4s ease;
        position: relative;
        overflow: hidden;
        width: 100%;
        max-width: 380px;
        display: flex;
        flex-direction: column;
      }
      .car-card:hover {
        transform: translateY(-10px);
        background: rgba(255, 255, 255, 0.9);
      }
      .car-image-container {
        width: 100%;
        height: 220px;
        border-radius: 12px;
        overflow: hidden;
        margin-bottom: 1.5rem;
        background: #eee;
      }
      .car-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
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
        color: var(--accent);
        z-index: 2;
      }
      .car-name {
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
      }
      .car-specs {
        display: flex;
        justify-content: space-between;
        font-size: 0.9rem;
        margin-bottom: 1.5rem;
        padding-bottom: 1.5rem;
        border-bottom: 1px solid var(--glass-border);
        margin-top: auto;
      }
      .car-specs span {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: #475569;
      }
      .car-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
      }
      .car-price span {
        font-size: 1.25rem;
        font-weight: 800;
      }
      .pagination {
        justify-content: center;
        margin-top: 4rem;
      }
    </style>
  </x-slot>

  <section class="hero-mini">
    <h1 style="font-family: 'Arvo', serif; font-weight: 700; color: #fff;">Premier Stays</h1>
    <p style="color: rgba(255,255,255,0.7);">Discover handpicked luxury properties across the Philippines</p>
  </section>

  <section class="fleet">
    <div class="fleet-grid" style="justify-content: center;">
      @forelse($properties as $property)
        <div class="car-card">
          <div class="car-image-container">
            <div class="car-tag">{{ $property->type }}</div>
            @if($property->image)
              <img src="{{ asset($property->image) }}" alt="{{ $property->title }}" class="car-image">
            @else
              <div class="bg-light d-flex align-items-center justify-content-center h-100">
                <img src="{{ asset('images/rentus.png') }}" style="opacity: 0.2; width: 100px;">
              </div>
            @endif
          </div>
          <h3 class="car-name">{{ $property->title }}</h3>
          <div class="car-specs">
            <span>{{ $property->type }}</span>
            <span>{{ $property->bedrooms }} BR</span>
            <span>{{ $property->floor_area }} sqm</span>
          </div>
          <div class="car-footer">
            <div class="car-price">
              <span>₱{{ number_format($property->monthly_rate, 2) }}</span><small>/night</small>
            </div>
            <div class="d-flex gap-2">
              <a href="{{ route('public.properties.show', $property) }}" class="btn-outline-dark" style="padding: 0.5rem 1rem;">View Details</a>
              <a href="{{ route('login') }}" class="btn-outline-dark"
                style="background: var(--accent); border-color: var(--accent); color: #000 !important; padding: 0.5rem 1rem;">Book Stay</a>
            </div>
          </div>
        </div>
      @empty
        <div class="col-12 text-center py-5">
          <p class="text-muted">No properties available at the moment.</p>
        </div>
      @endforelse
    </div>

    <div class="pagination">
      {{ $properties->links() }}
    </div>
  </section>

</x-layouts.public>