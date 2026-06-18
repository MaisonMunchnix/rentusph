<x-layouts.admin>
  <div class="container-fluid">

    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header border-0 pb-0">
            <h4 class="card-title">Customers</h4>
          </div>
          <div class="card-body">
            <!-- Desktop Table View -->
            <div class="table-responsive d-none d-lg-block">
              <table class="table table-responsive-md datatable-enabled">
                <thead>
                  <tr>
                    <th style="width:80px;"><strong>#</strong></th>
                    <th><strong>NAME</strong></th>
                    <th><strong>EMAIL</strong></th>
                    <th><strong>PHONE</strong></th>
                    <th><strong>ADDRESS</strong></th>
                    <th><strong>JOINED DATE</strong></th>
                    <th class="text-center"><strong>ACTION</strong></th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($customers as $customer)
                    <tr>
                      <td><strong>{{ $loop->iteration }}</strong></td>
                      <td>{{ $customer->name }}</td>
                      <td>{{ $customer->email }}</td>
                      <td>{{ $customer->phone ?? 'N/A' }}</td>
                      <td>{{ $customer->address ?? 'N/A' }}</td>
                      <td>{{ $customer->created_at->format('M d, Y') }}</td>
                      <td class="text-center">
                        <div class="d-flex justify-content-center">
                          <button type="button" class="btn btn-primary btn-xs px-3 me-2" data-bs-toggle="modal"
                            data-bs-target="#viewCustomerModal{{ $customer->id }}">
                            View
                          </button>
                          <button type="button" class="btn btn-danger btn-xs px-3" data-bs-toggle="modal"
                            data-bs-target="#deleteModal{{ $customer->id }}">
                            Delete
                          </button>
                        </div>
                      </td>
                    </tr>
                  @empty
                    <tr>
                      <td colspan="7" class="text-center">No customers found.</td>
                    </tr>
                  @endforelse
                </tbody>
              </table>
            </div>

            <!-- Mobile/Tablet Card View -->
            <div class="d-lg-none">
              <!-- Mobile Search Bar -->
              <div class="mb-3">
                <div class="input-group">
                  <span class="input-group-text bg-white"><i class="fas fa-search text-muted"></i></span>
                  <input type="text" id="cust-mobile-search" class="form-control" placeholder="Search customers..." style="border-left:0;">
                </div>
              </div>
              <div class="row" id="cust-card-row">
                @forelse($customers as $customer)
                  <div class="col-md-6 col-12 mb-4" data-cust-name="{{ strtolower($customer->name) }}" data-cust-email="{{ strtolower($customer->email) }}" data-cust-phone="{{ strtolower($customer->phone ?? '') }}" data-cust-address="{{ strtolower($customer->address ?? '') }}">
                    <div class="card border shadow-sm h-100 mb-0">
                      <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                          <div class="me-3 d-flex align-items-center justify-content-center"
                            style="width: 60px; height: 60px;">
                            <i class="fas fa-user text-primary fa-2x"></i>
                          </div>
                          <div>
                            <h5 class="mb-1 text-primary">{{ $customer->name }}</h5>
                            <span class="text-muted d-block fs-14">
                              Joined: {{ $customer->created_at->format('M d, Y') }}
                            </span>
                          </div>
                        </div>

                        <div class="mb-3">
                          <div class="d-flex align-items-start mb-2">
                            <i class="fas fa-envelope text-muted mt-1 me-2" style="width: 20px;"></i>
                            <span class="text-dark">{{ $customer->email }}</span>
                          </div>
                          <div class="d-flex align-items-start mb-2">
                            <i class="fas fa-phone-alt text-muted mt-1 me-2" style="width: 20px;"></i>
                            <span class="text-dark">{{ $customer->phone ?? 'N/A' }}</span>
                          </div>
                          <div class="d-flex align-items-start">
                            <i class="fas fa-map-marker-alt text-muted mt-1 me-2" style="width: 20px;"></i>
                            <span class="text-dark">{{ $customer->address ?? 'N/A' }}</span>
                          </div>
                        </div>

                        <div class="d-flex gap-2 pt-3 border-top">
                          <button type="button" class="btn btn-outline-primary btn-sm flex-grow-1" data-bs-toggle="modal"
                            data-bs-target="#viewCustomerModal{{ $customer->id }}">
                            <i class="fas fa-eye me-1"></i> View
                          </button>
                          <button type="button" class="btn btn-outline-danger btn-sm flex-grow-1" data-bs-toggle="modal"
                            data-bs-target="#deleteModal{{ $customer->id }}">
                            <i class="fas fa-trash me-1"></i> Delete
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>
                @empty
                  <div class="col-12 text-center py-5">
                    <i class="fas fa-users fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">No customers found.</h5>
                  </div>
                @endforelse
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  @foreach($customers as $customer)
    <!-- View Customer Modal -->
    <div class="modal fade" id="viewCustomerModal{{ $customer->id }}" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header border-0 pb-0">
            <h5 class="modal-title fw-bold">Customer Profile</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body pt-3">
            <div class="text-center mb-4">
              <div class="avatar-wrapper mb-3">
                <img
                  src="https://ui-avatars.com/api/?name={{ urlencode($customer->name) }}&background=334155&color=fff&size=128"
                  alt="{{ $customer->name }}" class="rounded-circle shadow-sm"
                  style="width: 100px; height: 100px; object-fit: cover; border: 3px solid #fff;">
              </div>
              <h4 class="mb-1 fw-bold text-dark">{{ $customer->name }}</h4>
              <span class="badge light badge-warning py-1 px-3">Customer</span>
            </div>

            <div class="row g-3">
              <div class="col-12">
                <div class="d-flex align-items-center p-3 bg-light rounded-3">
                  <div class="icon-box me-3 text-primary">
                    <i class="fas fa-envelope fa-lg"></i>
                  </div>
                  <div>
                    <small class="text-muted d-block"
                      style="font-size: 0.7rem; text-transform: uppercase; letter-spacing: 1px;">Email Address</small>
                    <span class="text-dark fw-w600">{{ $customer->email }}</span>
                  </div>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="d-flex align-items-center p-3 bg-light rounded-3 h-100">
                  <div class="icon-box me-3 text-primary">
                    <i class="fas fa-phone-alt fa-lg"></i>
                  </div>
                  <div>
                    <small class="text-muted d-block"
                      style="font-size: 0.7rem; text-transform: uppercase; letter-spacing: 1px;">Phone</small>
                    <span class="text-dark fw-w600">{{ $customer->phone ?? 'Not provided' }}</span>
                  </div>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="d-flex align-items-center p-3 bg-light rounded-3 h-100">
                  <div class="icon-box me-3 text-primary">
                    <i class="fas fa-calendar-check fa-lg"></i>
                  </div>
                  <div>
                    <small class="text-muted d-block"
                      style="font-size: 0.7rem; text-transform: uppercase; letter-spacing: 1px;">Joined Date</small>
                    <span class="text-dark fw-w600">{{ $customer->created_at->format('M d, Y') }}</span>
                  </div>
                </div>
              </div>
              <div class="col-12">
                <div class="d-flex align-items-start p-3 bg-light rounded-3">
                  <div class="icon-box me-3 text-primary mt-1">
                    <i class="fas fa-map-marker-alt fa-lg"></i>
                  </div>
                  <div>
                    <small class="text-muted d-block"
                      style="font-size: 0.7rem; text-transform: uppercase; letter-spacing: 1px;">Home Address</small>
                    <span class="text-dark fw-w600">{{ $customer->address ?? 'No address listed' }}</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer border-0 pt-0">
            <button type="button" class="btn btn-primary light w-100 py-2 fw-bold" data-bs-dismiss="modal">Close
              Profile</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal{{ $customer->id }}">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Confirm Deletion</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body text-center py-4">
            <div class="mb-3 text-danger">
              <i class="fas fa-exclamation-triangle fa-4x"></i>
            </div>
            <p class="mb-0 fs-5 text-danger fw-bold">Warning: Permanent Action</p>
            <p class="mt-2 fs-5">Are you sure you want to delete customer <strong>{{ $customer->name }}</strong>? This
              cannot be undone.</p>
          </div>
          <div class="modal-footer border-0 pt-0 justify-content-center">
            <button type="button" class="btn btn-light btn-sm px-4" data-bs-dismiss="modal">Cancel</button>
            <form action="{{ route('affiliates.destroy', $customer) }}" method="POST">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-danger btn-sm px-4">Yes, Delete Permanently</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  @endforeach

  <x-slot name="scripts">
  <script>
  // Mobile customer card search
  document.addEventListener('DOMContentLoaded', function() {
      var searchInput = document.getElementById('cust-mobile-search');
      if (!searchInput) return;

      searchInput.addEventListener('input', function() {
          var query = this.value.toLowerCase().trim();
          var cards = document.querySelectorAll('#cust-card-row .col-md-6.col-12.mb-4[data-cust-name]');
          var visibleCount = 0;

          cards.forEach(function(card) {
              var name    = (card.dataset.custName    || '').toLowerCase();
              var email   = (card.dataset.custEmail   || '').toLowerCase();
              var phone   = (card.dataset.custPhone   || '').toLowerCase();
              var address = (card.dataset.custAddress || '').toLowerCase();

              var match = !query ||
                  name.indexOf(query)    !== -1 ||
                  email.indexOf(query)   !== -1 ||
                  phone.indexOf(query)   !== -1 ||
                  address.indexOf(query) !== -1;

              if (match) {
                  card.style.display = '';
                  visibleCount++;
              } else {
                  card.style.display = 'none';
              }
          });

          // Show/hide empty state
          var emptyEl = document.getElementById('cust-mobile-empty');
          if (visibleCount === 0) {
              if (!emptyEl) {
                  var row = document.getElementById('cust-card-row');
                  if (row) {
                      var div = document.createElement('div');
                      div.id = 'cust-mobile-empty';
                      div.className = 'col-12 text-center py-4';
                      div.innerHTML = '<i class="fas fa-user-slash fa-2x text-muted mb-2 d-block"></i><p class="text-muted mb-0">No customers match your search.</p>';
                      row.appendChild(div);
                  }
              }
          } else if (emptyEl) {
              emptyEl.remove();
          }
      });
  });
  </script>
  </x-slot>

</x-layouts.admin>