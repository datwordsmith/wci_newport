<div>

    @if($submissionComplete)
        <!-- Success Screen -->
        <section class="py-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="text-center">
                            <!-- Success Animation/Icon -->
                            <div class="mb-4">
                                <i class="fas fa-check-circle text-success" style="font-size: 4rem;"></i>
                            </div>

                            <!-- Success Message -->
                            <h2 class="text-success mb-3">Testimony Submitted Successfully!</h2>
                            <p class="lead mb-4">
                                Thank you for sharing "<strong>{{ $submittedTestimonyTitle }}</strong>" with us.
                            </p>

                            <!-- Review Process Info -->
                            <div class="card border-info mb-4">
                                <div class="card-body">
                                    <h5 class="card-title text-info">
                                        <i class="fas fa-info-circle me-2"></i>What happens next?
                                    </h5>
                                    <p class="card-text mb-3">
                                        Your testimony will be carefully reviewed by our ministry team to ensure it aligns with our values and guidelines. This process typically takes 1-3 business days.
                                    </p>
                                    <div class="row text-start">
                                        <div class="col-md-6">
                                            <div class="d-flex align-items-center mb-2">
                                                <i class="fas fa-clock text-warning me-2"></i>
                                                <span>Review within 1-3 days</span>
                                            </div>
                                            <div class="d-flex align-items-center mb-2">
                                                <i class="fas fa-envelope text-primary me-2"></i>
                                                <span>Email notification when reviewed</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="d-flex align-items-center mb-2">
                                                <i class="fas fa-globe text-success me-2"></i>
                                                <span>Published on testimonies page</span>
                                            </div>
                                            <div class="d-flex align-items-center mb-2">
                                                <i class="fas fa-heart text-danger me-2"></i>
                                                <span>Shared to inspire others</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Call to Action Buttons -->
                            <div class="d-flex flex-column flex-md-row gap-3 justify-content-center">
                                <button wire:click="addAnotherTestimony" class="btn btn-primary-custom">
                                    <i class="fas fa-plus me-2"></i>Share Another Testimony
                                </button>
                                <button wire:click="goToTestimonies" class="btn btn-outline-secondary">
                                    <i class="fas fa-book-open me-2"></i>View All Testimonies
                                </button>
                            </div>

                            <!-- Additional Encouragement -->
                            <div class="mt-4 text-muted">
                                <p class="mb-0">
                                    <i class="fas fa-hands-praying me-1"></i>
                                    Your testimony has the power to encourage and inspire others. Thank you for being a witness to God's goodness!
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @else
        <!-- Form Section -->
        <section class="py-5">
            <div class="container">
                <div class="text-center mb-5">
                    <p class="lead">Tell us how God has moved in your life and inspire others with your testimony</p>
                </div>
                <div class="row justify-content-center">
                    <div class="col-md-8">

                    <!-- Back Button -->
                    <div class="mb-3 text-end">
                        <a href="{{ route('testimonies') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Back to Testimonies
                        </a>
                    </div>

                    @if (session()->has('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if (session()->has('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="card shadow-sm">
                        <div class="card-body p-4">
                            <form wire:submit="submitTestimony">
                                <div class="row g-4">
                                    <!-- Basic Information -->
                                    <div class="col-md-6">
                                        <label for="title" class="form-label fw-semibold">
                                            Testimony Title <span class="text-danger">*</span>
                                        </label>
                                        <input type="text"
                                               wire:model="title"
                                               class="form-control @error('title') is-invalid @enderror"
                                               id="title"
                                               placeholder="Enter a title for your testimony">
                                        @error('title')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="author" class="form-label fw-semibold">
                                            Your Name <span class="text-danger">*</span>
                                        </label>
                                        <input type="text"
                                               wire:model="author"
                                               class="form-control @error('author') is-invalid @enderror"
                                               id="author"
                                               placeholder="Enter your full name">
                                        @error('author')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Contact Information -->
                                    <div class="col-md-6">
                                        <label for="email" class="form-label fw-semibold">
                                            Email Address <span class="text-danger">*</span>
                                        </label>
                                        <input type="email"
                                               wire:model="email"
                                               class="form-control @error('email') is-invalid @enderror"
                                               id="email"
                                               placeholder="Enter your email address">
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="phone" class="form-label fw-semibold">
                                            Phone Number
                                        </label>
                                        <input type="tel"
                                               wire:model="phone"
                                               class="form-control @error('phone') is-invalid @enderror"
                                               id="phone"
                                               placeholder="Enter your phone number (optional)">
                                        @error('phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Category and Date -->
                                    <div class="col-md-6">
                                        <label for="result_category" class="form-label fw-semibold">
                                            Result Category <span class="text-danger">*</span>
                                        </label>
                                        <select wire:model="result_category"
                                                class="form-select @error('result_category') is-invalid @enderror"
                                                id="result_category">
                                            <option value="">Select a result category</option>
                                            @foreach($this->resultCategories as $key => $category)
                                                <option value="{{ $key }}">{{ $category }}</option>
                                            @endforeach
                                        </select>
                                        @error('result_category')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="testimony_date" class="form-label fw-semibold">
                                            Date of Testimony
                                        </label>
                                        <input type="date"
                                               wire:model="testimony_date"
                                               class="form-control @error('testimony_date') is-invalid @enderror"
                                               id="testimony_date"
                                               max="{{ date('Y-m-d') }}">
                                        @error('testimony_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Engagements -->
                                    <div class="col-12">
                                        <label class="form-label fw-semibold">
                                            Engagements - (What did you do?)
                                            <span class="text-muted small">Select all that apply</span>
                                        </label>
                                        <div class="row g-2">
                                            @foreach($this->engagementTypes as $key => $engagement)
                                                <div class="col-md-3 col-6">
                                                    <div class="form-check">
                                                        <input wire:model="engagements"
                                                               class="form-check-input"
                                                               type="checkbox"
                                                               value="{{ $key }}"
                                                               id="engagement{{ $loop->index }}">
                                                        <label class="form-check-label" for="engagement{{ $loop->index }}">
                                                            {{ $engagement }}
                                                        </label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        @error('engagements')
                                            <div class="text-danger small">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Testimony Content -->
                                    <div class="col-12">
                                        <label for="content" class="form-label fw-semibold">
                                            Your Testimony <span class="text-danger">*</span>
                                        </label>
                                        <textarea wire:model="content"
                                                  class="form-control @error('content') is-invalid @enderror"
                                                  id="content"
                                                  rows="8"
                                                  placeholder="Share your testimony in detail. Include what happened, how God moved in your situation, and the impact it had on your life..."></textarea>
                                        <div class="form-text">
                                            Please share your testimony in detail (minimum 50 characters).
                                            Current length: <span class="fw-bold">{{ strlen($content) }}</span> characters
                                        </div>
                                        @error('content')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Images (Optional) -->
                                    <div class="col-12">
                                        <label class="form-label fw-semibold">
                                            <i class="fas fa-camera me-2"></i>Upload Images (Optional)
                                            <span class="text-muted small">Max 3 images, each up to 2MB</span>
                                        </label>
                                        @if(session()->has('warning'))
                                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                                {{ session('warning') }}
                                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                            </div>
                                        @endif
                                        <input type="file" multiple accept="image/*" wire:model="images" class="form-control @error('images.*') is-invalid @enderror">
                                        <div class="form-text">
                                            Accepted formats: JPG, PNG, GIF. Images will be reviewed before they appear publicly.
                                        </div>
                                        @error('images.*')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror

                                        <!-- Upload Progress -->
                                        @if($images && count($images) > 0)
                                            <div class="row g-3 mt-3">
                                                @foreach($images as $idx => $img)
                                                    <div class="col-md-4 col-6">
                                                        <div class="card h-100 shadow-sm">
                                                            <div class="position-relative">
                                                                @if(method_exists($img,'temporaryUrl'))
                                                                    <img src="{{ $img->temporaryUrl() }}" class="card-img-top" style="height:140px;object-fit:cover;" alt="Preview {{ $idx+1 }}">
                                                                @else
                                                                    <div class="d-flex align-items-center justify-content-center bg-light" style="height:140px;">
                                                                        <span class="text-muted small">Preview unavailable</span>
                                                                    </div>
                                                                @endif
                                                                <button type="button" wire:click="removeImage({{ $idx }})" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2" title="Remove image">
                                                                    <i class="fas fa-times"></i>
                                                                </button>
                                                            </div>
                                                            <div class="card-body p-2">
                                                                <input type="text" wire:model="imageCaptions.{{ $idx }}" maxlength="255" class="form-control form-control-sm" placeholder="Caption (optional)">
                                                                <small class="text-muted d-block mt-1">{{ strlen($imageCaptions[$idx] ?? '') }}/255</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Permission -->
                                    <div class="col-12">
                                        <div class="form-check">
                                            <input wire:model="publish_permission"
                                                   class="form-check-input @error('publish_permission') is-invalid @enderror"
                                                   type="checkbox"
                                                   id="publish_permission">
                                            <label class="form-check-label" for="publish_permission">
                                                <strong>I give permission for this testimony to be published on the church website and used for ministry purposes.</strong>
                                                <span class="text-danger">*</span>
                                            </label>
                                            @error('publish_permission')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Form Actions -->
                                <div class="row mt-4">
                                    <div class="col-12">
                                        <div class="d-flex gap-2 justify-content-end">
                                            <button type="button" wire:click="resetForm" class="btn btn-outline-secondary">
                                                <i class="fas fa-undo me-2"></i>Reset Form
                                            </button>
                                            <button type="submit" class="btn btn-primary-custom">
                                                <i class="fas fa-paper-plane me-2"></i>Submit Testimony
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif

    <!-- Confirmation Modal -->
    @if($showConfirmationModal)
        <div class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.5);">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="fas fa-check-circle text-warning me-2"></i>
                            Confirm Your Testimony Submission
                        </h5>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Important:</strong> Once submitted, you will not be able to edit your testimony. Please review the details below carefully.
                        </div>

                        <!-- Testimony Summary -->
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Testimony Summary</h6>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <strong>Title:</strong><br>
                                        <span class="text-muted">{{ $title }}</span>
                                    </div>
                                    <div class="col-md-6">
                                        <strong>Author:</strong><br>
                                        <span class="text-muted">{{ $author }}</span>
                                    </div>
                                    <div class="col-md-6">
                                        <strong>Email:</strong><br>
                                        <span class="text-muted">{{ $email }}</span>
                                    </div>
                                    @if($phone)
                                    <div class="col-md-6">
                                        <strong>Phone:</strong><br>
                                        <span class="text-muted">{{ $phone }}</span>
                                    </div>
                                    @endif
                                    <div class="col-md-6">
                                        <strong>Category:</strong><br>
                                        <span class="text-muted">{{ $this->resultCategories[$result_category] ?? $result_category }}</span>
                                    </div>
                                    @if($testimony_date)
                                    <div class="col-md-6">
                                        <strong>Date:</strong><br>
                                        <span class="text-muted">{{ \Carbon\Carbon::parse($testimony_date)->format('F j, Y') }}</span>
                                    </div>
                                    @endif
                                    @if(!empty($engagements))
                                    <div class="col-12">
                                        <strong>Engagements:</strong><br>
                                        <span class="text-muted">
                                            @foreach($engagements as $engagement)
                                                <span class="badge bg-secondary me-1">{{ $this->engagementTypes[$engagement] ?? $engagement }}</span>
                                            @endforeach
                                        </span>
                                    </div>
                                    @endif
                                    <div class="col-12">
                                        <strong>Testimony:</strong><br>
                                        <div class="border rounded p-3 bg-light" style="max-height: 200px; overflow-y: auto;">
                                            {!! nl2br(e($content)) !!}
                                        </div>
                                        <small class="text-muted">{{ strlen($content) }} characters</small>
                                    </div>
                                </div>

                                @if($images && count($images) > 0)
                                    <hr class="my-4">
                                    <div>
                                        <h6 class="mb-2">Selected Images</h6>
                                        <div class="row g-3">
                                            @foreach($images as $idx => $img)
                                                <div class="col-md-4 col-6">
                                                    <div class="card h-100 shadow-sm">
                                                        <div class="position-relative">
                                                            @if(method_exists($img,'temporaryUrl'))
                                                                <img src="{{ $img->temporaryUrl() }}" class="card-img-top" style="height:140px;object-fit:cover;" alt="Preview {{ $idx+1 }}">
                                                            @else
                                                                <div class="d-flex align-items-center justify-content-center bg-light" style="height:140px;">
                                                                    <span class="text-muted small">Preview unavailable</span>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <div class="card-body p-2">
                                                            @if(!empty($imageCaptions[$idx] ?? ''))
                                                                <small class="d-block">Caption: {{ $imageCaptions[$idx] }}</small>
                                                            @else
                                                                <small class="text-muted fst-italic">No caption</small>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" wire:click="cancelSubmission" class="btn btn-secondary">
                            <i class="fas fa-edit me-2"></i>Go Back to Edit
                        </button>
                        <button type="button"
                                wire:click="confirmSubmission"
                                wire:loading.attr="disabled"
                                wire:target="confirmSubmission"
                                class="btn btn-success">
                            <span wire:loading.remove wire:target="confirmSubmission">
                                <i class="fas fa-paper-plane me-2"></i>Yes, Submit Testimony
                            </span>
                            <span wire:loading wire:target="confirmSubmission">
                                <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                                Submitting...
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
