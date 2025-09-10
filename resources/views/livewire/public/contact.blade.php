<div>

        <!-- Contact Details -->
        <section class="py-5">
            <div class="container">
                <div class="row g-4">
                    <!-- Map + Quick Contacts -->
                    <div class="col-md-6">
                        <!-- Quick contact chips -->
                        <div class="mb-3 contact-chips">
                            <a class="contact-chip" href="https://maps.google.com/?q=Winners+Chapel+International,+Church+Rd,+Newport+NP19+7EJ" target="_blank" rel="noopener">
                                <span class="chip-icon"><i class="fas fa-map-marker-alt"></i></span>
                                Church Rd, Newport NP19 7EJ
                            </a>

                            <a class="contact-chip" href="tel:07901024213">
                                <span class="chip-icon"><i class="fas fa-phone"></i></span>
                                07901 024213
                            </a>
                        </div>

                        <!-- Social icons -->
                        <div class="mb-3 social-round">
                            <a href="https://www.facebook.com/61553737660932" aria-label="Facebook" target="_blank" rel="noopener"><i class="fab fa-facebook-f"></i></a>
                            <a href="https://x.com/wcinewport" aria-label="Twitter" target="_blank" rel="noopener"><i class="fab fa-twitter"></i></a>
                            <a href="https://www.instagram.com/wcinewport/" aria-label="Instagram" target="_blank" rel="noopener"><i class="fab fa-instagram"></i></a>
                        </div>
                        <div class="card shadow-sm mt-3">
                            <div class="card-body p-2">
                                <div class="ratio ratio-16x9">
                                    <iframe class="map-iframe" title="Map to Winners Chapel International, Church Rd, Newport" allowfullscreen
                                        src="https://www.google.com/maps?q=Winners+Chapel+International,+Church+Rd%2C+Newport+NP19+7EJ&output=embed"></iframe>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-6">
                        <div class="card shadow-sm">
                            <div class="card-body p-4">
                                <h3 class="serif-font mb-3">Send us a message</h3>
                                {{-- Success message removed: now handled by toastr --}}

                                @if(session()->has('error'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                @endif

                                <form wire:submit.prevent="submitForm">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" wire:model="name" placeholder="Full Name" required>
                                                <label for="name">Full Name</label>
                                            </div>
                                            @error('name') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" wire:model="email" placeholder="you@example.com" required>
                                                <label for="email">Email</label>
                                            </div>
                                            @error('email') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <input type="tel" class="form-control @error('phone') is-invalid @enderror" id="phone" wire:model="phone" placeholder="Phone (Optional)">
                                                <label for="phone">Phone (Optional)</label>
                                            </div>
                                            @error('phone') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <select class="form-select @error('category') is-invalid @enderror" id="category" wire:model="category" required>
                                                    <option value="" selected>Select a category...</option>
                                                    @foreach($categoryOptions as $key => $option)
                                                        <option value="{{ $key }}">{{ $option }}</option>
                                                    @endforeach
                                                </select>
                                                <label for="category">Message Category</label>
                                            </div>
                                            @error('category') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                        </div>
                                        <div class="col-12">
                                            <div class="form-floating">
                                                <input type="text" class="form-control @error('subject') is-invalid @enderror" id="subject" wire:model="subject" placeholder="Brief subject of your message" required>
                                                <label for="subject">Subject</label>
                                            </div>
                                            @error('subject') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                        </div>
                                        <div class="col-12">
                                            <div class="form-floating">
                                                <textarea id="message" class="form-control @error('message') is-invalid @enderror" style="height: 120px" wire:model="message" placeholder="Your message here..." required></textarea>
                                                <label for="message">Message</label>
                                            </div>
                                            @error('message') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                    <div class="mt-3 d-flex gap-2">
                                        <button type="submit" class="btn btn-primary-custom" wire:loading.attr="disabled">
                                            <span wire:loading.remove>
                                                <i class="fas fa-paper-plane me-2"></i>Send Message
                                            </span>
                                            <span wire:loading>
                                                <span class="spinner-border spinner-border-sm" role="status"></span>
                                                Sending...
                                            </span>
                                        </button>
                                        <button type="button" class="btn btn-outline-secondary" wire:click="resetForm">Clear</button>
                                    </div>
                                </form>

                                {{-- JavaScript removed - no longer needed since we use toastr --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
</div>
