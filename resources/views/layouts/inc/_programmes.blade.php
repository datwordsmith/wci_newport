    <section class="programs-section py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="serif-font">Our Programmes</h2>
                <p class="lead">Join us for these special programmes and activities</p>
            </div>
            <!-- Desktop Grid (hidden on mobile) -->
            <div class="programs-grid d-none d-md-block">
                <div class="row g-2">
                    <div class="col-lg-4 col-md-6">
                        <div class="program-card">
                            @if($nextSundayService && $nextSundayService->sunday_poster)
                                <img src="{{ asset('storage/' . $nextSundayService->sunday_poster) }}" alt="Sunday Service" class="img-fluid">
                            @elseif($nextSundayService)
                                <div class="img-fluid d-flex align-items-center justify-content-center sunday-service-placeholder">
                                    <div class="text-white text-center p-3">
                                        <h5 class="mb-3 fw-bold">{{ $nextSundayService->sunday_theme }}</h5>
                                        <p class="mb-2">{{ \Carbon\Carbon::parse($nextSundayService->service_date)->format('M d, Y') }}</p>
                                        <p class="fw-bold">{{ \Carbon\Carbon::parse($nextSundayService->service_time)->format('h:i A') }}</p>
                                    </div>
                                </div>
                            @else
                                <div class="img-fluid d-flex align-items-center justify-content-center sunday-service-placeholder">
                                    <div class="program-overlay">
                                        <div class="program-content">
                                            <h4>Sunday Service</h4>
                                            <p class="mb-0">Every Sunday | 10:00AM - 12:00PM</p>
                                            <small>Winners Chapel Int'l, Church Road, Newport</small>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="program-card">
                            <img src="{{ asset('assets/images/chop.jpg') }}" alt="Covenant Hour of Prayer" class="img-fluid">
                            <div class="program-overlay">
                                <div class="program-content">
                                    <h4>Covenant Hour of Prayer</h4>
                                    <p class="mb-0">Monday-Saturday | 6am-7am</p>
                                    <small>Microsoft Teams</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="program-card">
                            <img src="{{ asset('assets/images/kap.jpg') }}" alt="Kingdom Advancement Prayers" class="img-fluid">
                            <div class="program-overlay">
                                <div class="program-content">
                                    <h4>Kingdom Advancement Prayers</h4>
                                    <p class="mb-0">Monday-Friday | 7:00PM - 7:45PM</p>
                                    <small>(Except Wednesday)</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="program-card">
                            <img src="{{ asset('assets/images/midweek.jpg') }}" alt="Midweek Communion Service" class="img-fluid">
                            <div class="program-overlay">
                                <div class="program-content">
                                    <h4>Midweek Communion</h4>
                                    <p class="mb-0">Every Wednesday | 6:30PM</p>
                                    <small>Winners Chapel Int'l, Church Road, Newport</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="program-card">
                            <img src="{{ asset('assets/images/evangelism.jpg') }}" alt="City Centre Outreach" class="img-fluid">
                            <div class="program-overlay">
                                <div class="program-content">
                                    <h4>City Centre Outreach</h4>
                                    <p class="mb-0">Saturdays | 12:00PM - 1:30PM</p>
                                    <small>Commercial St, Kingsway Centre</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="program-card">
                            <img src="{{ asset('assets/images/winning_foundation.jpg') }}" alt="Winning Foundation Class" class="img-fluid">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Mobile Slider (hidden on desktop) -->
            <div class="programs-slider d-md-none">
                <div class="programs-track">
                    <div class="program-card">
                        @if($nextSundayService && $nextSundayService->sunday_poster)
                            <img src="{{ asset('storage/' . $nextSundayService->sunday_poster) }}" alt="Sunday Service" class="img-fluid">
                        @elseif($nextSundayService)
                            <div class="img-fluid d-flex align-items-center justify-content-center sunday-service-placeholder">
                                <div class="text-white text-center p-3">
                                    <h4 class="fw-bold mb-3 text-uppercase">{{ Str::limit($nextSundayService->sunday_theme, 25) }}</h4>
                                    <p class="mb-2 fs-5">{{ \Carbon\Carbon::parse($nextSundayService->service_date)->format('M d, Y') }}</p>
                                    <p class="mb-3 fs-5">{{ \Carbon\Carbon::parse($nextSundayService->service_time)->format('h:i A') }}</p>
                                    <small>Winners Chapel Int'l<br>Church Road, Newport</small>
                                </div>
                            </div>
                        @else
                            <div class="img-fluid d-flex align-items-center justify-content-center sunday-service-placeholder">
                                <div class="program-overlay">
                                    <div class="program-content">
                                        <h4>Sunday Service</h4>
                                        <p class="mb-0">Every Sunday | 10:00AM - 12:00PM</p>
                                        <small>Winners Chapel Int'l, Church Road, Newport</small>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="program-card">
                        <img src="{{ asset('assets/images/chop.jpg') }}" alt="Covenant Hour of Prayer" class="img-fluid">
                        <div class="program-overlay">
                            <div class="program-content">
                                <h4>Covenant Hour of Prayer</h4>
                                <p class="mb-0">Monday-Saturday | 6am-7am</p>
                                <small>Microsoft Teams</small>
                            </div>
                        </div>
                    </div>
                    <div class="program-card">
                        <img src="{{ asset('assets/images/kap.jpg') }}" alt="Kingdom Advancement Prayers" class="img-fluid">
                        <div class="program-overlay">
                            <div class="program-content">
                                <h4>Kingdom Advancement Prayers</h4>
                                <p class="mb-0">Monday-Friday | 7:00PM - 7:45PM</p>
                                <small>(Except Wednesday)</small>
                            </div>
                        </div>
                    </div>
                    <div class="program-card">
                        <img src="{{ asset('assets/images/midweek.jpg') }}" alt="Midweek Communion Service" class="img-fluid">
                        <div class="program-overlay">
                            <div class="program-content">
                                <h4>Midweek Communion</h4>
                                <p class="mb-0">Every Wednesday | 6:30PM</p>
                                <small>Winners Chapel Int'l, Church Road, Newport</small>
                            </div>
                        </div>
                    </div>
                    <div class="program-card">
                        <img src="{{ asset('assets/images/evangelism.jpg') }}" alt="City Centre Outreach" class="img-fluid">
                        <div class="program-overlay">
                            <div class="program-content">
                                <h4>City Centre Outreach</h4>
                                <p class="mb-0">Saturdays | 12:00PM - 1:30PM</p>
                                <small>Commercial St, Kingsway Centre</small>
                            </div>
                        </div>
                    </div>
                    <div class="program-card">
                        <img src="{{ asset('assets/images/winning_foundation.jpg') }}" alt="Winning Foundation Class" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
    </section>
