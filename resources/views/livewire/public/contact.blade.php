<div>
    @section('description', $description)

    @section('content')

        <!-- Contact Details -->
        <section class="py-5">
            <div class="container">
                <div class="row g-4">
                    <!-- Map + Quick Contacts -->
                    <div class="col-md-6">
                        <!-- Quick contact chips -->
                        <div class="mb-3 contact-chips">
                            <a class="contact-chip" href="https://maps.google.com/?q=Winners+Chapel+International,+Church+Rd,+Newport+NP19+7EJ" target="_blank" rel="noopener">
                                <span class="chip-icon"><i class="fas fa-map-marker-alt"></i></span>
                                Church Rd, Newport NP19 7EJ
                            </a>
                            <a class="contact-chip" href="tel:07901024213">
                                <span class="chip-icon"><i class="fas fa-phone"></i></span>
                                07901 024213
                            </a>
                        </div>
                        <!-- Social icons -->
                        <div class="mb-3 social-round">
                            <a href="#" aria-label="Facebook" target="_blank" rel="noopener"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" aria-label="Twitter" target="_blank" rel="noopener"><i class="fab fa-twitter"></i></a>
                            <a href="#" aria-label="Instagram" target="_blank" rel="noopener"><i class="fab fa-instagram"></i></a>
                        </div>
                        <div class="card shadow-sm">
                            <div class="card-body p-2">
                                <div class="ratio ratio-16x9">
                                    <iframe class="map-iframe" title="Map to Winners Chapel International, Church Rd, Newport" allowfullscreen
                                        src="https://www.google.com/maps?q=Winners+Chapel+International,+Church+Rd%2C+Newport+NP19+7EJ&output=embed"></iframe>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-6">
                        <div class="card shadow-sm">
                            <div class="card-body p-4">
                                <h3 class="serif-font mb-3">Send us a message</h3>
                                <form id="contactForm">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label for="name" class="form-label">Full Name</label>
                                            <input type="text" class="form-control" id="name" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" class="form-control" id="email" placeholder="you@example.com">
                                        </div>
                                        <div class="col-12">
                                            <label for="phone" class="form-label">Phone</label>
                                            <input type="tel" class="form-control" id="phone" placeholder="Optional">
                                        </div>
                                        <div class="col-12">
                                            <label for="message" class="form-label">Message</label>
                                            <textarea id="message" class="form-control" rows="5" required></textarea>
                                        </div>
                                    </div>
                                    <div class="mt-3 d-flex gap-2">
                                        <button type="submit" class="btn btn-primary-custom"><i class="fas fa-paper-plane me-2"></i>Send Email</button>
                                        <button type="reset" class="btn btn-outline-secondary">Clear</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Service Times -->
        <section class="py-5 bg-light">
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
                                <img src="assets/images/sunday.jpg" alt="Sunday Service" class="img-fluid">
                                <div class="program-overlay">
                                    <div class="program-content">
                                        <h4>Sunday Service</h4>
                                        <p class="mb-0">Every Sunday | 10:00AM - 12:00PM</p>
                                        <small>Ty Derwen, Church Road, Newport</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="program-card">
                                <img src="assets/images/chop.jpg" alt="Covenant Hour of Prayer" class="img-fluid">
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
                                <img src="assets/images/kap.jpg" alt="Kingdom Advancement Prayers" class="img-fluid">
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
                                <img src="assets/images/midweek.jpg" alt="Midweek Communion Service" class="img-fluid">
                                <div class="program-overlay">
                                    <div class="program-content">
                                        <h4>Midweek Communion</h4>
                                        <p class="mb-0">Every Wednesday | 6:30PM</p>
                                        <small>Ty Derwen, Church Road, Newport</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="program-card">
                                <img src="assets/images/evangelism.jpg" alt="City Centre Outreach" class="img-fluid">
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
                                <img src="assets/images/winning_foundation.jpg" alt="Winning Foundation Class" class="img-fluid">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Mobile Slider (hidden on desktop) -->
                <div class="programs-slider d-md-none">
                    <div class="programs-track">
                        <div class="program-card">
                            <img src="assets/images/sunday.jpg" alt="Sunday Service" class="img-fluid">
                            <div class="program-overlay">
                                <div class="program-content">
                                    <h4>Sunday Service</h4>
                                    <p class="mb-0">Every Sunday | 10:00AM - 12:00PM</p>
                                    <small>Ty Derwen, Church Road, Newport</small>
                                </div>
                            </div>
                        </div>
                        <div class="program-card">
                            <img src="assets/images/chop.jpg" alt="Covenant Hour of Prayer" class="img-fluid">
                            <div class="program-overlay">
                                <div class="program-content">
                                    <h4>Covenant Hour of Prayer</h4>
                                    <p class="mb-0">Monday-Saturday | 6am-7am</p>
                                    <small>Microsoft Teams</small>
                                </div>
                            </div>
                        </div>
                        <div class="program-card">
                            <img src="assets/images/kap.jpg" alt="Kingdom Advancement Prayers" class="img-fluid">
                            <div class="program-overlay">
                                <div class="program-content">
                                    <h4>Kingdom Advancement Prayers</h4>
                                    <p class="mb-0">Monday-Friday | 7:00PM - 7:45PM</p>
                                    <small>(Except Wednesday)</small>
                                </div>
                            </div>
                        </div>
                        <div class="program-card">
                            <img src="assets/images/midweek.jpg" alt="Midweek Communion Service" class="img-fluid">
                            <div class="program-overlay">
                                <div class="program-content">
                                    <h4>Midweek Communion</h4>
                                    <p class="mb-0">Every Wednesday | 6:30PM</p>
                                    <small>Ty Derwen, Church Road, Newport</small>
                                </div>
                            </div>
                        </div>
                        <div class="program-card">
                            <img src="assets/images/evangelism.jpg" alt="City Centre Outreach" class="img-fluid">
                            <div class="program-overlay">
                                <div class="program-content">
                                    <h4>City Centre Outreach</h4>
                                    <p class="mb-0">Saturdays | 12:00PM - 1:30PM</p>
                                    <small>Commercial St, Kingsway Centre</small>
                                </div>
                            </div>
                        </div>
                        <div class="program-card">
                            <img src="assets/images/winning_foundation.jpg" alt="Winning Foundation Class" class="img-fluid">
                        </div>
                    </div>
                </div>
            </div>
        </section>

    @endsection
</div>
