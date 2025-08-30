<div>
    @section('description', $description)

    @section('content')

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
                                    <div class="col-md-6">
                                        <label for="locationSearch" class="form-label fw-semibold">Search by location or name</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                                            <input type="text" class="form-control" id="locationSearch" placeholder="e.g. Newport, Grace, Church Road...">
                                            <button class="btn btn-outline-secondary" type="button" id="clearLocationSearch" title="Clear search">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="areaFilter" class="form-label fw-semibold">Filter by area</label>
                                        <select class="form-select" id="areaFilter">
                                            <option value="">All Areas</option>
                                            <option value="Newport">Newport</option>
                                            <option value="Cwmbran">Cwmbran</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="fw-semibold text-muted">
                                            <span id="resultsCount">11</span> locations found
                                        </div>
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
                            <!-- Locations will be populated by JavaScript -->
                        </div>
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

    @endsection
</div>
