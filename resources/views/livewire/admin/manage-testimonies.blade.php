<div>
    <div class="container-fluid py-4">
        <!-- Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h3 mb-1">Manage Testimonies</h1>
                        <p class="text-muted mb-0">Review, approve, or decline submitted testimonies</p>
                    </div>
                    <div class="text-end">
                        <div class="small text-muted">
                            <i class="fas fa-clock me-1"></i>
                            Last updated: {{ now()->format('M j, Y g:i A') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label for="statusFilter" class="form-label fw-semibold">Status Filter</label>
                                <select wire:model.live="statusFilter" class="form-select" id="statusFilter">
                                    <option value="all">All Statuses</option>
                                    <option value="pending">Pending Review</option>
                                    <option value="approved">Approved</option>
                                    <option value="declined">Declined</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="categoryFilter" class="form-label fw-semibold">Category Filter</label>
                                <select wire:model.live="categoryFilter" class="form-select" id="categoryFilter">
                                    <option value="all">All Categories</option>
                                    @foreach($this->resultCategories as $key => $category)
                                        <option value="{{ $key }}">{{ $category }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="engagementFilter" class="form-label fw-semibold">Engagement Filter</label>
                                <select wire:model.live="engagementFilter" class="form-select" id="engagementFilter">
                                    <option value="all">All Engagements</option>
                                    @foreach($this->engagementTypes as $key => $engagement)
                                        <option value="{{ $key }}">{{ $engagement }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="searchTerm" class="form-label fw-semibold">Search</label>
                                <input type="text"
                                       wire:model.live.debounce.300ms="searchTerm"
                                       class="form-control"
                                       id="searchTerm"
                                       placeholder="Search title, author, or content...">
                            </div>
                        </div>
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

        <!-- Testimonies Table -->
        <div class="row">
            <div class="col-12">

                        <h5 class="card-title mb-0">
                            <i class="fas fa-microphone me-2"></i>
                            Testimonies
                            <span class="badge bg-secondary ms-2">{{ $testimonies->total() }} total</span>
                        </h5>

                        @if($testimonies->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="col-4">Title & Author</th>
                                            <th class="col-1">Category</th>
                                            <th class="col-4">Engagements</th>
                                            <th class="col-1">Status</th>
                                            <th class="col-1">Submitted</th>
                                            <th class="col-1">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($testimonies as $testimony)
                                            <tr>
                                                <td>
                                                    <div>
                                                        <h6 class="mb-1">{{ $testimony->title }}</h6>
                                                        <small class="text-muted">
                                                            - {{ $testimony->author }}
                                                            {{-- <br>
                                                            <i class="fas fa-envelope me-1"></i>{{ $testimony->email }} --}}
                                                        </small>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="badge bg-info">{{ $testimony->result_category }}</span>
                                                </td>
                                                <td>
                                                    @if($testimony->engagements && count($testimony->engagements) > 0)
                                                        <div class="d-flex flex-wrap gap-1">
                                                            @foreach($testimony->engagements as $engagement)
                                                                <span class="badge bg-secondary small">{{ $engagement }}</span>
                                                            @endforeach
                                                        </div>
                                                    @else
                                                        <span class="text-muted small">None specified</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($testimony->status === 'pending')
                                                        <span class="badge text-bg-warning">
                                                            <i class="fas fa-clock me-1"></i><small>Pending</small>
                                                        </span>
                                                    @elseif($testimony->status === 'approved')
                                                        <span class="badge text-bg-success">
                                                            <i class="fas fa-check me-1"></i><small>Approved</small>
                                                        </span>
                                                    @else
                                                        <span class="badge text-bg-danger">
                                                            <i class="fas fa-times me-1"></i><small>Declined</small>
                                                        </span>
                                                    @endif

                                                    @if($testimony->reviewed_at)
                                                        <br>
                                                        <small class="text-muted small">
                                                            {{ $testimony->reviewed_at->format('M j, Y') }}
                                                        </small>
                                                    @endif
                                                </td>
                                                <td>
                                                    <small class="text-muted">
                                                        {{ $testimony->created_at->format('M j, Y g:i A') }}
                                                    </small>
                                                </td>
                                                <td>
                                                    <!-- View Button -->
                                                    <a href="{{ route('admin.testimonies.view', $testimony->id) }}"
                                                        class="btn btn-sm btn-primary-custom">
                                                        <i class="fas fa-folder-open me-1"></i><small>Details</small>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            <div class="card-footer">
                                {{ $testimonies->links() }}
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-inbox text-muted" style="font-size: 3rem;"></i>
                                <h5 class="text-muted mt-3">No testimonies found</h5>
                                <p class="text-muted">No testimonies match your current filters.</p>
                            </div>
                        @endif

                </div>
            </div>
        </div>
    </div>
</div>
