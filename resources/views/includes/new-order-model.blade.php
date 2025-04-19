<div class="modal fade" id="combinemodel" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">New Order Combine</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="/new_invoice" method="post">
                    @csrf
                    <div class="mt-2">
                        <div class="form-check form-check-inline">
                            <input type="checkbox" id="checkbox-boosting" name="order_type1" class="form-check-input">
                            <label class="form-check-label" for="checkbox-boosting">Boosting</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="checkbox" id="checkbox-design" name="order_type2" class="form-check-input">
                            <label class="form-check-label" for="checkbox-design">Design</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="checkbox" id="checkbox-video" name="order_type3" class="form-check-input">
                            <label class="form-check-label" for="checkbox-video">Video</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row g-2">
                                        <div class="mb-3 col-md-6 all">
                                            <label for="inputEmail4" class="form-label">Name / Company</label>
                                            <input type="text" class="form-control" name="name" id="name"
                                                placeholder="Name / Company">
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label for="Contact" class="form-label">Contact</label>
                                            <input type="text" class="form-control" name="contact" id="contact"
                                                placeholder="Contact" required>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <button type="button" class="btn btn-outline-primary w-100 section-btn"
                                                data-target="boosting-section">Boosting</button>
                                        </div>
                                        <div class="col-md-4">
                                            <button type="button" class="btn btn-outline-primary w-100 section-btn"
                                                data-target="designs-section">Designs</button>
                                        </div>
                                        <div class="col-md-4">
                                            <button type="button" class="btn btn-outline-warning w-100 section-btn"
                                                data-target="video-section">Video</button>
                                        </div>
                                    </div>

                                    <!-- Boosting Section -->
                                    <div id="boosting-section" class="section-content p-2 mb-2 bg-light rounded d-none">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h5 class="m-0">Boosting Options</h5>
                                            <button type="button" class="btn btn-sm btn-primary add-boosting">+</button>
                                        </div>
                                        <div class="boosting-container">
                                            <div class="boosting-group">
                                                <div class="row g-2">
                                                    <div class="col-md-8">
                                                        <div class="row g-2">
                                                            <div class="mb-2 col-md-12">
                                                                <label class="form-label">Package</label>
                                                                <select name="boosting[0][package]" class="form-select">
                                                                    <option value="">Select Package</option>
                                                                    @foreach ($packages as $package)
                                                                        <option value="{{ $package->id }}"
                                                                            data-amount="{{ $package->package_amount }}"
                                                                            data-tax="{{ $package->tax }}"
                                                                            data-service="{{ $package->service }}">
                                                                            {{$package->full}}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="row g-2">
                                                            <div class="mb-2 col-md-4">
                                                                <label class="form-label">Package Amount</label>
                                                                <input type="text" name="boosting[0][package_amt]"
                                                                    class="form-control package-amt">
                                                            </div>
                                                            <div class="mb-2 col-md-4">
                                                                <label class="form-label">Tax</label>
                                                                <input type="text" name="boosting[0][tax]"
                                                                    class="form-control tax">
                                                            </div>
                                                            <div class="mb-2 col-md-4">
                                                                <label class="form-label">Service</label>
                                                                <input type="text" name="boosting[0][service]"
                                                                    class="form-control service">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="mb-2">
                                                            <label class="form-label">Work Type</label>
                                                            <select name="boosting[0][work_type]" class="form-select">
                                                                @foreach ($work_types as $work_type)
                                                                    @if ($work_type->order_type == 'boosting')
                                                                        <option value="{{ $work_type->name }}">
                                                                            {{ $work_type->name }}
                                                                        </option>
                                                                    @endif
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr class="my-3">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Designs Section -->
                                    <div id="designs-section" class="section-content p-2 mb-2 bg-light rounded d-none">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h5 class="m-0">Designs Options</h5>
                                            <button type="button" class="btn btn-sm btn-primary add-design">+</button>
                                        </div>
                                        <div class="design-container">
                                            <div class="design-group">
                                                <div class="row g-2">
                                                    <div class="mb-2 col-md-6">
                                                        <label class="form-label">Work Type</label>
                                                        <select name="design[0][work_type]" class="form-select">
                                                            @foreach ($work_types as $work_type)
                                                                @if ($work_type->order_type == 'designs')
                                                                    <option value="{{ $work_type->name }}">
                                                                        {{ $work_type->name }}
                                                                    </option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="mb-2 col-md-6">
                                                        <label class="form-label">Amount</label>
                                                        <input type="text" name="design[0][amount]"
                                                            class="form-control">
                                                    </div>
                                                </div>
                                                <hr class="my-3">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Video Section -->
                                    <div id="video-section" class="section-content p-2 mb-2 bg-light rounded d-none">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h5 class="m-0">Video Options</h5>
                                            <button type="button" class="btn btn-sm btn-primary add-video">+</button>
                                        </div>
                                        <div class="video-container">
                                            <div class="video-group">
                                                <div class="row g-2">
                                                    <div class="mb-2 col-md-4">
                                                        <label class="form-label">Time</label>
                                                        <select name="video[0][time]" class="form-select">
                                                            <option value="" selected>Select Time</option>
                                                            @foreach ($video_pkgs as $video_pkg)
                                                                <option value="{{ $video_pkg->time }}"
                                                                    data-amount="{{ $video_pkg->amount }}">
                                                                    Time : {{ $video_pkg->time }} = {{ $video_pkg->amount}}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="mb-2 col-md-4">
                                                        <label class="form-label">Amount</label>
                                                        <input type="text" name="video[0][amount]" class="form-control">
                                                    </div>
                                                    <div class="mb-2 col-md-4">
                                                        <label class="form-label">Style</label>
                                                        <select name="video[0][style]" class="form-select">
                                                            @foreach ($work_types as $work_type)
                                                                @if ($work_type->order_type == 'video')
                                                                    <option value="{{ $work_type->name }}">
                                                                        {{ $work_type->name }}
                                                                    </option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <hr class="my-3">
                                            </div>
                                        </div>
                                    </div>

                                    <script>
                                        document.addEventListener('DOMContentLoaded', function () {
                                            const sectionButtons = document.querySelectorAll('.section-btn');
                                            const checkboxes = {
                                                'boosting-section': document.getElementById('checkbox-boosting'),
                                                'designs-section': document.getElementById('checkbox-design'),
                                                'video-section': document.getElementById('checkbox-video')
                                            };

                                            function toggleFormElements(sectionId, enabled) {
                                                const section = document.getElementById(sectionId);
                                                const inputs = section.querySelectorAll('input, select, button');
                                                inputs.forEach(input => {
                                                    input.disabled = !enabled;
                                                });
                                            }

                                            // Initial state
                                            for (const sectionId in checkboxes) {
                                                toggleFormElements(sectionId, checkboxes[sectionId].checked);
                                            }

                                            // Checkbox toggles
                                            Object.entries(checkboxes).forEach(([sectionId, checkbox]) => {
                                                checkbox.addEventListener('change', () => {
                                                    toggleFormElements(sectionId, checkbox.checked);
                                                    if (!checkbox.checked) {
                                                        document.getElementById(sectionId).classList.add('d-none');
                                                    }
                                                });
                                            });

                                            // Section buttons
                                            sectionButtons.forEach(button => {
                                                button.addEventListener('click', function (e) {
                                                    const targetId = this.getAttribute('data-target');
                                                    const checkbox = checkboxes[targetId];

                                                    if (!checkbox || !checkbox.checked) {
                                                        e.preventDefault();
                                                        return;
                                                    }

                                                    const section = document.getElementById(targetId);
                                                    section.classList.toggle('d-none');

                                                    Object.keys(checkboxes).forEach(id => {
                                                        if (id !== targetId) {
                                                            document.getElementById(id).classList.add('d-none');
                                                        }
                                                    });
                                                });
                                            });

                                            // Dynamic Field Logic
                                            let boostIndex = 0;
                                            document.querySelector('.add-boosting').addEventListener('click', function () {
                                                boostIndex++;
                                                const clone = document.querySelector('.boosting-group').cloneNode(true);
                                                clone.innerHTML = clone.innerHTML.replace(/\[0\]/g, `[${boostIndex}]`);
                                                document.querySelector('.boosting-container').appendChild(clone);
                                                applyServiceLogic();
                                            });

                                            let designIndex = 0;
                                            document.querySelector('.add-design').addEventListener('click', function () {
                                                designIndex++;
                                                const clone = document.querySelector('.design-group').cloneNode(true);
                                                clone.innerHTML = clone.innerHTML.replace(/\[0\]/g, `[${designIndex}]`);
                                                document.querySelector('.design-container').appendChild(clone);
                                            });

                                            let videoIndex = 0;
                                            document.querySelector('.add-video').addEventListener('click', function () {
                                                videoIndex++;
                                                const clone = document.querySelector('.video-group').cloneNode(true);
                                                clone.innerHTML = clone.innerHTML.replace(/\[0\]/g, `[${videoIndex}]`);
                                                document.querySelector('.video-container').appendChild(clone);
                                            });

                                            // Package Selection Logic
                                            document.addEventListener('change', function (e) {
                                                if (e.target.matches('select[name^="boosting"]')) {
                                                    const parent = e.target.closest('.boosting-group');
                                                    const selectedOption = e.target.options[e.target.selectedIndex];
                                                    parent.querySelector('.package-amt').value = selectedOption.dataset.amount || '';
                                                    parent.querySelector('.tax').value = selectedOption.dataset.tax || '';
                                                    parent.querySelector('.service').value = selectedOption.dataset.service || '';
                                                    applyServiceLogic();
                                                }
                                            });

                                            // Custom Service Logic
                                            function applyServiceLogic() {
                                                const groups = document.querySelectorAll('.boosting-group');
                                                groups.forEach((group, index) => {
                                                    const amtInput = group.querySelector('.package-amt');
                                                    const serviceInput = group.querySelector('.service');

                                                    let amount = parseFloat(amtInput.value.replace(/,/g, '')) || 0;

                                                    if (amount >= 100000) {
                                                        serviceInput.value = (amount * 0.1).toFixed(2); // 10% service
                                                    } else if ((index + 1) % 5 === 0) {
                                                        serviceInput.value = '0'; // every 5th boosting
                                                    }
                                                    // else leave original value (from selected package)
                                                });
                                            }

                                            // Auto-fill amount when time is selected
                                            document.addEventListener('change', function (e) {
                                                if (e.target.matches('select[name^="video"][name$="[time]"]')) {
                                                    const opt = e.target.selectedOptions[0];
                                                    const amt = opt.dataset.amount || '';
                                                    const group = e.target.closest('.video-group');
                                                    const input = group.querySelector('input[name^="video"][name$="[amount]"]');
                                                    if (input) input.value = amt;
                                                }
                                            });
                                        });
                                    </script>

                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Place Order</button>
            </div>
            </form>
        </div>
    </div>
</div>