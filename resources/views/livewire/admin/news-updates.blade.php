@section('page-header')
@endsection

@section('title', 'News & Updates')
@section('subtitle', 'Publish church news, letters, and announcements')

<div>
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="h4 mb-1">News &amp; Updates</h2>
            <p class="text-muted mb-0">Manage blog-style posts and official announcements</p>
        </div>
        <div>
            <a href="{{ route('admin.news_updates.create') }}" class="btn btn-primary-custom">
                <i class="fas fa-plus"></i> <span class="d-none d-md-inline">Add News Item</span>
            </a>
        </div>
    </div>

    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Filters -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Search</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                        <input type="text" wire:model.live="search" class="form-control" placeholder="Search title or content...">
                    </div>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Status</label>
                    <select class="form-select" wire:model.live="statusFilter">
                        <option value="all">All</option>
                        <option value="draft">Draft</option>
                        <option value="published">Published</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Type</label>
                    <select class="form-select" wire:model.live="is_featured_filter">
                        <option value="all">All</option>
                        <option value="featured">Featured</option>
                        <option value="regular">Regular</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- News List -->
    <div class="row">
        @forelse($newsItems as $item)
            <div class="col-lg-6 mb-4">
                <div class="card h-100">
                    <div class="card-body d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div>
                                <h5 class="card-title mb-1">{{ $item->title }}</h5>
                                <div class="small text-muted">
                                    @if($item->published_at)
                                        <i class="fas fa-calendar-alt me-1"></i>
                                        {{ $item->published_at->format('M j, Y g:i A') }}
                                    @else
                                        <span class="text-muted fst-italic">Not yet scheduled</span>
                                    @endif
                                </div>
                                @if($item->source)
                                    <div class="small text-muted mt-1">
                                        <i class="fas fa-building me-1"></i>{{ $item->source }}
                                    </div>
                                @endif
                            </div>
                            <div class="text-end">
                                @if($item->status === 'published')
                                    <span class="badge bg-success mb-1">
                                        <i class="fas fa-check me-1"></i>Published
                                    </span>
                                @else
                                    <span class="badge bg-secondary mb-1">
                                        <i class="fas fa-pencil-alt me-1"></i>Draft
                                    </span>
                                @endif

                                @if($item->is_featured)
                                    <div>
                                        <span class="badge bg-warning text-dark">
                                            <i class="fas fa-star me-1"></i>Featured
                                        </span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        @if($item->excerpt)
                            <p class="card-text text-muted small mb-2">{{ Str::limit($item->excerpt, 160) }}</p>
                        @else
                            <p class="card-text text-muted small mb-2">{{ Str::limit(strip_tags($item->body), 160) }}</p>
                        @endif

                        @if($item->attachment_path)
                            <div class="mb-2 small">
                                <i class="fas fa-paperclip me-1 text-muted"></i>
                                <a href="{{ asset('storage/' . $item->attachment_path) }}" target="_blank">
                                    {{ $item->attachment_original_name ?? 'Download attachment' }}
                                </a>
                            </div>
                        @endif

                        <div class="mt-auto d-flex justify-content-between align-items-center pt-2 border-top">
                            <small class="text-muted">
                                <i class="fas fa-user me-1"></i>
                                {{ $item->author_name ?: ($item->created_by ?: 'Unknown') }}
                            </small>
                            <div class="btn-group btn-group-sm" role="group">
                                <a href="{{ route('admin.news_updates.edit', $item->id) }}"
                                   class="btn btn-outline-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button class="btn btn-outline-danger" wire:click="confirmDelete({{ $item->id }})">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="fas fa-newspaper fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">No news items found</h5>
                    <p class="text-muted mb-3">Create your first announcement or blog-style post.</p>
                    <a href="{{ route('admin.news_updates.create') }}" class="btn btn-primary-custom">
                        <i class="fas fa-plus me-2"></i>Add News Item
                    </a>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($newsItems->hasPages())
        <div class="d-flex justify-content-between align-items-center mt-3">
            <div class="text-muted small">
                Showing {{ $newsItems->firstItem() ?? 0 }} to {{ $newsItems->lastItem() ?? 0 }} of {{ $newsItems->total() }} results
            </div>
            <div>
                {{ $newsItems->links('pagination::bootstrap-5') }}
            </div>
        </div>
    @endif

    <!-- Delete Confirmation Modal -->
    @if($showDeleteModal && $newsToDelete)
        <div class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.6); z-index: 1070;">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-danger">
                            <i class="fas fa-exclamation-triangle me-2"></i>Delete News Item
                        </h5>
                        <button type="button" class="btn-close" wire:click="cancelDelete"></button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to permanently delete:</p>
                        <p class="fw-semibold">{{ $newsToDelete->title }}</p>
                        @if($newsToDelete->attachment_path)
                            <p class="small text-muted mb-0">
                                <i class="fas fa-info-circle me-1"></i>The attached file will also be removed from storage.
                            </p>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="cancelDelete">Cancel</button>
                        <button type="button" class="btn btn-danger" wire:click="delete">
                            <i class="fas fa-trash me-1"></i>Delete
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
