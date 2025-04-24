<!-- Button to open View Slips Modal -->
<button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#viewSlipModalOR{{ $order->id }}">
    <i class="ri-eye-line"></i>
</button>

<!-- Modal for Viewing Slips -->
<div class="modal fade" id="viewSlipModalOR{{ $order->id }}" data-bs-backdrop="static" tabindex="-1" aria-labelledby="viewSlipLabel{{ $order->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Uploaded Slips</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @php
                    $slips = \App\Models\Slip::where('order_id', $order->invoice_id)->get();
                @endphp

                @if($slips->isNotEmpty())
                @foreach($slips as $slip)
                    <div class="mb-3">
                        <p><strong>Bank Name:</strong> {{ $slip->bank ?? 'N/A' }}</p>
                        @php
                            $filePath = 'storage/' . $slip->slip_path;
                            $extension = pathinfo($filePath, PATHINFO_EXTENSION);
                        @endphp
                
                        @if(in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif']))
                            <a href="{{ asset($filePath) }}" target="_blank">
                                <img src="{{ asset($filePath) }}" alt="Slip Image" class="img-fluid rounded" style="width: 300px; height: 200px;">
                            </a>
                        @elseif(strtolower($extension) === 'pdf')
                            <iframe src="{{ asset($filePath) }}" width="100%" height="400px" style="border: none;"></iframe>
                        @else
                            <p>Unsupported file type.</p>
                        @endif
                    </div>
                @endforeach
            
                @else
                    <p>No slips uploaded for this order.</p>
                @endif
            </div>
        </div>
    </div>
</div>