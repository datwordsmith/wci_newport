@section('page-header')
@endsection

@section('title', 'Winners Satellite Fellowship')
@section('subtitle', 'Bringing Jesus to your doorstep through fellowship and prayer')

<div>
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="h4 mb-1">WSF</h2>
            <p class="text-muted mb-0">Managing the Winners Satellite Fellowship</p>
        </div>
        <div>
            <button wire:click="create()" class="btn btn-primary-custom">
                <i class="fas fa-plus"></i> <span class="d-none d-md-inline">Add WSF</span>
            </button>
        </div>
    </div>


    <!-- Search and Filters -->
    <div class="row mb-4">
        <div class="col-md-4 col-12 mb-2">
            <div class="input-group">
                <span class="input-group-text"><i class="fas fa-search"></i></span>
                <input type="text" wire:model.live="search" class="form-control" placeholder="Search events...">
            </div>
        </div>

        <div class="col-md-3 col-2">
            @if($search)
                <button wire:click="clearFilters" class="btn btn-outline-secondary me-2">
                    <i class="fas fa-times"></i> <span class="d-none d-md-inline">Clear Search</span>
                </button>
            @endif
        </div>
    </div>

    <!-- WSF Grid -->
    <div class="row g-3">
        @forelse($wsfs as $wsf)
            <div class="col-12 col-md-4">
                <div class="card h-100 wsf-location-card">
                    <div class="card-body">
                        <h5 class="card-title d-flex align-items-center">
                            <i class="fas fa-users me-2" style="color: var(--primary-color);"></i>
                            {{ $wsf->name }}
                        </h5>
                        <div class="card-text">
                            <div class="d-flex mb-2">
                                <i class="fas fa-map-marker-alt text-muted me-2 mt-1"></i>
                                <small class="text-muted">{{ $wsf->address }}</small>
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <i class="fas fa-tag text-muted me-2"></i>
                                <span class="badge bg-light text-dark border">{{ $wsf->area }}</span>
                            </div>
                        </div>
                        <div class="mt-3">
                            <a href="https://maps.google.com/?q={{ urlencode($wsf->address) }}"
                                target="_blank" rel="noopener" class="btn btn-sm btn-primary-custom">
                                <i class="fas fa-directions me-1"></i>Get Directions
                            </a>
                        </div>
                        <!-- Action Buttons -->
                        <div class="position-absolute top-0 end-0 p-2">
                            <div class="btn-group-vertical" role="group">
                                <button wire:click="edit({{ $wsf->id }})"
                                        class="btn btn-sm btn-outline-light bg-white bg-opacity-75 mb-1"
                                        title="Edit WSF">
                                    <i class="fas fa-edit text-primary"></i>
                                </button>
                                <button wire:click="confirmDelete({{ $wsf->id }})"
                                        class="btn btn-sm btn-outline-light bg-white bg-opacity-75"
                                        title="Delete WSF">
                                    <i class="fas fa-trash text-danger"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
        <div class="col-12">
            <div class="text-center py-5">
                <div class="text-muted">
                    <i class="fas fa-users fa-4x mb-4 text-muted"></i>
                    <h4>No WSF Found</h4>
                    <p class="mb-4">
                        @if($search)
                            No WSF match your search criteria. Try adjusting your search terms.
                        @else
                            You haven't created any WSF yet. Create your first one!
                        @endif
                    </p>
                    @if(!$search)
                        <button wire:click="create()" class="btn btn-primary-custom">
                            <i class="fas fa-plus me-2"></i>Add Your First WSF
                        </button>
                    @endif
                </div>
            </div>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($wsfs->hasPages())
    <div class="d-flex justify-content-between align-items-center mt-4">
        <div class="text-muted">
            Showing {{ $wsfs->firstItem() ?? 0 }} to {{ $wsfs->lastItem() ?? 0 }} of {{ $wsfs->total() }} results
        </div>
        <div>
            {{ $wsfs->links('pagination::bootstrap-5') }}
        </div>
    </div>
    @endif


    <!-- Modal -->
    @if($showModal)
    <div class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.6); z-index: 1070;">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ $editMode ? 'Edit' : 'Add New' }} WSF</h5>
                    <button type="button" class="btn-close" wire:click="closeModal()"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="name" class="form-label">WSF Name</label>
                            <input type="text" wire:model="name" class="form-control @error('name') is-invalid @enderror"
                                   id="name" placeholder="Enter WSF name">
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <textarea wire:model="address" class="form-control @error('address') is-invalid @enderror"
                                      id="address" rows="3" placeholder="Enter WSF address"></textarea>
                            @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="postcode" class="form-label">Postcode</label>
                                <input type="text" wire:model="postcode" class="form-control @error('postcode') is-invalid @enderror"
                                       id="postcode" placeholder="Enter WSF postcode">
                                @error('postcode') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="area" class="form-label">Area</label>
                                <input type="text" wire:model="area" class="form-control @error('area') is-invalid @enderror"
                                       id="area" placeholder="Enter WSF area">
                                @error('area') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" wire:click="closeModal()">Cancel</button>
                    <button type="button" class="btn btn-primary-custom" wire:click="store()">
                        <span wire:loading.remove>{{ $editMode ? 'Update' : 'Save' }} WSF</span>
                        <span wire:loading>
                            <span class="spinner-border spinner-border-sm me-2" role="status"></span>
                            {{ $editMode ? 'Updating...' : 'Saving...' }}
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Delete Confirmation Modal -->
    @if($isDeleteModalOpen && $wsfToDelete)
    <div class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.6); z-index: 1080;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <div class="text-center w-100">
                        <div class="mx-auto mb-3 d-flex align-items-center justify-content-center"
                             style="width: 60px; height: 60px; background: linear-gradient(135deg, #dc3545, #c82333); border-radius: 50%;">
                            <i class="fas fa-exclamation-triangle text-white fa-2x"></i>
                        </div>
                        <h4 class="modal-title text-dark">Delete WSF</h4>
                    </div>
                    <button type="button" class="btn-close position-absolute top-0 end-0 m-3" wire:click="closeDeleteModal()"></button>
                </div>
                <div class="modal-body text-center px-4">
                    <p class="text-muted mb-2">Are you sure you want to delete this WSF?</p>
                    <div class="bg-light rounded p-3 mb-3">
                        <h6 class="mb-1">{{ $wsfToDelete->name }}</h6>
                        <small class="text-muted">
                            {{ $wsfToDelete->address }}
                            {{ $wsfToDelete->postcode }}
                            {{ $wsfToDelete->area }}
                        </small>
                    </div>
                    <p class="text-danger small mb-0">
                        <i class="fas fa-info-circle me-1"></i>
                        This action cannot be undone. The event will be permanently deleted.
                    </p>
                </div>
                <div class="modal-footer border-0 justify-content-center pt-0">
                    <button type="button" class="btn btn-secondary px-4" wire:click="closeDeleteModal()">
                        <i class="fas fa-times me-1"></i>Cancel
                    </button>
                    <button type="button" class="btn btn-danger px-4" wire:click="delete()">
                        <span wire:loading.remove>
                            <i class="fas fa-trash me-1"></i>Delete WSF
                        </span>
                        <span wire:loading>
                            <span class="spinner-border spinner-border-sm me-2" role="status"></span>
                            Deleting...
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

</div>
