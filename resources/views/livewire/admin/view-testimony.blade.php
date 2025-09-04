<div>
    <div class="container-fluid py-4">
        <!-- Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('admin.testimonies.manage') }}" class="text-decoration-none">
                                        <i class="fas fa-microphone me-1"></i>Testimonies
                                    </a>
                                </li>
                                <li class="breadcrumb-item active">Review Testimony</li>
                            </ol>
                        </nav>
                        <h1 class="h3 mb-1">Review Testimony</h1>
                        <p class="text-muted mb-0">Review and make a decision on this testimony submission</p>
                    </div>
                    <div class="text-end">
                        <a href="{{ route('admin.testimonies.manage') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Back to List
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Success/Error Messages -->
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

        <div class="row">
            <!-- Testimony Details -->
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h5 class="mb-1">{{ $testimony->title }}</h5>
                                <p class="text-muted mb-0">by {{ $testimony->author }}</p>
                            </div>
                            <div>
                                @if($testimony->status === 'pending')
                                    <span class="badge text-bg-warning">
                                        <i class="fas fa-clock me-1"></i>Pending Review
                                    </span>
                                @elseif($testimony->status === 'approved')
                                    <span class="badge text-bg-success">
                                        <i class="fas fa-check me-1"></i>Approved
                                    </span>
                                @else
                                    <span class="badge text-bg-danger">
                                        <i class="fas fa-times me-1"></i>Declined
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Contact Information -->
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <div class="border rounded p-3">
                                    <h6 class="text-muted mb-2">Contact Information</h6>
                                    <p class="mb-1">
                                        <i class="fas fa-envelope me-2 text-primary"></i>
                                        <a href="mailto:{{ $testimony->email }}" class="text-decoration-none">
                                            {{ $testimony->email }}
                                        </a>
                                    </p>
                                    @if($testimony->phone)
                                        <p class="mb-0">
                                            <i class="fas fa-phone me-2 text-primary"></i>
                                            <a href="tel:{{ $testimony->phone }}" class="text-decoration-none">
                                                {{ $testimony->phone }}
                                            </a>
                                        </p>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="border rounded p-3">
                                    <h6 class="text-muted mb-2">Testimony Details</h6>
                                    <p class="mb-1">
                                        <strong>Category:</strong>
                                        <span class="badge bg-info">{{ $testimony->result_category }}</span>
                                    </p>
                                    @if($testimony->testimony_date)
                                        <p class="mb-1">
                                            <strong>Date:</strong> {{ $testimony->formatted_testimony_date }}
                                        </p>
                                    @endif
                                    <p class="mb-0">
                                        <strong>Submitted:</strong> {{ $testimony->created_at->format('M j, Y g:i A') }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Engagements -->
                        @if($testimony->engagements && count($testimony->engagements) > 0)
                            <div class="mb-4">
                                <h6 class="text-muted mb-2">Engagements</h6>
                                <div class="d-flex flex-wrap gap-2">
                                    @foreach($testimony->engagements as $engagement)
                                        <span class="badge text-bg-secondary">{{ $engagement }}</span>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Testimony Content -->
                        <div class="mb-4">
                            <h6 class="text-muted mb-3">Testimony Content</h6>
                            <div class="border rounded p-4 bg-light">
                                <div class="testimony-content" style="line-height: 1.6;">
                                    {!! nl2br(e($testimony->content)) !!}
                                </div>
                                <hr class="my-3">
                                <small class="text-muted">
                                    <i class="fas fa-info-circle me-1"></i>
                                    {{ strlen($testimony->content) }} characters •
                                    {{ str_word_count($testimony->content) }} words
                                </small>
                            </div>
                        </div>

                        <!-- Review History -->
                        @if($testimony->reviewed_at || $testimony->admin_feedback)
                            <div class="mb-4">
                                <h6 class="text-muted mb-2">Review History</h6>
                                <div class="border rounded p-3 bg-light">
                                    @if($testimony->reviewed_at)
                                        <p class="mb-1">
                                            <strong>Last Reviewed:</strong> {{ $testimony->reviewed_at->format('M j, Y g:i A') }}
                                        </p>
                                    @endif
                                    @if($testimony->approved_by_email)
                                        <p class="mb-1">
                                            <strong>Reviewed By:</strong> {{ $testimony->approved_by_email }}
                                        </p>
                                    @endif
                                    @if($testimony->admin_feedback)
                                        <p class="mb-0">
                                            <strong>Previous Feedback:</strong><br>
                                            <em>{{ $testimony->admin_feedback }}</em>
                                        </p>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Action Panel -->
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0">
                            <i class="fas fa-tasks me-2"></i>Review Actions
                        </h6>
                    </div>
                    <div class="card-body">
                        @if($testimony->status === 'pending')
                            <!-- Approve Button -->
                            <button wire:click="openApproveModal"
                                    class="btn btn-success w-100 mb-3">
                                <i class="fas fa-check me-2"></i>Approve Testimony
                            </button>

                            <!-- Decline Button -->
                            <button wire:click="openDeclineModal"
                                    class="btn btn-danger w-100 mb-3">
                                <i class="fas fa-times me-2"></i>Decline Testimony
                            </button>
                        @else
                            <!-- Status Change Options -->
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>
                                This testimony has been
                                <strong>{{ $testimony->status }}</strong>.
                            </div>

                            <button wire:click="openResetModal"
                                    class="btn btn-warning w-100">
                                <i class="fas fa-undo me-2"></i>Reset to Pending
                            </button>
                        @endif

                        <!-- Additional Info -->
                        <hr>
                        <div class="small text-muted">
                            <p class="mb-1">
                                <i class="fas fa-user-shield me-1"></i>
                                Logged in as: {{ auth()->user()->email ?? 'admin@wci.org' }}
                            </p>
                            <p class="mb-0">
                                <i class="fas fa-clock me-1"></i>
                                Current time: {{ now()->format('M j, Y g:i A') }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Permission Notice -->
                <div class="card mt-3">
                    <div class="card-body">
                        <h6 class="text-success mb-2">
                            <i class="fas fa-check-circle me-2"></i>Publication Permission
                        </h6>
                        <p class="small text-muted mb-0">
                            The author has granted permission for this testimony to be published on the church website and used for ministry purposes.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Approve Confirmation Modal -->
    @if($showApproveModal)
        <div class="modal fade show d-block admin-modal-backdrop" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="fas fa-check text-success me-2"></i>Approve Testimony
                        </h5>
                        <button type="button" wire:click="closeModals" class="btn-close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-success">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Confirm Approval</strong>
                        </div>
                        <p>Are you sure you want to approve this testimony?</p>
                        <ul class="list-unstyled">
                            <li><i class="fas fa-check text-success me-2"></i>It will be published on the website</li>
                            <li><i class="fas fa-envelope text-primary me-2"></i>The author will be notified via email</li>
                            <li><i class="fas fa-eye text-info me-2"></i>It will be visible to all website visitors</li>
                        </ul>
                        <div class="border rounded p-3 bg-light">
                            <strong>Testimony:</strong> "{{ $testimony->title }}"<br>
                            <strong>Author:</strong> {{ $testimony->author }}
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" wire:click="closeModals" class="btn btn-secondary">
                            Cancel
                        </button>
                        <button type="button" wire:click="approveTestimony" class="btn btn-success">
                            <i class="fas fa-check me-2"></i>Yes, Approve Testimony
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Decline Confirmation Modal -->
    @if($showDeclineModal)
        <div class="modal fade show d-block admin-modal-backdrop" tabindex="-1">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="fas fa-times text-danger me-2"></i>Decline Testimony
                        </h5>
                        <button type="button" wire:click="closeModals" class="btn-close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <strong>Declining Testimony</strong>
                        </div>
                        <p>You are about to decline this testimony. Please provide constructive feedback that will be sent to the author.</p>

                        <div class="border rounded p-3 bg-light mb-3">
                            <strong>Testimony:</strong> "{{ $testimony->title }}"<br>
                            <strong>Author:</strong> {{ $testimony->author }}<br>
                            <strong>Email:</strong> {{ $testimony->email }}
                        </div>

                        <div class="mb-3">
                            <label for="adminFeedback" class="form-label fw-semibold">
                                Feedback for Author <span class="text-danger">*</span>
                            </label>
                            <textarea wire:model="adminFeedback"
                                      class="form-control @error('adminFeedback') is-invalid @enderror"
                                      id="adminFeedback"
                                      rows="4"
                                      placeholder="Please provide constructive feedback about why this testimony cannot be approved. This will be sent to the author via email."></textarea>
                            @error('adminFeedback')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" wire:click="closeModals" class="btn btn-secondary">
                            Cancel
                        </button>
                        <button type="button" wire:click="declineTestimony" class="btn btn-danger">
                            <i class="fas fa-times me-2"></i>Decline & Send Feedback
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Reset Confirmation Modal -->
    @if($showResetModal)
        <div class="modal fade show d-block admin-modal-backdrop" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="fas fa-undo text-warning me-2"></i>Reset to Pending
                        </h5>
                        <button type="button" wire:click="closeModals" class="btn-close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Reset Status</strong>
                        </div>
                        <p>Are you sure you want to reset this testimony status back to pending?</p>
                        <ul class="list-unstyled">
                            <li><i class="fas fa-clock text-warning me-2"></i>Status will be changed to "Pending"</li>
                            <li><i class="fas fa-eye-slash text-muted me-2"></i>It will no longer be published (if it was approved)</li>
                            <li><i class="fas fa-redo text-info me-2"></i>It will need to be reviewed again</li>
                        </ul>
                        <div class="border rounded p-3 bg-light">
                            <strong>Current Status:</strong> <span class="badge bg-{{ $testimony->status === 'approved' ? 'success' : 'danger' }}">{{ ucfirst($testimony->status) }}</span><br>
                            <strong>Testimony:</strong> "{{ $testimony->title }}"<br>
                            <strong>Author:</strong> {{ $testimony->author }}
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" wire:click="closeModals" class="btn btn-secondary">
                            Cancel
                        </button>
                        <button type="button" wire:click="resetToPending" class="btn btn-warning">
                            <i class="fas fa-undo me-2"></i>Reset to Pending
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
