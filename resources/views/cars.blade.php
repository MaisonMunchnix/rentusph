<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>RentUs | All Cars</title>
  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&family=Arvo:wght@400;700&family=Bebas+Neue&display=swap"
    rel="stylesheet">
  <!-- FAVICONS ICON -->
  <link rel="shortcut icon" type="image/svg+xml" href="{{ asset('images/rentus.svg') }}">
  <!-- Style css -->
  <link href="{{ asset('css/style.css') }}" rel="stylesheet">
  <style>
    :root {
      --accent: #eab308;
      --glass-bg: rgba(255, 255, 255, 0.6);
      --glass-border: rgba(0, 0, 0, 0.08);
      --glass-blur: blur(12px);
    }

    body {
      font-family: 'Outfit', sans-serif !important;
      background-color: #fdfdfd;
      color: #0f172a;
    }

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

    .btn-outline {
      border: 1.5px solid #0f172a !important;
      color: #0f172a !important;
      border-radius: 50px;
      padding: 0.5rem 1.5rem;
      font-weight: 600;
      transition: all 0.3s ease;
      text-decoration: none;
      white-space: nowrap;
      display: inline-flex;
      align-items: center;
      justify-content: center;
    }

    .btn-outline:hover {
      background: var(--accent);
      border-color: var(--accent);
      color: #000;
    }

    .nav-header {
      background: #0a0a0a;
      padding: 1.5rem 5%;
      display: flex;
      justify-content: space-between;
      align-items: center;
      gap: 2rem;
      flex-wrap: nowrap;
    }

    .pagination {
      justify-content: center;
      margin-top: 4rem;
    }
  </style>
</head>

<body>
  <header class="nav-header">
    <a href="{{ url('/') }}">
      <img src="{{ asset('images/rentus.png') }}" alt="RentUs Logo" style="height: 40px;">
    </a>
    <a href="{{ url('/') }}" class="btn-outline"
      style="border-color: rgba(255,255,255,0.3) !important; color: #fff !important;">Back Home</a>
  </header>

  <section class="hero-mini">
    <h1 style="font-family: 'Arvo', serif; font-weight: 700;color:white;">Our Premium Fleet</h1>
    <p style="color: rgba(255,255,255,0.7);">Choose the perfect vehicle for your next journey</p>
  </section>

  <section class="fleet">
    <div class="fleet-grid" style="justify-content: center;">
      @forelse($cars as $car)
        <div class="car-card">
          <div class="car-image-container">
            <div class="car-tag">{{ $car->brand }}</div>
            @if($car->image)
              <img src="{{ asset($car->image) }}" alt="{{ $car->brand }} {{ $car->model }}" class="car-image">
            @else
              <div class="bg-light d-flex align-items-center justify-content-center h-100">
                <img src="{{ asset('images/rentus.png') }}" style="opacity: 0.2; width: 100px;">
              </div>
            @endif
          </div>
          <h3 class="car-name">{{ $car->brand }} {{ $car->model }}</h3>
          <div class="car-specs">
            <span>{{ $car->transmission }}</span>
            <span>{{ $car->capacity }} Seats</span>
            <span>{{ $car->type }}</span>
          </div>
          <div class="car-footer">
            <div class="car-price">
              <span>₱{{ number_format($car->daily_rate, 2) }}</span><small>/day</small>
            </div>
            <a href="{{ route('login') }}" class="btn-outline">Book Now</a>
          </div>
        </div>
      @empty
        <div class="col-12 text-center py-5">
          <p class="text-muted">No cars available at the moment.</p>
        </div>
      @endforelse
    </div>

    <div class="pagination">
      {{ $cars->links() }}
    </div>
  </section>

  <footer style="background: #0a0a0a; color: rgba(255,255,255,0.5); text-align: center; padding: 4rem 5%;">
    <p>&copy; {{ date('Y') }} RentUS. All rights reserved.</p>
  </footer>
</body>

</html>