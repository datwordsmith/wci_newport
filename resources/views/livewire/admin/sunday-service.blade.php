@section('page-header')
@endsection

@section('title', 'Sunday Service Management')
@section('subtitle', 'Create and manage Sunday service content')

<div>
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="h4 mb-1">Sunday Services</h2>
            <p class="text-muted mb-0">Manage your weekly Sunday service content</p>
        </div>
        <div>
            <button wire:click="create()" class="btn btn-primary-custom">
                <i class="fas fa-plus"></i> <span class="d-none d-md-inline">Add Service</span>
            </button>
        </div>
    </div>

    <!-- Search and Filters -->
    <div class="row mb-4">
        <div class="col-md-4 col-12 mb-2">
            <div class="input-group">
                <span class="input-group-text"><i class="fas fa-search"></i></span>
                <input type="text" wire:model.live="search" class="form-control" placeholder="Search services...">
            </div>
        </div>

        <div class="col-md-3 col-6">
            <select wire:model.live="filterMonth" class="form-select">
                <option value="">All Months</option>
                <option value="1">January</option>
                <option value="2">February</option>
                <option value="3">March</option>
                <option value="4">April</option>
                <option value="5">May</option>
                <option value="6">June</option>
                <option value="7">July</option>
                <option value="8">August</option>
                <option value="9">September</option>
                <option value="10">October</option>
                <option value="11">November</option>
                <option value="12">December</option>
            </select>
        </div>

        <div class="col-md-2 col-4">
            <select wire:model.live="filterYear" class="form-select">
                <option value="">All Years</option>
                @for($year = date('Y') + 1; $year >= date('Y') - 5; $year--)
                    <option value="{{ $year }}">{{ $year }}</option>
                @endfor
            </select>
        </div>

        <div class="col-md-3 col-2">
            @if($search || $filterMonth || $filterYear)
                <button wire:click="clearFilters" class="btn btn-outline-secondary me-2">
                    <i class="fas fa-times"></i> <span class="d-none d-md-inline">Clear Filters</span>
                </button>
            @endif
        </div>
    </div>

    <!-- Services Grid -->
    <div class="row">
        @forelse($services as $service)
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card h-100 shadow-sm">
                <!-- Poster -->
                <div class="position-relative">
                    @if($service->sunday_poster)
                        <img src="{{ asset('storage/' . $service->sunday_poster) }}"
                            alt="Service Poster" class="card-img-top" style="height: 200px; object-fit: cover;">
                    @else
                        <div class="card-img-top d-flex align-items-center justify-content-center"
                             style="height: 200px; background: linear-gradient(45deg, #e74c3c, #2c3e50);">
                            <div class="text-white text-center p-3">
                                <div class="fw-bold mb-1" style="font-size: 14px; text-transform: uppercase;">
                                    {{ Str::limit($service->sunday_theme) }}
                                </div>
                                <div style="small">
                                    <div>
                                        {{ \Carbon\Carbon::parse($service->service_date)->format('M d, Y') }}
                                    </div>
                                    <div class="mt-2">
                                        {{ \Carbon\Carbon::parse($service->service_time)->format('h:i A') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Action Buttons -->
                    <div class="position-absolute top-0 end-0 p-2">
                        <div class="btn-group-vertical" role="group">
                            <button wire:click="edit({{ $service->id }})"
                                    class="btn btn-sm btn-outline-light bg-white bg-opacity-75 mb-1"
                                    title="Edit Service">
                                <i class="fas fa-edit text-primary"></i>
                            </button>
                            <button wire:click="confirmDelete({{ $service->id }})"
                                    class="btn btn-sm btn-outline-light bg-white bg-opacity-75"
                                    title="Delete Service">
                                <i class="fas fa-trash text-danger"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Card Body -->
                <div class="card-body">
                    <h5 class="card-title mb-2">{{ $service->sunday_theme }}</h5>

                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div class="text-muted small">
                            <i class="fas fa-calendar me-1"></i>
                            {{ \Carbon\Carbon::parse($service->service_date)->format('M d, Y') }}
                        </div>
                        <span class="badge bg-primary">
                            <i class="fas fa-clock me-1"></i>
                            {{ \Carbon\Carbon::parse($service->service_time)->format('h:i A') }}
                        </span>
                    </div>

                    <div class="text-muted small">
                        <i class="fas fa-user me-1"></i>
                        {{ $service->user_email ?? 'Unknown' }}
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="text-center py-5">
                <div class="text-muted">
                    <i class="fas fa-calendar-alt fa-4x mb-4 text-muted"></i>
                    <h4>No Services Found</h4>
                    <p class="mb-4">
                        @if($search)
                            No services match your search criteria. Try adjusting your search terms.
                        @else
                            You haven't created any Sunday services yet. Create your first one!
                        @endif
                    </p>
                    @if(!$search)
                        <button wire:click="create()" class="btn btn-primary-custom">
                            <i class="fas fa-plus me-2"></i>Add Your First Service
                        </button>
                    @endif
                </div>
            </div>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($services->hasPages())
    <div class="d-flex justify-content-between align-items-center mt-4">
        <div class="text-muted">
            Showing {{ $services->firstItem() ?? 0 }} to {{ $services->lastItem() ?? 0 }} of {{ $services->total() }} results
        </div>
        <div>
            {{ $services->links('pagination::bootstrap-5') }}
        </div>
    </div>
    @endif

    <!-- Modal -->
    @if($isModalOpen)
    <div class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.6); z-index: 1070;">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ $service_id ? 'Edit' : 'Add New' }} Sunday Service</h5>
                    <button type="button" class="btn-close" wire:click="closeModal()"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="service_date" class="form-label">Service Date</label>
                                <input type="date" wire:model="service_date" class="form-control @error('service_date') is-invalid @enderror" id="service_date">
                                @error('service_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="service_time" class="form-label">Service Time</label>
                                <input type="time" wire:model="service_time" step="1800" class="form-control @error('service_time') is-invalid @enderror" id="service_time">

                                @error('service_time') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="sunday_theme" class="form-label">Sunday Theme</label>
                            <input type="text" wire:model="sunday_theme" class="form-control @error('sunday_theme') is-invalid @enderror"
                                   id="sunday_theme" placeholder="Enter service theme">
                            @error('sunday_theme') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="sunday_poster" class="form-label">Service Poster</label>
                            <input type="file" wire:model="sunday_poster" class="form-control @error('sunday_poster') is-invalid @enderror"
                                id="sunday_poster" accept="image/png,image/jpeg,image/jpg">
                            @error('sunday_poster') <div class="invalid-feedback">{{ $message }}</div> @enderror

                            @if(!$service_id)
                                <small class="text-muted">Please upload a poster image (PNG or JPEG, Max: 2MB).</small>
                            @else
                                <small class="text-muted">Upload a new poster to replace the existing one (PNG or JPEG, Max: 2MB).</small>
                            @endif

                            <!-- Image Preview -->
                            @if ($sunday_poster)
                                <div class="mt-2">
                                    <p class="mb-1"><strong>New Poster Preview:</strong></p>
                                    <img src="{{ $sunday_poster->temporaryUrl() }}" alt="Preview" class="img-thumbnail" style="max-width: 200px;">
                                </div>
                            @elseif ($current_poster && $service_id)
                                <div class="mt-2">
                                    <p class="mb-1"><strong>Current Poster:</strong></p>
                                    <img src="{{ asset('storage/' . $current_poster) }}" alt="Current Poster" class="img-thumbnail" style="max-width: 200px;">
                                </div>
                            @endif
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" wire:click="closeModal()">Cancel</button>
                    <button type="button" class="btn btn-primary-custom" wire:click="{{ $service_id ? 'update()' : 'store()' }}">
                        <span wire:loading.remove>{{ $service_id ? 'Update' : 'Save' }} Service</span>
                        <span wire:loading>
                            <span class="spinner-border spinner-border-sm me-2" role="status"></span>
                            {{ $service_id ? 'Updating...' : 'Saving...' }}
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Delete Confirmation Modal -->
    @if($isDeleteModalOpen && $serviceToDelete)
    <div class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.6); z-index: 1080;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <div class="text-center w-100">
                        <div class="mx-auto mb-3 d-flex align-items-center justify-content-center"
                             style="width: 60px; height: 60px; background: linear-gradient(135deg, #dc3545, #c82333); border-radius: 50%;">
                            <i class="fas fa-exclamation-triangle text-white fa-2x"></i>
                        </div>
                        <h4 class="modal-title text-dark">Delete Service</h4>
                    </div>
                    <button type="button" class="btn-close position-absolute top-0 end-0 m-3" wire:click="closeDeleteModal()"></button>
                </div>
                <div class="modal-body text-center px-4">
                    <p class="text-muted mb-2">Are you sure you want to delete this service?</p>
                    <div class="bg-light rounded p-3 mb-3">
                        <h6 class="mb-1">{{ $serviceToDelete->sunday_theme }}</h6>
                        <small class="text-muted">
                            <i class="fas fa-calendar me-1"></i>
                            {{ \Carbon\Carbon::parse($serviceToDelete->service_date)->format('M d, Y') }}
                            <i class="fas fa-clock ms-2 me-1"></i>
                            {{ \Carbon\Carbon::parse($serviceToDelete->service_time)->format('h:i A') }}
                        </small>
                    </div>
                    <p class="text-danger small mb-0">
                        <i class="fas fa-info-circle me-1"></i>
                        This action cannot be undone. The service and its poster will be permanently deleted.
                    </p>
                </div>
                <div class="modal-footer border-0 justify-content-center pt-0">
                    <button type="button" class="btn btn-secondary px-4" wire:click="closeDeleteModal()">
                        <i class="fas fa-times me-1"></i>Cancel
                    </button>
                    <button type="button" class="btn btn-danger px-4" wire:click="delete()">
                        <span wire:loading.remove>
                            <i class="fas fa-trash me-1"></i>Delete Service
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
