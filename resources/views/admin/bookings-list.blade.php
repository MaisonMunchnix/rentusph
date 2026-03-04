<x-layouts.admin>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header border-0 pb-0 flex-wrap">
                    <h4 class="card-title">Booking List</h4>
                    <div class="d-flex align-items-center mt-3 mt-sm-0">
                        <a href="{{ route('bookings.index') }}" class="btn btn-primary btn-sm me-2">
                            <i class="fas fa-calendar me-2"></i>Calendar View
                        </a>
                        <form action="{{ route('bookings.index') }}" method="GET" class="d-flex align-items-center">
                            <input type="hidden" name="view" value="list">
                            <select name="status" class="form-control default-select form-control-sm me-2" onchange="this.form.submit()">
                                <option value="">All Status</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                            <select name="car_id" class="form-control default-select form-control-sm me-2" onchange="this.form.submit()">
                                <option value="">All Cars</option>
                                @foreach($cars as $car)
                                    <option value="{{ $car->id }}" {{ request('car_id') == $car->id ? 'selected' : '' }}>
                                        {{ $car->brand }} {{ $car->model }} ({{ $car->plate_number }})
                                    </option>
                                @endforeach
                            </select>
                        </form>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-responsive-md">
                            <thead>
                                <tr>
                                    <th><strong>BOOKING ID</strong></th>
                                    <th><strong>CUSTOMER</strong></th>
                                    <th><strong>ITEM</strong></th>
                                    <th><strong>DATES</strong></th>
                                    <th><strong>TOTAL</strong></th>
                                    <th><strong>STATUS</strong></th>
                                    <th class="text-end"><strong>ACTION</strong></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($bookings as $booking)
                                <tr>
                                    <td><strong>#{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}</strong></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <span class="w-space-no">{{ $booking->customer_name }}</span>
                                        </div>
                                        <small class="text-muted">{{ $booking->customer_email }}</small>
                                    </td>
                                    <td>
                                        @if($booking->bookable_type === 'App\Models\Car')
                                            <span class="badge badge-xs light badge-primary">Car</span>
                                            {{ $booking->bookable->brand ?? 'N/A' }} {{ $booking->bookable->model ?? '' }}
                                        @else
                                            <span class="badge badge-xs light badge-info">Property</span>
                                            {{ $booking->bookable->title ?? 'N/A' }}
                                        @endif
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($booking->start_date)->format('M d') }} - {{ $booking->end_date ? \Carbon\Carbon::parse($booking->end_date)->format('M d, Y') : 'N/A' }}</td>
                                    <td>₱{{ number_format($booking->total_price, 2) }}</td>
                                    <td>
                                        @php
                                            $statusClasses = [
                                                'pending' => 'badge-warning',
                                                'confirmed' => 'badge-success',
                                                'completed' => 'badge-primary',
                                                'cancelled' => 'badge-danger'
                                            ];
                                        @endphp
                                        <span class="badge light {{ $statusClasses[$booking->status] ?? 'badge-secondary' }}">
                                            {{ ucfirst($booking->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-end">
                                            <div class="dropdown">
                                                <button type="button" class="btn btn-primary light btn-xs sharp" data-bs-toggle="dropdown">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <form action="{{ route('bookings.status', $booking->id) }}" method="POST">
                                                        @csrf @method('PATCH')
                                                        <button type="submit" name="status" value="confirmed" class="dropdown-item">Confirm</button>
                                                        <button type="submit" name="status" value="completed" class="dropdown-item">Complete</button>
                                                        <button type="submit" name="status" value="cancelled" class="dropdown-item">Cancel</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center">No bookings found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">
                        {{ $bookings->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.admin>
