@extends('layouts.app')
@section('content')

<div class="container py-5">
  <div class="card shadow-lg rounded-4">
    <div class="card-header bg-success text-white rounded-top-4 d-flex justify-content-between align-items-center">
      <h4 class="mb-0"><i class="bi bi-file-earmark-image"></i> Create PDF from Images</h4>
    </div>
    <div class="card-body">
      <div class="mb-4">
        <label for="pdfName" class="form-label">PDF File Name</label>
        <input type="text" id="pdfName" class="form-control rounded-pill shadow-sm" placeholder="e.g., trip_album">
      </div>

      <div class="mb-4">
        <label for="imageInput" class="form-label">Select Images</label>
        <input type="file" id="imageInput" multiple accept="image/*" class="form-control rounded-pill shadow-sm">
        <small class="form-text text-muted ms-2">You can select multiple images</small>
      </div>

      <div class="text-end">
        <button onclick="generatePDF()" class="btn btn-success px-4 py-2 rounded-pill shadow-sm">
          <i class="bi bi-download me-2"></i>Generate PDF
        </button>
      </div>
    </div>
  </div>

  <div id="preview" class="row mt-4 g-3"></div>
</div>

<!-- jsPDF from CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

<script>
  const { jsPDF } = window.jspdf;
  const preview = document.getElementById('preview');
  const input = document.getElementById('imageInput');

  input.addEventListener('change', function () {
    preview.innerHTML = '';
    Array.from(this.files).forEach(file => {
      const reader = new FileReader();
      reader.onload = function (e) {
        const col = document.createElement('div');
        col.className = 'col-md-3 col-sm-4 col-6';
        col.innerHTML = `
          <div class="card shadow-sm border-0">
            <img src="${e.target.result}" class="card-img-top rounded" style="height: 180px; object-fit: cover;">
          </div>
        `;
        preview.appendChild(col);
      };
      reader.readAsDataURL(file);
    });
  });

  function generatePDF() {
    const files = input.files;
    const pdfName = document.getElementById('pdfName').value.trim();

    if (!files.length) return alert("Please select some images.");
    if (!pdfName) return alert("Please enter a name for the PDF.");

    const pdf = new jsPDF();
    let count = 0;

    Array.from(files).forEach((file, index) => {
      const reader = new FileReader();
      reader.onload = function (e) {
        const img = new Image();
        img.onload = function () {
          const width = pdf.internal.pageSize.getWidth();
          const height = pdf.internal.pageSize.getHeight();
          pdf.addImage(img, 'JPEG', 0, 0, width, height);
          count++;
          if (index < files.length - 1) pdf.addPage();
          if (count === files.length) pdf.save(pdfName + ".pdf");
        };
        img.src = e.target.result;
      };
      reader.readAsDataURL(file);
    });
  }
</script>

@endsection
