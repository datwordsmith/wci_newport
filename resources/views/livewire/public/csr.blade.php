<div>
    @section('description', $description)

    @section('content')
        <!-- Main Content -->
        <section class="py-5">
            <div class="container">
                <!-- Introduction -->
                <div class="row mb-5">
                    <div class="col-lg-8 mx-auto text-center">
                        <p class="lead">The Community Development Committee, which is now Corporate Social Responsibility, was formed over 10 years ago as a community development arm of Winners Chapel International UK, to impact our local community as a way of giving back to the communities where our churches are situated in the UK.</p>
                        <p class="lead">Our aim is to support the communities we serve and promote their inspiring stories of change by investing in 5 core areas.</p>
                    </div>
                </div>

                <!-- Our Heritage -->
                <div class="row mb-5">
                    <div class="col-lg-6 mb-4">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="icon-circle me-3">
                                        <i class="fas fa-history"></i>
                                    </div>
                                    <h4 class="mb-0">Our Heritage</h4>
                                </div>
                                <p class="text-muted">Established over 10 years ago as the Community Development Committee, we have evolved into a comprehensive Corporate Social Responsibility initiative, demonstrating our long-term commitment to community development across the UK.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 mb-4">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="icon-circle me-3">
                                        <i class="fas fa-heart"></i>
                                    </div>
                                    <h4 class="mb-0">Our Purpose</h4>
                                </div>
                                <p class="text-muted">As a community development arm of Winners Chapel International UK, we give back to the communities where our churches are situated, supporting local residents and promoting inspiring stories of positive change.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- CSR Programs -->
                <div class="text-center mb-5">
                    <h2 class="serif-font">Our 5 Core Investment Areas</h2>
                    <p class="lead">The key areas where we focus our community development efforts</p>
                </div>
                <div class="row g-4">
                    <!-- Skills Development -->
                    <div class="col-md-4">
                        <div class="value-card pillar-card">
                            <div class="value-icon">
                                <i class="fas fa-graduation-cap"></i>
                            </div>
                            <h4 class="serif-font">Skills Development</h4>
                            <p class="pillar-text">Education, enterprise and employability training programmes to empower individuals with practical skills for sustainable futures.</p>
                        </div>
                    </div>

                    <!-- Food Bank and Poverty Alleviation -->
                    <div class="col-md-4">
                        <div class="value-card pillar-card">
                            <div class="value-icon">
                                <i class="fas fa-utensils"></i>
                            </div>
                            <h4 class="serif-font">Food Bank & Poverty Alleviation</h4>
                            <p class="pillar-text">Addressing food insecurity and supporting families facing financial hardship through practical assistance and resources.</p>
                        </div>
                    </div>

                    <!-- Tackling Homelessness -->
                    <div class="col-md-4">
                        <div class="value-card pillar-card">
                            <div class="value-icon">
                                <i class="fas fa-home"></i>
                            </div>
                            <h4 class="serif-font">Tackling Homelessness</h4>
                            <p class="pillar-text">Supporting homeless individuals and families with shelter, resources, and pathways to stable housing and independent living.</p>
                        </div>
                    </div>

                    <!-- Health, Safety and Environment -->
                    <div class="col-md-6">
                        <div class="value-card pillar-card">
                            <div class="value-icon">
                                <i class="fas fa-leaf"></i>
                            </div>
                            <h4 class="serif-font">Health, Safety & Environment</h4>
                            <p class="pillar-text">Promoting community wellbeing through health initiatives, safety programmes, and environmental stewardship projects.</p>
                        </div>
                    </div>

                    <!-- Collaboration, Inclusion and Diversity -->
                    <div class="col-md-6">
                        <div class="value-card pillar-card">
                            <div class="value-icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <h4 class="serif-font">Collaboration, Inclusion & Diversity</h4>
                            <p class="pillar-text">Building stronger, more inclusive communities through collaborative partnerships and celebrating diversity in all its forms.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Get Involved CTA Section -->
        <section class="join-units-cta">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-lg-8 text-center">
                        <i class="fas fa-hands-helping cta-icon mb-4"></i>
                        <h2 class="serif-font mb-3">Get Involved</h2>
                        <p class="lead mb-4">Join us in making a positive impact in our community. Whether through volunteering, donations, or partnerships, your contribution matters.</p>
                        <div class="row g-3 justify-content-center">
                            <div class="col-md-4">
                                <a href="{{ route('contact') }}" class="btn btn-primary-custom btn-md w-100 py-2">
                                    <i class="fas fa-hands-helping me-2"></i>Volunteer
                                </a>
                            </div>
                            <div class="col-md-4">
                                <a href="{{ route('giving') }}" class="btn btn-secondary btn-md w-100 py-2">
                                    <i class="fas fa-heart me-2"></i>Donate
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endsection

    @push('styles')

        <style>
            .icon-circle {
                width: 60px;
                height: 60px;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 24px;
            }

            .impact-stat h2 {
                font-size: 3rem;
                font-weight: bold;
            }

            .card {
                transition: transform 0.2s ease-in-out;
            }

            .card:hover {
                transform: translateY(-5px);
            }
        </style>

    @endpush

</div>


