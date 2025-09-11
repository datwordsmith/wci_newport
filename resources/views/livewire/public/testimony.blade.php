<div>
    @section('description', $description)

    @section('content')
    <section class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card shadow">
                        <div class="card-body p-4 p-md-5">
                            <!-- Back button -->
                            <div class="mb-4 d-flex justify-content-between align-items-center">
                                <a href="{{ route('testimonies') }}" class="btn btn-outline-secondary btn-sm">
                                    <i class="fas fa-arrow-left me-2"></i>Back to All Testimonies
                                </a>
                                <div class="d-flex gap-2">
                                    <button onclick="printTestimony()" class="btn btn-primary-custom btn-sm" title="Print testimony">
                                        <i class="fas fa-print"></i>
                                    </button>
                                    <button onclick="generatePDF()" class="btn btn-primary-custom btn-sm" title="Download as PDF">
                                        <i class="fas fa-file-pdf"></i>
                                    </button>
                                    <button onclick="shareCurrentTestimony()" class="btn btn-primary-custom btn-sm" title="Share testimony">
                                        <i class="fas fa-share-alt"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Testimony header -->
                            <div class="mb-4">
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <span class="badge bg-success">{{ $testimony->result_category }}</span>
                                    <small class="text-muted">
                                        {{ optional($testimony->reviewed_at ?? $testimony->created_at)->format('M j, Y') }}
                                    </small>
                                </div>
                                <h2 class="mb-1">{{ $testimony->title }}</h2>
                                <p class="text-muted mb-0">by {{ $testimony->author }}</p>
                            </div>

                            <!-- Testimony content -->
                            <div class="testimony-content mb-4 p-4 bg-light rounded">
                                <p style="white-space: pre-line">{{ $testimony->content }}</p>
                            </div>

                            <!-- Photos -->
                            @if($testimony->approvedImages && $testimony->approvedImages->count() > 0)
                                <div class="mb-4" data-pdf-exclude="true">
                                    <h6 class="text-muted mb-2">Photos</h6>
                                    <div class="row g-3">
                                        @foreach($testimony->approvedImages as $img)
                                            <div class="col-md-4 col-6">
                                                <div class="card h-100 shadow-sm">
                                                    <div class="position-relative">
                                                        <a href="#"
                                                           class="d-block"
                                                           role="button"
                                                           data-image-src="{{ asset('storage/' . $img->image) }}"
                                                           data-image-alt="{{ $img->caption ?? ('Photo '.$loop->iteration) }}"
                                                           data-image-caption="{{ $img->caption }}">
                                                            <img src="{{ asset('storage/' . $img->image) }}" class="card-img-top" style="height:180px;object-fit:cover;cursor:zoom-in;" alt="{{ $img->caption ?? ('Photo '.$loop->iteration) }}">
                                                            <span class="badge bg-dark bg-opacity-75 position-absolute bottom-0 end-0 m-2"><i class="fas fa-search-plus"></i></span>
                                                        </a>
                                                    </div>
                                                    @if($img->caption)
                                                        <div class="card-body p-2">
                                                            <small class="text-muted">{{ $img->caption }}</small>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <!-- Engagements tags -->
                            @if($testimony->engagements && count($testimony->engagements))
                                <div class="mb-4">
                                    <h6 class="text-muted mb-2">Engagements</h6>
                                    <div class="d-flex flex-wrap gap-2">
                                        @foreach($testimony->engagements as $engagement)
                                            <span class="badge bg-secondary">{{ $engagement }}</span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <!-- Action buttons -->
                            <div class="d-flex justify-content-end align-items-center mt-4">

                                <a href="{{ route('testimonies.create') }}" class="btn btn-primary-custom">
                                    <i class="fas fa-microphone me-2"></i>Share Your Testimony
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Image Lightbox Modal -->
        <div class="modal fade" id="imageLightboxModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content bg-dark text-light">
                    <div class="modal-body p-0">
                        <img id="lightboxImage" src="" alt="Preview" class="img-fluid w-100">
                    </div>
                    <div class="modal-footer d-flex justify-content-between">
                        <small class="text-light" id="lightboxCaption"></small>
                        <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endsection

    @push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script>
        // Data used for printing
        const __engagements = @json($testimony->engagements ?? []);

        function shareCurrentTestimony() {
            // Check if Web Share API is supported
            if (navigator.share) {
                navigator.share({
                    title: '{{ addslashes($testimony->title) }}',
                    text: '{{ addslashes($testimony->title) }} - A testimony by {{ addslashes($testimony->author) }}',
                    url: window.location.href,
                })
                .then(() => console.log('Shared successfully'))
                .catch((error) => console.log('Error sharing:', error));
            } else {
                // Fallback for browsers that don't support Web Share API
                // Copy URL to clipboard
                const tempInput = document.createElement('input');
                document.body.appendChild(tempInput);
                tempInput.value = window.location.href;
                tempInput.select();
                document.execCommand('copy');
                document.body.removeChild(tempInput);

                // Alert user
                alert('URL copied to clipboard! You can now share this testimony with others.');
            }
        }

        function printTestimony() {
            // Build engagements HTML (no images included)
            const engagementsHtml = (__engagements && __engagements.length)
                ? `
                    <div style="margin: 10px 0 20px 0;">
                        <h4 style="margin: 0 0 8px 0; color:#6c757d; font-size: 14px;">Engagements</h4>
                        <div>
                            ${__engagements.map(e => `<span class="badge bg-secondary" style="margin-right:6px;">${e}</span>`).join(' ')}
                        </div>
                    </div>
                  `
                : '';

             // Create a printable version
             const printContent = document.createElement('div');
             printContent.innerHTML = `
                 <div style="max-width: 800px; margin: 20px auto; font-family: Arial, sans-serif;">
                     <h2 style="text-align: center; margin-bottom: 10px;">Winners Chapel International Newport</h2>
                     <h3 style="text-align: center; margin-bottom: 30px;">Testimony</h3>
                     <h4 style="margin-bottom: 5px;">${document.querySelector('h2').innerText}</h4>
                     <p style="color: #666; margin-bottom: 20px;">by ${document.querySelector('h2 + p').innerText} | ${document.querySelector('.badge').innerText}</p>
                     <div style="border: 1px solid #eee; border-radius: 5px; padding: 20px; margin-bottom: 20px; background-color: #f9f9f9;">
                         ${document.querySelector('.testimony-content p').innerHTML}
                     </div>
+                    ${engagementsHtml}
                     <p style="color: #666; text-align: center; font-size: 12px; margin-top: 30px;">
                         Printed from Winners Chapel International Newport | ${new Date().toLocaleDateString()}
                     </p>
                 </div>
             `;

             // Print the page
             const originalContent = document.body.innerHTML;
             document.body.innerHTML = printContent.innerHTML;
             window.print();
             document.body.innerHTML = originalContent;

             // Re-initialize Livewire after restoring content
             window.Livewire && window.Livewire.rescan && window.Livewire.rescan();
         }

         function generatePDF() {
             // Select the element to convert to PDF
             const element = document.querySelector('.card');

             // Configure pdf options
             const opt = {
                 margin: [10, 10, 10, 10],
                 filename: '{{ Illuminate\Support\Str::slug($testimony->title) }}_testimony.pdf',
                 image: { type: 'jpeg', quality: 0.98 },
                 html2canvas: { scale: 2, useCORS: true },
                 jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
             };

             // Create a clone of the element to modify for PDF
             const pdfContent = element.cloneNode(true);

             // Add a header
             const header = document.createElement('div');
             header.innerHTML = `
                 <div style="text-align: center; margin-bottom: 20px;">
                     <h2 style="margin-bottom: 5px;">Winners Chapel International Newport</h2>
                     <h3>Testimony</h3>
                 </div>
             `;
             pdfContent.querySelector('.card-body').prepend(header);

             // Add a footer
             const footer = document.createElement('div');
             footer.innerHTML = `
                 <div style="text-align: center; margin-top: 20px; font-size: 12px; color: #666;">
                     <p>Downloaded from Winners Chapel International Newport | ${new Date().toLocaleDateString()}</p>
                 </div>
             `;
             pdfContent.querySelector('.card-body').appendChild(footer);

             // Remove buttons and any elements marked to exclude from PDF (e.g., photos)
             pdfContent.querySelectorAll('button, .btn, [data-pdf-exclude]').forEach(el => el.remove());

             // Generate PDF
             html2pdf().from(pdfContent).set(opt).save();
         }
    </script>
    <script>
        // Image lightbox click handler (guarded for duplicate bindings)
        if (!window.__wciImageLightboxBound) {
            window.__wciImageLightboxBound = true;
            document.addEventListener('click', function (e) {
                const trigger = e.target.closest('[data-image-src]');
                if (!trigger) return;
                e.preventDefault();
                const modalEl = document.getElementById('imageLightboxModal');
                if (!modalEl) return;
                const imgEl = modalEl.querySelector('#lightboxImage');
                const capEl = modalEl.querySelector('#lightboxCaption');
                imgEl.src = trigger.getAttribute('data-image-src');
                imgEl.alt = trigger.getAttribute('data-image-alt') || 'Image';
                capEl.textContent = trigger.getAttribute('data-image-caption') || '';
                if (window.bootstrap && bootstrap.Modal) {
                    const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
                    modal.show();
                } else {
                    modalEl.classList.add('show');
                    modalEl.style.display = 'block';
                    modalEl.removeAttribute('aria-hidden');
                    modalEl.setAttribute('aria-modal', 'true');
                    modalEl.addEventListener('click', function(ev) {
                        if (ev.target === modalEl) {
                            modalEl.classList.remove('show');
                            modalEl.style.display = 'none';
                            modalEl.setAttribute('aria-hidden', 'true');
                        }
                    }, { once: true });
                }
            });
        }
    </script>
    @endpush
 </div>
