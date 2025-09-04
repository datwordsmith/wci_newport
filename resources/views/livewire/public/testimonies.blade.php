<div>
    @section('description', $description)

    <!-- Testimonies Section -->
    <section class="testimonies-list-section py-5">
        <div class="container">
            <div class="mb-4">
                <div class="d-flex justify-content-end">
                    <a href="{{ route('testimonies.create') }}" class="btn btn-primary-custom">
                        <i class="fas fa-microphone me-2"></i>Share Your Testimony
                    </a>
                </div>

                <!-- Filter Controls -->
                <div class="filter-controls mt-3 mb-3">
                    <div class="row g-3 align-items-end">
                        <div class="col-md-4">
                            <label for="resultFilter" class="form-label fw-semibold small">Filter by Result</label>
                            <select id="resultFilter" class="form-select" wire:model.live="resultFilter">
                                <option value="all">All Results</option>
                                @foreach($this->resultCategories as $key => $label)
                                    <option value="{{ $key }}">{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="engagementFilter" class="form-label fw-semibold small">Filter by Engagement</label>
                            <select id="engagementFilter" class="form-select" wire:model.live="engagementFilter">
                                <option value="all">All Engagements</option>
                                @foreach($this->engagementTypes as $key => $label)
                                    <option value="{{ $key }}">{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button id="clearFilters" class="btn btn-outline-secondary w-100" type="button" wire:click="clearFilters">
                                <i class="fas fa-times me-1"></i>Clear Filters
                            </button>
                        </div>
                    </div>
                </div>

                <div class="search-toolbar">
                    <div class="input-group">
                        <span class="input-group-text bg-white"><i class="fas fa-search"></i></span>
                        <input id="testimonySearch" type="search" class="form-control" placeholder="Search testimonies..." aria-label="Search testimonies" wire:model.live="searchTerm" value="{{ $searchTerm }}">
                        @if($searchTerm)
                            <button id="clearSearch" class="btn btn-outline-secondary" type="button" wire:click="$set('searchTerm','')">
                                <i class="fas fa-times"></i> Clear
                            </button>
                        @endif
                    </div>
                </div>
            </div>

            @if(isset($testimonies) && $testimonies->count())
                <div class="row g-4" id="testimoniesList">
                    @foreach($testimonies as $t)
                        <div class="col-md-6 col-lg-4">
                            <div class="card h-100 shadow-sm">
                                <div class="card-body d-flex flex-column">
                                    <div class="mb-2 d-flex align-items-center gap-2">
                                        <span class="badge bg-success">{{ $t->result_category }}</span>
                                    </div>
                                    <h5 class="card-title mb-1">{{ $t->title }}</h5>
                                    <p class="text-muted small mb-3">by {{ $t->author }}</p>
                                    <p class="card-text" style="white-space: pre-line">{{ \Illuminate\Support\Str::limit($t->content, 220) }}</p>
                                    @if($t->engagements && count($t->engagements))
                                        <div class="mt-auto">
                                            <div class="d-flex flex-wrap gap-1">
                                                @foreach($t->engagements as $e)
                                                    <span class="badge bg-secondary small">{{ $e }}</span>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <div class="card-footer bg-white d-flex justify-content-between align-items-center">
                                    <small class="text-muted">
                                        {{ optional($t->reviewed_at ?? $t->created_at)->format('M j, Y') }}
                                    </small>
                                    <div class="">
                                        <button type="button" class="btn btn-sm btn-outline-secondary"
                                                onclick="shareTestimony('{{ addslashes($t->title) }}')">
                                            <i class="fas fa-share-alt"></i> Share
                                        </button>

                                        <a href="{{ route('testimony', $t->id) }}" class="btn btn-sm btn-primary-custom">
                                            <i class="fas fa-eye"></i> View
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-4">
                    @if($testimonies->hasPages())
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="text-muted">
                                Showing {{ $testimonies->firstItem() ?? 0 }} to {{ $testimonies->lastItem() ?? 0 }} of {{ $testimonies->total() }} results
                                @if($searchTerm)
                                    for "{{ $searchTerm }}"
                                @endif
                                @if($resultFilter !== 'all')
                                    filtered by {{ $resultFilter }}
                                @endif
                                @if($engagementFilter !== 'all')
                                    with {{ $engagementFilter }}
                                @endif
                            </div>
                            <div>
                                {{ $testimonies->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                    @endif
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-inbox text-muted" style="font-size: 3rem;"></i>
                    <h5 class="text-muted mt-3">No testimonies found</h5>
                    @if($searchTerm || $resultFilter !== 'all' || $engagementFilter !== 'all')
                        <p class="text-muted">No testimonies match your current filters.</p>
                        <button wire:click="clearFilters" class="btn btn-outline-primary">
                            Clear Filters and Show All
                        </button>
                    @else
                        <p class="text-muted">Be the first to share how God has blessed you.</p>
                    @endif
                </div>
            @endif
        </div>
    </section>

    @include('livewire.public.modals.add-testimony')

    <!-- View Testimony Modal -->
    <div class="modal fade" id="viewTestimonyModal" tabindex="-1" aria-labelledby="viewTestimonyModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewTestimonyModalLabel">Testimony</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h5 id="testimony-title" class="mb-2"></h5>
                    <p class="text-muted small mb-3">by <span id="testimony-author"></span></p>
                    <div id="testimony-content"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <a href="{{ route('testimonies.create') }}" class="btn btn-primary">
                        <i class="fas fa-microphone me-1"></i> Share Your Testimony
                    </a>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('livewire:initialized', () => {
                // Scroll to testimonies list after pagination or filter updates
                Livewire.on('testimonies-updated', () => {
                    const testimoniesList = document.getElementById('testimoniesList');
                    if (testimoniesList) {
                        testimoniesList.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });

            // View testimony in modal
            function viewTestimony(id, title, author) {
                // Set modal content
                document.getElementById('testimony-title').textContent = title;
                document.getElementById('testimony-author').textContent = author;

                // Fetch testimony content via AJAX or use Livewire call
                // For now showing placeholder - this should be replaced with actual content
                document.getElementById('testimony-content').textContent = 'Loading testimony content...';

                // Show modal
                const modal = new bootstrap.Modal(document.getElementById('viewTestimonyModal'));
                modal.show();

                // You can add AJAX call here to load full testimony content
                // fetch('/api/testimonies/' + id)
                //   .then(response => response.json())
                //   .then(data => {
                //     document.getElementById('testimony-content').innerHTML = data.content;
                //   });
            }

            // Share testimony
            function shareTestimony(title) {
                // Check if Web Share API is supported
                if (navigator.share) {
                    navigator.share({
                        title: title,
                        text: 'Check out this amazing testimony: ' + title,
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
                    alert('URL copied to clipboard! You can now share this page with others.');
                }
            }
        </script>
    @endpush
</div>
