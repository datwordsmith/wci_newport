<div>
    @section('description', $description)

    @section('content')

    <!-- Testimonies Section -->
    <section class="testimonies-list-section py-5">
        <div class="container">
            <div class="mb-4">
                <div class="d-flex justify-content-end">
                    <button type="button" class="btn btn-primary-custom" data-bs-toggle="modal" data-bs-target="#addTestimonyModal">
                        <i class="fas fa-microphone me-2"></i>Share Your Testimony
                    </button>
                </div>

                <!-- Filter Controls -->
                <div class="filter-controls mt-3 mb-3">
                    <div class="row g-3 align-items-end">
                        <div class="col-md-4">
                            <label for="resultFilter" class="form-label fw-semibold small">Filter by Result</label>
                            <select id="resultFilter" class="form-select">
                                <option value="">All Results</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="engagementFilter" class="form-label fw-semibold small">Filter by Engagement</label>
                            <select id="engagementFilter" class="form-select">
                                <option value="">All Engagements</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button id="clearFilters" class="btn btn-outline-secondary w-100" type="button">
                                <i class="fas fa-times me-1"></i>Clear Filters
                            </button>
                        </div>
                    </div>
                </div>

                <div class="search-toolbar">
                    <div class="input-group">
                        <span class="input-group-text bg-white"><i class="fas fa-search"></i></span>
                        <input id="testimonySearch" type="search" class="form-control" placeholder="Search testimonies..." aria-label="Search testimonies">
                        <button id="clearSearch" class="btn btn-outline-secondary" type="button">Clear</button>
                    </div>
                </div>
            </div>

            <div id="testimonyList" class="row g-4"></div>

            <nav class="mt-4" aria-label="Testimonies pagination">
                <ul id="testimonyPagination" class="pagination justify-content-center mb-0"></ul>
            </nav>
        </div>
    </section>

    @include('livewire.public.modals.add-testimony')

    @endsection

    @push('scripts')

    @endpush
</div>
