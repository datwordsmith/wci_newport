<div>
    <div class="container-fluid py-4">
        <!-- Header -->
        <div class="row mb-4">
            <div class="col-12 d-flex justify-content-between align-items-start align-items-md-center flex-column flex-md-row gap-2">
                <div>
                    <h1 class="h3 mb-1 text-primary-custom">Add Testimony</h1>
                    <p class="text-muted mb-0">Capture testimonies received by email or offline and publish them.</p>
                </div>
                <div class="d-flex gap-2 w-100 w-md-auto">
                    <a href="{{ route('admin.testimonies.manage') }}" class="btn btn-outline-secondary w-100 w-md-auto">
                        <i class="fas fa-arrow-left me-2"></i>Back to List
                    </a>
                    <button class="btn btn-primary-custom w-100 w-md-auto" wire:click="save">
                        <i class="fas fa-save me-2"></i>Save Testimony
                    </button>
                </div>
            </div>
        </div>

        <!-- Form Card -->
        <div class="card">
            <div class="card-body">
                <form wire:submit.prevent="save">
                    <div class="row g-3">
                        <!-- Title -->
                        <div class="col-12">
                            <label class="form-label fw-semibold">Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" wire:model.defer="title" placeholder="Enter testimony title">
                            @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <!-- Author & Email -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Author Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('author') is-invalid @enderror" wire:model.defer="author" placeholder="Enter author's name">
                            @error('author')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Email Address <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" wire:model.defer="email" placeholder="Enter email address">
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <!-- Phone & Date -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Phone Number</label>
                            <input type="tel" class="form-control @error('phone') is-invalid @enderror" wire:model.defer="phone" placeholder="Enter phone number (optional)">
                            @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Testimony Date</label>
                            <input type="date" class="form-control @error('testimony_date') is-invalid @enderror" wire:model.defer="testimony_date" max="{{ date('Y-m-d') }}">
                            @error('testimony_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <!-- Category & Status -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Result Category <span class="text-danger">*</span></label>
                            <select class="form-select @error('result_category') is-invalid @enderror" wire:model.defer="result_category">
                                <option value="">Select a category</option>
                                @foreach($this->resultCategories as $key => $category)
                                    <option value="{{ $key }}">{{ $category }}</option>
                                @endforeach
                            </select>
                            @error('result_category')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
                            <select class="form-select @error('status') is-invalid @enderror" wire:model.defer="status">
                                <option value="approved">Approved</option>
                                <option value="pending">Pending Review</option>
                                <option value="declined">Declined</option>
                            </select>
                            @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <!-- Engagements -->
                        <div class="col-12">
                            <label class="form-label fw-semibold">Ministry Engagements</label>
                            <div class="row g-2">
                                @foreach($this->engagementTypes as $key => $label)
                                    <div class="col-6 col-md-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="eng_{{ $loop->index }}" value="{{ $key }}" wire:model.defer="engagements">
                                            <label for="eng_{{ $loop->index }}" class="form-check-label">{{ $label }}</label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="col-12">
                            <label class="form-label fw-semibold">Testimony Content <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('content') is-invalid @enderror" wire:model.defer="content" rows="8" placeholder="Enter the full testimony content..."></textarea>
                            @error('content')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            <div class="form-text">Minimum 50 characters required</div>
                        </div>

                        <!-- Images -->
                        <div class="col-12">
                            <label class="form-label fw-semibold">Upload Images (Optional - Max 3)</label>
                            <input type="file" class="form-control @error('images.*') is-invalid @enderror" wire:model="images" multiple accept="image/*">
                            @error('images.*')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            <div class="form-text">Maximum 3 images, 2MB each. PNG, JPG, JPEG formats.</div>

                            @if (session()->has('warning'))
                                <div class="alert alert-warning mt-2">{{ session('warning') }}</div>
                            @endif

                            @if(count($images) > 0)
                                <div class="row g-3 mt-2">
                                    @foreach($images as $index => $image)
                                        <div class="col-md-4" wire:key="image-{{ $index }}">
                                            <div class="card">
                                                <img src="{{ $image->temporaryUrl() }}" class="card-img-top" style="height: 150px; object-fit: cover;" alt="Preview">
                                                <div class="card-body p-2">
                                                    <input type="text" class="form-control form-control-sm" wire:model.defer="imageCaptions.{{ $index }}" placeholder="Image caption (optional)">
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <!-- Publish Permission -->
                        <div class="col-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="publish_permission" wire:model.defer="publish_permission">
                                <label for="publish_permission" class="form-check-label"><strong>Author has given permission to publish this testimony</strong></label>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="{{ route('admin.testimonies.manage') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times me-1"></i>Cancel
                        </a>
                        <button type="submit" class="btn btn-primary-custom">
                            <i class="fas fa-save me-1"></i>Save Testimony
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
