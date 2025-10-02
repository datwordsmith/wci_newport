@section('page-header')
@endsection

@section('title', 'Event Management')
@section('subtitle', 'Create and manage church events')

<div>
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="h4 mb-1">Events</h2>
            <p class="text-muted mb-0">Manage your church events and activities</p>
        </div>
        <div>
            <button wire:click="create()" class="btn btn-primary-custom">
                <i class="fas fa-plus"></i> <span class="d-none d-md-inline">Add Event</span>
            </button>
        </div>
    </div>

    <!-- Search and Filters -->
    <div class="row mb-3">
        <div class="col-md-4 col-12 mb-2">
            <div class="input-group">
                <span class="input-group-text"><i class="fas fa-search"></i></span>
                <input type="text" wire:model.live="search" class="form-control" placeholder="Search events...">
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
            @if($search || $filterMonth || $filterYear || $showUpcomingOnly)
                <button wire:click="clearFilters" class="btn btn-outline-secondary me-2">
                    <i class="fas fa-times"></i> <span class="d-none d-md-inline">Clear Filters</span>
                </button>
            @endif
        </div>
    </div>

    <!-- Additional Filters -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" wire:model.live="showUpcomingOnly" id="upcomingOnly">
                <label class="form-check-label" for="upcomingOnly">
                    <i class="fas fa-calendar-alt me-1"></i>
                    Show upcoming events only
                </label>
            </div>
        </div>
    </div>

    <!-- Events Grid -->
    <div class="row">
        @forelse($events as $event)
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card h-100 shadow-sm">
                <!-- Event Header -->
                <div class="position-relative">
                    @if($event->poster)
                        <img src="{{ asset('storage/' . $event->poster) }}"
                            alt="Event Poster" class="card-img-top" style="height: 200px; object-fit: cover;">
                    @else
                        <div class="card-img-top d-flex align-items-center justify-content-center"
                             style="height: 200px; background: linear-gradient(45deg, #3498db, #2c3e50);">
                            <div class="text-white text-center p-3">
                                <div class="fw-bold mb-2" style="font-size: 18px;">
                                    {{ Str::limit($event->title, 30) }}
                                </div>
                                <div class="small">
                                    <div class="mb-1">
                                        <i class="fas fa-calendar me-1"></i>
                                        {{ $event->getFormattedDate() }}
                                    </div>
                                    <div class="mb-1">
                                        <i class="fas fa-clock me-1"></i>
                                        {{ $event->getTimeRange() }}
                                    </div>
                                    @if($event->location)
                                    <div>
                                        <i class="fas fa-map-marker-alt me-1"></i>
                                        {{ Str::limit($event->location, 25) }}
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Action Buttons -->
                    <div class="position-absolute top-0 end-0 p-2">
                        <div class="btn-group-vertical" role="group">
                            <button wire:click="edit({{ $event->id }})"
                                    class="btn btn-sm btn-outline-light bg-white bg-opacity-75 mb-1"
                                    title="Edit Event">
                                <i class="fas fa-edit text-primary"></i>
                            </button>
                            <button wire:click="duplicate({{ $event->id }})"
                                    class="btn btn-sm btn-outline-light bg-white bg-opacity-75 mb-1"
                                    title="Duplicate Event">
                                <i class="fas fa-copy text-secondary"></i>
                            </button>
                            @if($event->isRecurringMaster())
                            <button wire:click="regenerateRecurringInstances({{ $event->id }})"
                                    class="btn btn-sm btn-outline-light bg-white bg-opacity-75 mb-1"
                                    title="Regenerate Recurring Instances">
                                <i class="fas fa-redo text-success"></i>
                            </button>
                            @endif
                            <button wire:click="confirmDelete({{ $event->id }})"
                                    class="btn btn-sm btn-outline-light bg-white bg-opacity-75"
                                    title="Delete Event">
                                <i class="fas fa-trash text-danger"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Card Body -->
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h5 class="card-title mb-0">{{ $event->title }}</h5>
                        @if($event->isRecurring())
                            <div class="ms-2">
                                @if($event->isRecurringMaster())
                                    <span class="badge bg-success text-white" style="font-size: 0.7em;">
                                        <i class="fas fa-redo me-1"></i>{{ $event->getRecurringDescription() }}
                                    </span>
                                @elseif($event->isRecurringInstance())
                                    <span class="badge bg-info text-white" style="font-size: 0.7em;">
                                        <i class="fas fa-link me-1"></i>{{ $event->getRecurringDescription() }}
                                    </span>
                                @endif
                            </div>
                        @endif
                    </div>

                    @if($event->description)
                    <p class="card-text text-muted small mb-2">{{ Str::limit($event->description, 100) }}</p>
                    @endif

                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div class="text-muted small">
                            <i class="fas fa-calendar me-1"></i>
                            {{ $event->getFormattedDate() }}
                        </div>
                        <span class="badge bg-primary">
                            <i class="fas fa-clock me-1"></i>
                            {{ $event->getTimeRange() }}
                        </span>
                    </div>

                    @if($event->location)
                    <div class="text-muted small mb-2">
                        <i class="fas fa-map-marker-alt me-1"></i>
                        {{ $event->location }}
                    </div>
                    @endif

                    @if($event->event_url)
                    <div class="text-muted small mb-2">
                        <i class="fas fa-link me-1"></i>
                        <a href="{{ $event->event_url }}" target="_blank" class="text-decoration-none">
                            Join Online Event
                        </a>
                    </div>
                    @endif

                    <div class="text-muted small">
                        <i class="fas fa-user me-1"></i>
                        {{ $event->created_by ?? 'Unknown' }}
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="text-center py-5">
                <div class="text-muted">
                    <i class="fas fa-calendar-check fa-4x mb-4 text-muted"></i>
                    <h4>No Events Found</h4>
                    <p class="mb-4">
                        @if($search)
                            No events match your search criteria. Try adjusting your search terms.
                        @else
                            You haven't created any events yet. Create your first one!
                        @endif
                    </p>
                    @if(!$search)
                        <button wire:click="create()" class="btn btn-primary-custom">
                            <i class="fas fa-plus me-2"></i>Add Your First Event
                        </button>
                    @endif
                </div>
            </div>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($events->hasPages())
    <div class="d-flex justify-content-between align-items-center mt-4">
        <div class="text-muted">
            Showing {{ $events->firstItem() ?? 0 }} to {{ $events->lastItem() ?? 0 }} of {{ $events->total() }} results
        </div>
        <div>
            {{ $events->links('pagination::bootstrap-5') }}
        </div>
    </div>
    @endif

    <!-- Modal -->
    @if($showModal)
    <div class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.6); z-index: 1070;">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ $editMode ? 'Edit' : 'Add New' }} Event</h5>
                    <button type="button" class="btn-close" wire:click="closeModal()"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="title" class="form-label">Event Title</label>
                            <input type="text" wire:model="title" class="form-control @error('title') is-invalid @enderror"
                                   id="title" placeholder="Enter event title">
                            @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea wire:model="description" class="form-control @error('description') is-invalid @enderror"
                                      id="description" rows="3" placeholder="Enter event description (optional)"></textarea>
                            @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="poster" class="form-label">Event Poster</label>
                            <input type="file" wire:model="poster" class="form-control @error('poster') is-invalid @enderror"
                                id="poster" accept="image/png,image/jpeg,image/jpg">
                            @error('poster') <div class="invalid-feedback">{{ $message }}</div> @enderror

                            @if(!$editMode)
                                <small class="text-muted">Upload a poster image (PNG or JPEG, Max: 2MB) - Optional.</small>
                            @else
                                <small class="text-muted">Upload a new poster to replace the existing one (PNG or JPEG, Max: 2MB) - Optional.</small>
                            @endif

                            <!-- Image Preview -->
                            @if ($poster)
                                <div class="mt-2">
                                    <p class="mb-1"><strong>New Poster Preview:</strong></p>
                                    <img src="{{ $poster->temporaryUrl() }}" alt="Preview" class="img-thumbnail" style="max-width: 200px;">
                                </div>
                            @elseif ($current_poster && $editMode)
                                <div class="mt-2">
                                    <p class="mb-1"><strong>Current Poster:</strong></p>
                                    <img src="{{ asset('storage/' . $current_poster) }}" alt="Current Poster" class="img-thumbnail" style="max-width: 200px;">
                                </div>
                            @endif
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="event_date" class="form-label">Start Date</label>
                                <input type="date" wire:model="event_date" class="form-control @error('event_date') is-invalid @enderror" id="event_date">
                                @error('event_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="end_date" class="form-label">End Date (Optional)</label>
                                <input type="date" wire:model="end_date" class="form-control @error('end_date') is-invalid @enderror" id="end_date">
                                @error('end_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                <small class="text-muted">Leave empty for single-day events</small>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="location" class="form-label">Location</label>
                                <input type="text" wire:model="location" class="form-control @error('location') is-invalid @enderror"
                                       id="location" placeholder="Enter event location">
                                @error('location') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="event_url" class="form-label">Event URL (Optional)</label>
                                <input type="url" wire:model="event_url" class="form-control @error('event_url') is-invalid @enderror"
                                       id="event_url" placeholder="https://zoom.us/j/123456789 or Teams link">
                                @error('event_url') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                <small class="text-muted">
                                    <i class="fas fa-compress-alt me-1"></i>
                                    For online events. Long URLs will be automatically shortened.
                                </small>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="start_time" class="form-label">Start Time</label>
                                <input type="time" wire:model="start_time" class="form-control @error('start_time') is-invalid @enderror" id="start_time">
                                @error('start_time') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="end_time" class="form-label">End Time (Optional)</label>
                                <input type="time" wire:model="end_time" class="form-control @error('end_time') is-invalid @enderror" id="end_time">
                                @error('end_time') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                <small class="text-muted">Leave empty if end time is not specified</small>
                            </div>
                        </div>

                        <hr class="my-4">
                        <h6 class="mb-3"><i class="fas fa-redo me-2"></i>Repeat</h6>
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" role="switch" id="repeat_monthly" wire:model="repeat_monthly">
                            <label class="form-check-label" for="repeat_monthly">Repeat monthly (single day)</label>
                        </div>

                        <div class="row" x-data="{ get repeatMonthly() { return $wire.repeat_monthly } }">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Week of month</label>
                                <select class="form-select @error('repeat_week_of_month') is-invalid @enderror" wire:model="repeat_week_of_month" :disabled="!repeatMonthly">
                                    <option value="">Select...</option>
                                    <option value="1">First</option>
                                    <option value="2">Second</option>
                                    <option value="3">Third</option>
                                    <option value="4">Fourth</option>
                                    <option value="-1">Last</option>
                                </select>
                                @error('repeat_week_of_month') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Day of week</label>
                                <select class="form-select @error('repeat_day_of_week') is-invalid @enderror" wire:model="repeat_day_of_week" :disabled="!repeatMonthly">
                                    <option value="">Select...</option>
                                    <option value="0">Sunday</option>
                                    <option value="1">Monday</option>
                                    <option value="2">Tuesday</option>
                                    <option value="3">Wednesday</option>
                                    <option value="4">Thursday</option>
                                    <option value="5">Friday</option>
                                    <option value="6">Saturday</option>
                                </select>
                                @error('repeat_day_of_week') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Repeat until</label>
                                <input type="date" class="form-control @error('repeat_until') is-invalid @enderror" wire:model="repeat_until" :disabled="!repeatMonthly">
                                @error('repeat_until') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-12">
                                <small class="text-muted">When enabled, this will create single-day events on the chosen week/day of each month until the date provided. The first instance is this event's date.</small>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" wire:click="closeModal()">Cancel</button>
                    <button type="button" class="btn btn-primary-custom" wire:click="store()">
                        <span wire:loading.remove>{{ $editMode ? 'Update' : 'Save' }} Event</span>
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
    @if($isDeleteModalOpen && $eventToDelete)
    <div class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.6); z-index: 1080;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <div class="text-center w-100">
                        <div class="mx-auto mb-3 d-flex align-items-center justify-content-center"
                             style="width: 60px; height: 60px; background: linear-gradient(135deg, #dc3545, #c82333); border-radius: 50%;">
                            <i class="fas fa-exclamation-triangle text-white fa-2x"></i>
                        </div>
                        <h4 class="modal-title text-dark">Delete Event</h4>
                    </div>
                    <button type="button" class="btn-close position-absolute top-0 end-0 m-3" wire:click="closeDeleteModal()"></button>
                </div>
                <div class="modal-body text-center px-4">
                    <p class="text-muted mb-2">Are you sure you want to delete this event?</p>
                    <div class="bg-light rounded p-3 mb-3">
                        <h6 class="mb-1">{{ $eventToDelete->title }}</h6>
                        <small class="text-muted">
                            <i class="fas fa-calendar me-1"></i>
                            {{ $eventToDelete->getFormattedDate() }}
                            <i class="fas fa-clock ms-2 me-1"></i>
                            {{ $eventToDelete->getTimeRange() }}
                            @if($eventToDelete->location)
                            <br><i class="fas fa-map-marker-alt me-1"></i>
                            {{ $eventToDelete->location }}
                            @endif
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
                            <i class="fas fa-trash me-1"></i>Delete Event
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Function to update end date minimum
    function updateEndDateMin() {
        const startDateInput = document.getElementById('event_date');
        const endDateInput = document.getElementById('end_date');

        if (startDateInput && endDateInput) {
            const startDate = startDateInput.value;
            if (startDate) {
                endDateInput.min = startDate;

                // If end date is before start date, clear it
                if (endDateInput.value && endDateInput.value < startDate) {
                    endDateInput.value = '';
                    // Also clear Livewire property
                    @this.set('end_date', '');
                }
            } else {
                endDateInput.removeAttribute('min');
            }
        }
    }

    // Listen for changes on start date
    document.addEventListener('change', function(e) {
        if (e.target && e.target.id === 'event_date') {
            updateEndDateMin();
        }
    });

    // Also listen for Livewire updates
    document.addEventListener('livewire:updated', function() {
        updateEndDateMin();
    });

    // Initial setup
    updateEndDateMin();
});
</script>
