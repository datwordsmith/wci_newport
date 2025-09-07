<div>
    <div class="container-fluid py-4">
        <div class="row mb-4">
            <div class="col-12 d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-1">Dashboard</h1>
                    <p class="text-muted mb-0">Overview of testimonies and administration</p>
                </div>
                <div>
                    <a href="{{ route('admin.testimonies.manage') }}" class="btn btn-sm btn-primary-custom">
                        <i class="fas fa-tasks me-1"></i> Review Pending
                    </a>
                </div>
            </div>
        </div>

        <!-- KPI Cards -->
        <div class="row g-3 mb-4">
            <div class="col-6 col-md-3">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="text-muted small">Total Testimonies</div>
                                <div class="h4 mb-0">{{ $stats['total'] }}</div>
                            </div>
                            <div class="text-primary-custom"><i class="fas fa-book-open fa-lg"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="text-muted small">Approved</div>
                                <div class="h4 mb-0">{{ $stats['approved'] }}</div>
                            </div>
                            <div class="text-success"><i class="fas fa-check-circle fa-lg"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="text-muted small">Pending</div>
                                <div class="h4 mb-0">{{ $stats['pending'] }}</div>
                            </div>
                            <div class="text-warning"><i class="fas fa-hourglass-half fa-lg"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="text-muted small">Declined</div>
                                <div class="h4 mb-0">{{ $stats['declined'] }}</div>
                            </div>
                            <div class="text-danger"><i class="fas fa-times-circle fa-lg"></i></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Secondary KPIs -->
        <!--
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="text-muted small">Approval Rate</div>
                                <div class="h4 mb-0">{{ $stats['approval_rate'] }}%</div>
                            </div>
                            <div class="text-success"><i class="fas fa-percentage fa-lg"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="text-muted small">Submissions (7 days)</div>
                                <div class="h4 mb-0">{{ $stats['week_submissions'] }}</div>
                            </div>
                            <div class="text-primary-custom"><i class="fas fa-calendar-week fa-lg"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="text-muted small">Avg Review Time</div>
                                <div class="h4 mb-0">~ {{ ceil($stats['avg_review_seconds'] / 60) }} mins</div>
                            </div>
                            <div class="text-muted"><i class="fas fa-stopwatch fa-lg"></i></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        -->

        <div class="row g-3">
            <!-- Pending Testimonies -->
            <div class="col-md-6">
                <div class="card shadow-sm h-100">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="fas fa-inbox me-2"></i>Pending Testimonies</h5>
                        <a href="{{ route('admin.testimonies.manage') }}" class="btn btn-sm btn-outline-secondary">View all</a>
                    </div>
                    <div class="card-body p-0">
                        <div class="list-group list-group-flush">
                            @forelse($pendingTestimonies as $t)
                                <a href="{{ route('admin.testimonies.view', ['id' => $t->id]) }}" class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1">{{ $t->title }}</h6>
                                        <small class="text-muted">{{ $t->created_at->diffForHumans() }}</small>
                                    </div>
                                    <small class="text-muted">By {{ $t->author ?? 'Anonymous' }} • {{ $t->result_category ?? 'Uncategorized' }}</small>
                                </a>
                            @empty
                                <div class="p-4 text-center text-muted">No pending testimonies.</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="fas fa-history me-2"></i>Recent Activity</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="list-group list-group-flush">
                            @forelse($recentReviewed as $t)
                                <div class="list-group-item">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1">{{ $t->title }}</h6>
                                        <span class="badge bg-{{ $t->status === 'approved' ? 'success' : 'danger' }} small pt-1 pb-0">{{ ucfirst($t->status) }}</span>
                                    </div>
                                    <small class="text-muted">Reviewed {{ $t->reviewed_at?->diffForHumans() }} by {{ $t->approved_by_email ?? 'N/A' }}</small>
                                </div>
                            @empty
                                <div class="p-4 text-center text-muted">No recent approvals or declines.</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-3 mt-4">
            <!-- Latest Sunday Service -->
            <div class="col-md-6">
                <div class="card shadow-sm h-100">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="fas fa-church me-2"></i>Latest Sunday Service</h5>
                        <a href="{{ route('admin.sunday_service') }}" class="btn btn-sm btn-outline-secondary">Manage</a>
                    </div>
                    <div class="card-body">
                        @if($latestService)
                            <div class="d-flex align-items-start">
                                @if($latestService->sunday_poster)
                                    <img src="{{ asset('storage/'.$latestService->sunday_poster) }}" alt="Poster" class="rounded me-3" style="width: 80px; height: 80px; object-fit: cover;">
                                @endif
                                <div>
                                    <h6 class="mb-1">{{ $latestService->sunday_theme }}</h6>
                                    <div class="text-muted small">
                                        <i class="far fa-calendar-alt me-1"></i>{{ \Carbon\Carbon::parse($latestService->service_date)->format('D, M j, Y') }}
                                        @if($latestService->service_time)
                                            • <i class="far fa-clock ms-1 me-1"></i>{{ $latestService->service_time }}
                                        @endif
                                    </div>
                                    @if($latestService->user_email)
                                        <div class="small">By <span class="text-muted">{{ $latestService->user_email }}</span></div>
                                    @endif
                                </div>
                            </div>
                        @else
                            <div class="text-center text-muted">No Sunday Service created yet.</div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Upcoming Event -->
            <div class="col-md-6">
                <div class="card shadow-sm h-100">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="fas fa-bullhorn me-2"></i>Upcoming Event</h5>
                        <a href="{{ route('admin.events') }}" class="btn btn-sm btn-outline-secondary">Manage</a>
                    </div>
                    <div class="card-body">
                        @if($upcomingEvent)
                            <div class="d-flex align-items-start">
                                @if($upcomingEvent->poster)
                                    <img src="{{ asset('storage/'.$upcomingEvent->poster) }}" alt="Poster" class="rounded me-3" style="width: 80px; height: 80px; object-fit: cover;">
                                @endif
                                <div>
                                    <h6 class="mb-1">{{ $upcomingEvent->title }}</h6>
                                    <div class="text-muted small">
                                        <i class="far fa-calendar-alt me-1"></i>{{ $upcomingEvent->getDateRange() }}
                                        @if($upcomingEvent->start_time)
                                            • <i class="far fa-clock ms-1 me-1"></i>{{ $upcomingEvent->getTimeRange() }}
                                        @endif
                                    </div>
                                    @if($upcomingEvent->location)
                                        <div class="small"><i class="fas fa-map-marker-alt me-1"></i>{{ $upcomingEvent->location }}</div>
                                    @endif
                                </div>
                            </div>
                        @else
                            <div class="text-center text-muted">No upcoming events.</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
