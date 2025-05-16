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
            .cancel-btn {
            display: none;
          }

          tr.editing .cancel-btn {
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
      const tbody   = document.querySelector('#basictab1 tbody');
      const bodyUrl = `{{ route('advertisers_all_order.body') }}`;
      const searchInput = document.querySelector('.search-input');
      const searchBtn   = document.querySelector('.search-btn');
      let polling = setInterval(pollBody, 30000);
    
      // Poll for updated rows
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
    
      // Search filter
      function applySearch(){
        const q = searchInput.value.trim().toLowerCase();
        tbody.querySelectorAll('tr').forEach(r => {
          r.style.display = r.textContent.toLowerCase().includes(q) ? '' : 'none';
        });
      }
      searchBtn.addEventListener('click', applySearch);
      searchInput.addEventListener('keyup', e => { if (e.key==='Enter') applySearch(); });
    
      // Delegate Edit / Done / click-outside
      tbody.addEventListener('click', async e => {
        const btn = e.target;
        const row = btn.closest('tr');
        if (!row) return;
    
        // Enter edit mode
        if (btn.matches('.edit-btn')) {
          tbody.querySelectorAll('tr.editing').forEach(r=>r.classList.remove('editing'));
          row.classList.add('editing');
          return;
        }
    
        // Done: send only advertiser_id plus any optional fields
        if (btn.matches('.done-btnb')) {
          const advId = row.querySelector('select[name="advertiser_id"]').value;
          if (!advId) {
            return alert('Please select an Advertiser.');
          }
    
          // gather optional fields if visible
          const payload = { advertiser_id: advId, _method: 'PUT' };
          ['work_status','page','details','add_acc_id'].forEach(name => {
            const el = row.querySelector(`[name="${name}"]`);
            if (el && el.value) payload[name] = el.value;
          });
    
          row.classList.remove('editing');
          clearInterval(polling);
    
          try {
            const res = await fetch(row.querySelector('form').action, {
              method: 'POST',
              headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept':       'application/json',
              },
              body: JSON.stringify(payload)
            });
    
            if (res.status === 422) {
              const err = await res.json();
              return alert(Object.values(err.errors).flat().join('\n'));
            }
    
            const json = await res.json();
            if (json.success) {
              const o = json.order;
              // inline update
              row.querySelector('.advertiser-name').textContent = o.advertiser.name;
              // if work_status was returned, update badge
              if (payload.work_status) {
                const badge = row.querySelector('.work-status-badge');
                badge.textContent = o.work_status;
                badge.className = 'badge fs-5 work-status-badge ' + 
                  (o.work_status==='done' ? 'bg-primary' :
                   o.work_status==='pending' ? 'bg-danger' :
                   o.work_status==='send to customer' ? 'bg-warning' :
                   o.work_status==='send to designer' ? 'bg-dark' : 'bg-info');
              }
              // if page was returned
              if (payload.page) {
                row.querySelector('td:nth-child(10) .display-mode').textContent = o.page;
              }
              // if details returned
              if (payload.details !== undefined) {
                row.querySelector('td:nth-last-child(4) .display-mode').textContent = o.details || '';
              }
              // if add_acc_id returned
              if (payload.add_acc_id !== undefined) {
                const accCell = row.querySelector('td:nth-last-child(3)');
                accCell.innerHTML = o.add_acc_id
                  ? `<a href="${o.add_acc_id}" target="_blank" class="btn btn-info display-mode">
                       <i class="ri-arrow-up-circle-line"></i>
                     </a>`
                  : `<span class="display-mode">Not Added</span>`;
              }
            }
          } catch(err) {
            console.error('Update error', err);
          } finally {
            // re-poll so you can edit again
            pollBody();
            setTimeout(() => polling = setInterval(pollBody, 30000), 1000);
          }
        }
    
        // click outside to cancel
        // …

        // Cancel: exit edit mode without saving
        if (btn.matches('.cancel-btn')) {
          row.classList.remove('editing');
          return;
        }

        // …

      });
    
      // start
      pollBody();
      if (searchInput.value) applySearch();
    })();
    </script>
    
    
    
        
@endsection
