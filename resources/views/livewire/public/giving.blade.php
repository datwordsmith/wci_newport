<div>
    @section('description', $description)

    @section('content')
        <!-- Hero Section -->
        <section class="giving-hero py-5">
            <div class="container">
                <div class="row justify-content-center text-center">
                    <div class="col-md-8">
                        <h1 class="serif-font mb-4">Ways to Give</h1>
                        <p class="text-muted">Your giving supports the advancement of God's kingdom and the liberation of mankind through the preaching of the Word of Faith.</p>
                    </div>

                    <div class="col-12 mt-5">
                        <div class="row g-3">
                            <div class="col-md-3 col-sm-6">
                                <div class="giving-type-card text-center">
                                    <i class="fas fa-gift fa-2x text-primary-custom mb-3"></i>
                                    <h6>Offerings</h6>
                                    <p class="small text-muted">Freewill offerings to support the church</p>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="giving-type-card text-center">
                                    <i class="fas fa-percentage fa-2x text-primary-custom mb-3"></i>
                                    <h6>Tithes</h6>
                                    <p class="small text-muted">"And all the tithe of the land... is the Lord's: it is holy unto the Lord." - Leviticus 27:30</p>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="giving-type-card text-center">
                                    <i class="fas fa-bus fa-2x text-primary-custom mb-3"></i>
                                    <h6>Transport Chariot</h6>
                                    <p class="small text-muted">Support for church transportation needs</p>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="giving-type-card text-center">
                                    <i class="fas fa-seedling fa-2x text-primary-custom mb-3"></i>
                                    <h6>Kingdom Care Seed</h6>
                                    <p class="small text-muted">Special seeds for ministry advancement</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Giving Methods Section -->
        <section class="giving-methods py-5">
            <div class="container">
                <div class="row g-4">
                    <!-- Cash Offering -->
                    <div class="col-md-4">
                        <div class="giving-card text-center h-100">
                            <div class="giving-icon mb-4">
                                <i class="fas fa-hand-holding-usd fa-3x text-primary-custom"></i>
                            </div>
                            <h3 class="h4 mb-3">Cash Using Offering Envelope</h3>
                            <p class="text-muted">Bring your offering during any of our services using the provided offering envelope. Mark the purpose clearly on the envelope.</p>
                        </div>
                    </div>

                    <!-- QR Code Giving -->
                    <div class="col-md-4">
                        <div class="giving-card text-center h-100">
                            <div class="giving-header mb-4">
                                <div class="scan-badge">
                                    <span class="badge bg-warning text-dark px-3 py-2 rounded-pill">
                                        <i class="fas fa-qrcode me-2"></i>SCAN ME!
                                    </span>
                                </div>
                            </div>
                            <div class="qr-codes mb-3">
                                <div class="row g-2 justify-content-center">
                                    <div class="col-6">
                                        <div class="qr-code-container">
                                            <div class="qr-placeholder bg-light border rounded p-3" style="height: 120px; display: flex; align-items: center; justify-content: center;">
                                                <small class="text-muted">QR Code<br>Android</small>
                                            </div>
                                            <small class="d-block mt-2 text-muted">Xcel App - Android</small>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="qr-code-container">
                                            <div class="qr-placeholder bg-light border rounded p-3" style="height: 120px; display: flex; align-items: center; justify-content: center;">
                                                <small class="text-muted">QR Code<br>iOS</small>
                                            </div>
                                            <small class="d-block mt-2 text-muted">Xcel App - iOS</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <p class="text-muted small mb-3">Download the Xcel App and scan the QR code to give quickly and securely.</p>

                            <!-- App Store Buttons -->
                            <div class="app-store-buttons">
                                <div class="row g-2 justify-content-center">
                                    <div class="col-6">
                                        <a href="https://play.google.com/store/apps/details?id=com.xcelapp.prod&hl=en_GB" target="_blank" class="app-store-btn">
                                            <img src="https://upload.wikimedia.org/wikipedia/commons/7/78/Google_Play_Store_badge_EN.svg" alt="Get it on Google Play" style="height: 40px; width: auto;">
                                        </a>
                                    </div>
                                    <div class="col-6">
                                        <a href="#" class="app-store-btn">
                                            <img src="https://upload.wikimedia.org/wikipedia/commons/3/3c/Download_on_the_App_Store_Badge.svg" alt="Download on the App Store" style="height: 40px; width: auto;">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Online Giving -->
                    <div class="col-md-4">
                        <div class="giving-card text-center h-100">
                            <div class="giving-icon mb-4">
                                <i class="fas fa-globe fa-3x text-primary-custom"></i>
                            </div>
                            <h3 class="h4 mb-3">
                                <span class="badge bg-warning text-dark rounded-pill px-3 py-2 mb-2">
                                    <i class="fas fa-laptop me-1"></i>ONLINE
                                </span>
                            </h3>
                            <div class="mb-3">
                                <p class="mb-2"><strong>Visit the link:</strong></p>
                                <a href="https://giving.winners-chapel.org.uk" target="_blank" class="btn btn-outline-primary-custom mb-2">
                                    giving.winners-chapel.org.uk
                                </a>
                                <p class="small text-muted">Select church location<br><strong>(WCI NEWPORT)</strong></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Text Giving Section -->
                <div class="row mt-5">
                    <div class="col-12">
                        <div class="giving-card text-center py-4">
                            <div class="mb-4">
                                <span class="badge bg-primary-custom text-white rounded-pill px-4 py-3 h5 mb-0">
                                    <i class="fas fa-mobile-alt me-2"></i>TEXT
                                </span>
                            </div>
                            <h3 class="h4 mb-3">Text Giving</h3>
                            <div class="row justify-content-center">
                                <div class="col-md-8">
                                    <p class="mb-3">Text the word <strong class="text-primary-custom">"GIVE"</strong> to <strong class="text-primary-custom">01382250496</strong></p>
                                    <p class="text-muted small">(WCI NEWPORT) and follow the instruction</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bank Transfer Section -->
                <div class="row mt-5">
                    <div class="col-12">
                        <div class="bank-transfer-card">
                            <div class="text-center mb-4">
                                <h3 class="h4 mb-3">Bank Transfer Details</h3>
                                <p class="text-muted">For direct bank transfers and standing orders</p>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-md-8">
                                    <div class="bank-details bg-light rounded p-4">
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <div class="detail-item">
                                                    <label class="fw-bold text-muted small">ACCOUNT NAME:</label>
                                                    <p class="mb-0">WORLD MISSION AGENCY - WINNERS CHAPEL INTERNATIONAL</p>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="detail-item">
                                                    <label class="fw-bold text-muted small">SORT CODE:</label>
                                                    <p class="mb-0 h5 text-primary-custom">40-02-17</p>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="detail-item">
                                                    <label class="fw-bold text-muted small">ACCOUNT NUMBER:</label>
                                                    <p class="mb-0 h5 text-primary-custom">41638009</p>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="detail-item">
                                                    <label class="fw-bold text-muted small">REFERENCE:</label>
                                                    <p class="mb-0">GIVING TYPE LOCATION (E.G OFFERING/NEWPORT)</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Scripture Section -->
                <div class="row mt-5">
                    <div class="col-12">
                        <div class="scripture-card text-center">
                            <div class="scripture-icon mb-3">
                                <i class="fas fa-quote-left fa-2x text-primary-custom"></i>
                            </div>
                            <blockquote class="blockquote mb-0">
                                <p class="mb-3 h5 text-muted">"Bring all the tithes into the storehouse, that there may be food in My house, and try Me now in this," says the Lord of hosts, "If I will not open for you the windows of heaven and pour out for you such blessing that there will not be room enough to receive it."</p>
                                <footer class="blockquote-footer text-primary-custom">
                                    <cite title="Source Title">Malachi 3:10</cite>
                                </footer>
                            </blockquote>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endsection

    @push('styles')
    <style>
        .giving-hero {
            background: linear-gradient(135deg, rgba(44, 62, 80, 0.1), rgba(44, 62, 80, 0.05));
            margin-top: 80px;
        }

        .giving-card {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: 1px solid #eee;
        }

        .giving-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        }

        .giving-type-card {
            background: white;
            border-radius: 10px;
            padding: 1.5rem;
            box-shadow: 0 3px 15px rgba(0,0,0,0.08);
            transition: transform 0.3s ease;
            border: 1px solid #f0f0f0;
        }

        .giving-type-card:hover {
            transform: translateY(-3px);
        }

        .bank-transfer-card {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            border: 1px solid #eee;
        }

        .bank-details {
            border: 2px solid var(--primary-color);
        }

        .detail-item label {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .scripture-card {
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
            border-radius: 15px;
            padding: 3rem 2rem;
            border-left: 5px solid var(--primary-color);
        }

        .scan-badge {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }

        .qr-placeholder {
            border: 2px dashed #dee2e6;
        }

        .app-store-buttons {
            margin-top: 15px;
        }

        .app-store-btn {
            display: block;
            transition: transform 0.2s ease;
        }

        .app-store-btn:hover {
            transform: scale(1.05);
        }

        .app-store-btn img {
            max-width: 100%;
            height: auto;
        }

        .btn-outline-primary-custom {
            border-color: var(--primary-color);
            color: var(--primary-color);
        }

        .btn-outline-primary-custom:hover {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
        }

        .bg-primary-custom {
            background-color: var(--primary-color) !important;
        }

        .text-primary-custom {
            color: var(--primary-color) !important;
        }
    </style>
    @endpush
</div>
