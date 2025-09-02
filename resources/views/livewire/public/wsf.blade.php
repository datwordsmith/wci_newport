<div>
        <!-- WSF Introduction -->
        <section class="py-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-10">
                        <div class="card shadow-sm border-0 mb-5">
                            <div class="card-body p-md-5 p-4">
                                <p class="lead fw-semibold mb-4">The Winners Satellite Fellowship (WSF) is set to create a forum for a caring fellowship where every member of the Church is adequately cared for.</p>

                                <p>After the order of the 1st century New Testament church, the WSF is out to care, feed and nourish the members.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Results Section -->
                <div class="row justify-content-center">
                    <div class="col-md-10">
                        <div class="card shadow bg-light border-0">
                            <div class="card-body p-md-5 p-4">
                                <h2 class="serif-font text-center mb-4">What to Expect</h2>
                                <p class="mb-4 text-center">The WSF brings Jesus to your doorstep with the following results:</p>

                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <div class="d-flex mb-3">
                                            <div class="me-3 primary-color">
                                                <i class="fas fa-star fa-2x"></i>
                                            </div>
                                            <div>
                                                <h5 class="fw-semibold">Undeniable Signs and Wonders</h5>
                                                <p>Experience the supernatural move of God in your life and circumstances.</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="d-flex mb-3">
                                            <div class="me-3 primary-color">
                                                <i class="fas fa-exchange-alt fa-2x"></i>
                                            </div>
                                            <div>
                                                <h5 class="fw-semibold">Life-Changing Experiences</h5>
                                                <p>Encounter transformative moments that reshape your spiritual journey.</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="d-flex mb-3">
                                            <div class="me-3 primary-color">
                                                <i class="fas fa-hands-helping fa-2x"></i>
                                            </div>
                                            <div>
                                                <h5 class="fw-semibold">Christian Care and Loving Interactions</h5>
                                                <p>Be part of a community that genuinely cares for one another in love.</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="d-flex mb-3">
                                            <div class="me-3 primary-color">
                                                <i class="fas fa-lightbulb fa-2x"></i>
                                            </div>
                                            <div>
                                                <h5 class="fw-semibold">Destiny Moulding Teaching</h5>
                                                <p>Receive instruction that shapes your purpose in a non-denominational environment.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- WSF Locations -->
        <section class="py-5 bg-light">
            <div class="container">
                <div class="row justify-content-center mb-4">
                    <div class="col-md-8 text-center">
                        <h2 class="serif-font mb-3">Find a Fellowship Near You</h2>
                        <p class="mb-4">Connect with one of our Winners Satellite Fellowship locations across Newport and surrounding areas.</p>
                    </div>
                </div>

                <!-- Search and Filter -->
                <div class="row justify-content-center mb-4">
                    <div class="col-md-8">
                        <div class="card shadow-sm">
                            <div class="card-body p-3">
                                <div class="row g-3 align-items-end">
                                    <div class="col-md-9 col-10">
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                                            <input type="text"
                                                   wire:model.live="search"
                                                   class="form-control"
                                                   placeholder="Search by name, address, postcode, or area..."
                                                   value="{{ $search }}">
                                        </div>
                                    </div>

                                    <div class="col-md-3 col-2">
                                        @if($search)
                                            <button wire:click="clearFilters" class="btn btn-outline-secondary">
                                                <i class="fas fa-times"></i> <span class="d-none d-md-inline">Clear</span>
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- WSF Locations List -->
                <div class="row justify-content-center">
                    <div class="col-md-10">
                        <div class="row g-3" id="wsfLocationsList">
                            @if($wsfs && $wsfs->count() > 0)
                                @foreach($wsfs as $wsf)
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
                                                <div class="mt-3 text-end">
                                                    <a href="https://maps.google.com/?q={{ urlencode($wsf->address) }}"
                                                        target="_blank" rel="noopener" class="btn btn-sm btn-primary-custom">
                                                        <i class="fas fa-directions me-1"></i>Get Directions
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="col-md-12">
                                    <div class="alert alert-danger text-center">
                                        <h5>No locations found</h5>
                                        @if($search)
                                            <p>No results match your search term: "{{ $search }}"</p>
                                            <button wire:click="clearFilters" class="btn btn-outline-primary">
                                                Clear Search and Show All
                                            </button>
                                        @else
                                            <p>No WSF locations are currently available.</p>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Pagination -->
                        @if($wsfs->hasPages())
                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <div class="text-muted">
                                Showing {{ $wsfs->firstItem() ?? 0 }} to {{ $wsfs->lastItem() ?? 0 }} of {{ $wsfs->total() }} results
                                @if($search)
                                    for "{{ $search }}"
                                @endif
                            </div>
                            <div>
                                {{ $wsfs->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>

        <!-- Contact CTA -->
        <section class="py-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 text-center">
                        <h3 class="serif-font mb-3">Want to Start a New Fellowship?</h3>
                        <p class="mb-4">Interested in hosting a Winners Satellite Fellowship in your area? We'd love to help you get started.</p>
                        <a href="{{ route('contact') }}" class="btn btn-lg btn-primary-custom">Contact Us</a>
                    </div>
                </div>
            </div>
        </section>
</div>
