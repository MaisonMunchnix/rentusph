<x-layouts.public>
  <x-slot name="title">{{ $property->title }}</x-slot>
  <div class="container-fluid py-5" style="max-width: 1200px;">
    <!-- Header / Nav -->
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h2 class="font-w700 text-black mb-0">{{ $property->title }}</h2>
      <a href="{{ route('public.properties') }}" class="btn-outline-dark btn-sm"><i
          class="fas fa-arrow-left me-2"></i>Back to Properties</a>
    </div>

    <div class="row">
      <!-- Left Column: Gallery & Details -->
      <div class="col-lg-8">
        <!-- Hero Image -->
        <div class="card border-0 shadow-sm mb-4 overflow-hidden" style="border-radius: 20px;">
          <img src="{{ asset($property->image ?? 'images/rentus.png') }}" class="w-100"
            style="height: 400px; object-fit: cover;" alt="{{ $property->title }}">
        </div>

        <!-- Lightbox Gallery -->
        @if($property->galleryImages->count() > 0)
          <div class="card border-0 shadow-sm mb-4" style="border-radius: 20px;">
            <div class="card-header border-0 pb-0">
              <h4 class="card-title font-w700">Photo Gallery</h4>
            </div>
            <div class="card-body">
              <div class="d-flex flex-wrap gap-2">
                @foreach($property->galleryImages as $index => $img)
                  <a href="javascript:void(0);" onclick="openGallery({{ $index }})" class="gallery-item">
                    <img src="{{ asset($img->path) }}" class="rounded shadow-sm"
                      style="width: 120px; height: 90px; object-fit: cover; border: 2px solid transparent; transition: all 0.3s ease;"
                      onmouseover="this.style.borderColor='var(--accent)';"
                      onmouseout="this.style.borderColor='transparent';">
                  </a>
                @endforeach
              </div>
            </div>
          </div>
        @endif

        <!-- Description -->
        <div class="card border-0 shadow-sm mb-4" style="border-radius: 20px;">
          <div class="card-header border-0 pb-0">
            <h4 class="card-title font-w700">Description</h4>
          </div>
          <div class="card-body">
            <p class="mb-0 text-muted" style="line-height: 1.8; font-size: 1.05rem;">
              {{ $property->description ?: 'No additional description provided.' }}
            </p>
          </div>
        </div>

      </div>

      <!-- Right Column: Specs & Pricing -->
      <div class="col-lg-4">
        <div class="sticky-top" style="top: 100px; z-index: 10;">
          <!-- Pricing Card -->
          <div class="card pricing-card border-0 shadow-sm mb-4 text-center" style="border-radius: 20px;">
            <div class="card-body py-4">
              <h5 class="text-muted mb-1 text-uppercase fw-bold" style="font-size: 0.85rem; letter-spacing: 1px;">
                {{ ucfirst($property->rate_type) }} Rate</h5>
              <h2 class="font-w800 mb-4" style="font-size: 2.5rem; color: #0f172a;">
                ₱{{ number_format($property->monthly_rate, 2) }}</h2>

              <div class="bg-light rounded py-3 mb-4 mx-2 border border-light">
                <span class="text-muted d-block mb-1" style="font-size: 0.85rem;">Security Deposit</span>
                <span class="text-black font-w700 fs-5">₱{{ number_format($property->security_deposit, 2) }}</span>
              </div>

              <a href="{{ route('register.customer', ['property_id' => $property->id]) }}"
                class="btn btn-warning btn-lg w-100 shadow-sm font-w700" style="border-radius: 50px;">Book This Stay</a>
              <small class="d-block text-muted mt-3">You will be asked to log in or register.</small>
            </div>
          </div>

          <!-- Specifications -->
          <div class="card border-0 shadow-sm" style="border-radius: 20px; background: #ffffff;">
            <div class="card-header border-0 pb-0 bg-transparent">
              <h4 class="card-title font-w700">Property Details</h4>
            </div>
            <div class="card-body">
              <div class="row g-4">
                <div class="col-6">
                  <div class="d-flex align-items-center">
                    <div class="d-flex align-items-center justify-content-center me-3"
                      style="width: 45px; height: 45px;">
                      <i class="fas fa-home fs-5" style="color: var(--accent);"></i>
                    </div>
                    <div>
                      <small class="text-muted d-block lh-1 mb-1">Type</small>
                      <span class="font-w600 text-black lh-1">{{ $property->type }}</span>
                    </div>
                  </div>
                </div>
                <div class="col-6">
                  <div class="d-flex align-items-center">
                    <div class="d-flex align-items-center justify-content-center me-3"
                      style="width: 45px; height: 45px;">
                      <i class="fas fa-bed fs-5" style="color: var(--accent);"></i>
                    </div>
                    <div>
                      <small class="text-muted d-block lh-1 mb-1">Bedrooms</small>
                      <span class="font-w600 text-black lh-1">{{ $property->bedrooms ?: 'N/A' }}</span>
                    </div>
                  </div>
                </div>
                <div class="col-6">
                  <div class="d-flex align-items-center">
                    <div class="d-flex align-items-center justify-content-center me-3"
                      style="width: 45px; height: 45px;">
                      <i class="fas fa-bath fs-5" style="color: var(--accent);"></i>
                    </div>
                    <div>
                      <small class="text-muted d-block lh-1 mb-1">Bathrooms</small>
                      <span class="font-w600 text-black lh-1">{{ $property->bathrooms ?: 'N/A' }}</span>
                    </div>
                  </div>
                </div>
                <div class="col-6">
                  <div class="d-flex align-items-center">
                    <div class="d-flex align-items-center justify-content-center me-3"
                      style="width: 45px; height: 45px;">
                      <i class="fas fa-ruler-combined fs-5" style="color: var(--accent);"></i>
                    </div>
                    <div>
                      <small class="text-muted d-block lh-1 mb-1">Floor Area</small>
                      <span class="font-w600 text-black lh-1"
                        style="font-size: 0.9rem;">{{ $property->floor_area ? $property->floor_area . ' sqm' : 'N/A' }}</span>
                    </div>
                  </div>
                </div>
                <div class="col-12">
                  <div class="d-flex align-items-center">
                    <div class="d-flex align-items-center justify-content-center me-3"
                      style="width: 45px; height: 45px;">
                      <i class="fas fa-map-marker-alt fs-5" style="color: var(--accent);"></i>
                    </div>
                    <div>
                      <small class="text-muted d-block lh-1 mb-1">Location</small>
                      <span class="font-w600 text-black lh-1">{{ $property->city }}, {{ $property->region }}</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  @if($property->galleryImages->count() > 0)
    <!-- Gallery Modal -->
    <div class="modal fade" id="galleryModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content bg-transparent border-0">
          <div class="modal-header border-0 pb-0 justify-content-end">
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"
              style="filter: invert(1) grayscale(100%) brightness(200%);"></button>
          </div>
          <div class="modal-body p-0">
            <div id="galleryCarousel" class="carousel slide" data-bs-ride="false">
              <div class="carousel-inner text-center">
                @foreach($property->galleryImages as $index => $img)
                  <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                    <img src="{{ asset($img->path) }}" class="img-fluid rounded"
                      style="max-height: 85vh; object-fit: contain; box-shadow: 0 10px 30px rgba(0,0,0,0.5);"
                      alt="Gallery Image">
                  </div>
                @endforeach
              </div>
              @if($property->galleryImages->count() > 1)
                <button class="carousel-control-prev" type="button" data-bs-target="#galleryCarousel" data-bs-slide="prev"
                  style="width: 5%;">
                  <span class="carousel-control-prev-icon" aria-hidden="true" style="width: 3rem; height: 3rem;"></span>
                  <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#galleryCarousel" data-bs-slide="next"
                  style="width: 5%;">
                  <span class="carousel-control-next-icon" aria-hidden="true" style="width: 3rem; height: 3rem;"></span>
                  <span class="visually-hidden">Next</span>
                </button>
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>

    <x-slot name="scripts">
      <script>
        function openGallery(index) {
          var myModal = new bootstrap.Modal(document.getElementById('galleryModal'));
          myModal.show();
          var myCarousel = document.getElementById('galleryCarousel');
          var carousel = bootstrap.Carousel.getInstance(myCarousel);
          if (!carousel) {
            carousel = new bootstrap.Carousel(myCarousel, {
              interval: false
            });
          }
          carousel.to(index);
        }
      </script>
    </x-slot>
  @endif
</x-layouts.public>