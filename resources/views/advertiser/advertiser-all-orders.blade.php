@extends('layouts.app')
@section('content')
        <style>
            .btn-disabled {
                opacity: 0.5;
                pointer-events: none;
            }

            .bg-light-red {
                background-color: rgb(255, 11, 32) !important;
            }
        </style>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert"
                style="color: #155724; background-color: #d4edda; border-color: #c3e6cb;">
                <strong>Success!</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert"
                style="color: #721c24; background-color: #f8d7da; border-color: #f5c6cb;">
                <strong>Error!</strong> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <script>
            setTimeout(function() {
                let alerts = document.querySelectorAll('.alert');
                alerts.forEach(alert => {
                    let bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                });
            }, 2000); // Auto-dismiss after 4 seconds
        </script>
        <style>
            /* style.css */
            tr[data-add-acc="1"] {
                background-color: #f8d7da;
            }

            tr[data-add-acc="2"] {
                background-color: rgb(146, 217, 247);
            }

            tr[data-add-acc="3"] {
                background-color: rgb(245, 247, 129);
            }
        </style>

        <div class="row mt-3">
            <div class="col-12">
                <div class="col-3 mb-3">
                    <div class="input-group">
                        <input type="text" class="form-control search-input" placeholder="Search orders..."
                            data-target-table="#basictab1 table">
                        <button class="btn btn-primary search-btn">Search</button>
                    </div>
                </div>
                <div class="table-responsive" id="basictab1">
                    <table class="table table-hover table-centered table-bordered border-primary mb-0">
                        <thead class="table-dark table-bordered border-primary">
                            <tr>
                                <th>ID</th>
                                <th>Slip <br /> Upload <br /> Date</th>
                                <th>C/E</th>
                                <th>Invoice</th>
                                <th>CRO</th>
                                <th>Name<br />Company</th>
                                <th>O/N</th>
                                <th>Contact</th>
                                <th>Work<br />Type</th>
                                <th>Page</th>
                                <th>Work<br />Status</th>
                                <th>Payment</th>
                                <th>Cash</th>
                                <th>Advertiser</th>
                                <th>Full Package</th>
                                <th>FB Fee</th>
                                <th>Service</th>
                                <th>Tax</th>
                                <th>Available Fee</th>
                                <th>Advance</th>
                                <th>Details</th>
                                <th>Add<br />Link</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @include('advertiser.all-order-body')
                        </tbody>
                    </table>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->

        <style>
            /* Add these styles */
            .display-mode {
                display: inline;
            }

            .edit-mode {
                display: none;
            }

            .done-btnb {
                display: none;
            }

            tr.editing .display-mode {
                display: none !important;
            }

            tr.editing .edit-mode {
                display: block !important;
            }

            tr.editing .edit-btn {
                display: none !important;
            }

            tr.editing .done-btnb {
                display: inline-block !important;
            }
        </style>
        <style>
            /* Fixed height scrollable tables with sticky headers */
            .table-responsive {
                max-height: 70vh;
                /* 70% of viewport height (adjust as needed) */
                overflow: auto;
                position: relative;
                border: 1px solid #dee2e6;
                /* Optional border */
            }

            /* Sticky headers */
            .table-responsive table thead th {
                position: sticky;
                top: 0;
                background: #343a40;
                /* Match your table-dark background */
                z-index: 10;
            }

            /* Prevent text wrapping to maintain column widths */
            .table-responsive table td,
            .table-responsive table th {
                white-space: nowrap;
                vertical-align: middle;
                /* Better alignment for all cells */
            }

            /* Optional: Better scrollbar styling (works in modern browsers) */
            .table-responsive::-webkit-scrollbar {
                width: 8px;
                height: 8px;
            }

            .table-responsive::-webkit-scrollbar-thumb {
                background: #adb5bd;
                border-radius: 4px;
            }
        </style>

<script>
    (function(){
      const tbody       = document.querySelector('#basictab1 tbody');
      const bodyUrl     = `{{ route('advertisers_all_order.body') }}`;
      const searchInput = document.querySelector('.search-input');
      const searchBtn   = document.querySelector('.search-btn');
      let polling       = setInterval(pollBody, 5000);
    
      // —————————————————————————
      // 1) Poll for brand-new rows
      function pollBody(){
        if (tbody.querySelector('tr.editing')) return;
        fetch(bodyUrl)
          .then(r => r.text())
          .then(html => {
            tbody.innerHTML = html;
            applySearch();
          })
          .catch(console.error);
      }
    
      // —————————————————————————
      // 2) Search filter
      function applySearch(){
        const q = searchInput.value.trim().toLowerCase();
        tbody.querySelectorAll('tr').forEach(r => {
          r.style.display = r.textContent.toLowerCase().includes(q) ? '' : 'none';
        });
      }
      searchBtn.addEventListener('click', applySearch);
      searchInput.addEventListener('keyup', e => { if (e.key==='Enter') applySearch(); });
    
      // —————————————————————————
      // 3) Delegate Edit / Done / click-outside
      tbody.addEventListener('click', e => {
        const btn = e.target;
        const row = btn.closest('tr');
        if (!row) return;
    
        // — Edit
        if (btn.matches('.edit-btn')) {
          exitAllEdits();
          row.classList.add('editing');
          return;
        }
    
        // — Done (send JSON)
        if (btn.matches('.done-btnb')) {
          const select = row.querySelector('select[name="advertiser_id"]');
          const advId  = select.value;
          if (!advId) {
            return alert('Please select an Advertiser.');
          }
    
          exitAllEdits();
          clearInterval(polling);
    
          fetch(row.querySelector('form').action, {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
              'Accept': 'application/json'
            },
            body: JSON.stringify({
              advertiser_id: advId,
              _method:        'PUT'
            })
          })
          .then(async res => {
            if (res.status === 422) {
              const err = await res.json();
              alert(Object.values(err.errors).flat().join(', '));
              throw 'validation';
            }
            return res.json();
          })
          .then(json => {
            // inline update of this row
            row.querySelector('.advertiser-name').textContent = json.order.advertiser.name;
            const badge = row.querySelector('.work-status-badge');
            badge.textContent = json.order.work_status;
            badge.className = 'badge fs-5 work-status-badge bg-info';
          })
          .catch(console.error)
          .finally(() => {
            // reload full body so you can re-edit
            pollBody();
            setTimeout(() => polling = setInterval(pollBody, 5000), 1000);
          });
          return;
        }
    
        // — click-outside to cancel edit
        const editing = tbody.querySelector('tr.editing');
        if (editing && !editing.contains(e.target)) {
          editing.classList.remove('editing');
        }
      });
    
      function exitAllEdits(){
        tbody.querySelectorAll('tr.editing')
             .forEach(r => r.classList.remove('editing'));
      }
    
      // initial load & filter
      pollBody();
      if (searchInput.value) applySearch();
    })();
    </script>
    
    
        
@endsection
