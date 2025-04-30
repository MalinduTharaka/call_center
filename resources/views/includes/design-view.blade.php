<div class="modal fade" id="designPreviewModal-{{ $order->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Design Preview - Order #{{ $order->id }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <a href="{{ asset('storage/'.$order->d_img) }}" 
                   target="_blank" 
                   rel="noopener noreferrer"
                   class="d-inline-block">
                    <img src="{{ asset('storage/'.$order->d_img) }}" 
                         alt="Full Design Preview" 
                         class="img-fluid hover-zoom"
                         style="max-height: 80vh; cursor: pointer">
                </a>
            </div>
            <div class="modal-footer">
                <a href="{{ asset('storage/'.$order->d_img) }}" 
                   class="btn btn-primary" 
                   download="design-{{ $order->id }}.png">
                   <i class="ri-download-line"></i>
                </a>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>