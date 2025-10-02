@if($upcomingEvents && $upcomingEvents->count() > 0)
    <section id="events" class="events-section">
        <div class="container">
            <div class="text-center mb-5">
                @unless(request()->routeIs('events'))
                    <h2 class="serif-font">Upcoming Events</h2>
                @endunless
                <p class="lead">Join us for these exciting upcoming events and programmes</p>
            </div>

            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                @foreach($upcomingEvents as $event)
                <div class="col">
                    <div class="card h-100 shadow-sm">
                        <!-- Event Header with Image -->
                        <div class="position-relative">
                            @if($event->poster)
                                <img src="{{ asset('storage/' . $event->poster) }}"
                                    alt="{{ $event->title }}" class="card-img-top" style="height: 200px; object-fit: cover;">
                            @else
                                <!-- Default poster with event info -->
                                <div class="card-img-top d-flex align-items-center justify-content-center"
                                     style="height: 200px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                    <div class="text-white text-center p-3">
                                        <div class="mb-3">
                                            <i class="fas fa-calendar-alt fa-3x opacity-75"></i>
                                        </div>
                                        <div class="fw-bold mb-2" style="font-size: 16px;">
                                            {{ Str::limit($event->title, 30) }}
                                        </div>
                                        <div class="small opacity-90">
                                            <div class="mb-1">
                                                {{ \Carbon\Carbon::parse($event->event_date)->format('M d, Y') }}
                                            </div>
                                            <div>
                                                {{ $event->getTimeRange() }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <!-- Date Badge -->
                            <div class="bg-accent position-absolute top-0 start-0 m-2 shadow-sm rounded">
                                <div class="text-white rounded p-2 text-center" style="min-width: 60px;">
                                    <div class="fw-bold">{{ \Carbon\Carbon::parse($event->event_date)->format('d') }}</div>
                                    <div class="small">{{ \Carbon\Carbon::parse($event->event_date)->format('M') }}</div>
                                </div>
                            </div>

                            <!-- Recurring Badge -->
                            @if($event->isRecurring())
                            <div class="position-absolute top-0 end-0 m-2">
                                @if($event->isRecurringMaster())
                                    <span class="badge bg-success text-white">
                                        <i class="fas fa-redo me-1"></i>Recurring
                                    </span>
                                @elseif($event->isRecurringInstance())
                                    <span class="badge bg-info text-white">
                                        <i class="fas fa-link me-1"></i>Series
                                    </span>
                                @endif
                            </div>
                            @endif
                        </div>

                        <!-- Card Body -->
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title serif-font mb-3">{{ $event->title }}</h5>

                            @if($event->description)
                                <p class="card-text text-muted mb-3">{{ Str::limit($event->description, 120) }}</p>
                            @else
                                <p class="card-text text-muted mb-3">No description available for this event.</p>
                            @endif

                            <!-- Event Meta Information -->
                            <div class="event-meta mt-auto">
                                <div class="d-flex align-items-center mb-2 text-muted">
                                    <i class="fas fa-calendar me-2"></i>
                                    <span>{{ \Carbon\Carbon::parse($event->event_date)->format('F d, Y') }}</span>
                                </div>

                                <div class="d-flex align-items-center mb-2 text-muted">
                                    <i class="fas fa-clock me-2"></i>
                                    <span>{{ $event->getTimeRange() }}</span>
                                </div>

                                @if($event->location)
                                <div class="d-flex align-items-center mb-2 text-muted">
                                    <i class="fas fa-map-marker-alt me-2"></i>
                                    <span>{{ $event->location }}</span>
                                </div>
                                @endif

                                @if($event->isRecurring())
                                <div class="d-flex align-items-center mb-2 text-muted">
                                    <i class="fas fa-redo me-2 text-success"></i>
                                    <small>{{ $event->getRecurringDescription() }}</small>
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Card Footer with Actions -->
                        <div class="card-footer bg-transparent border-0">
                            <div class="d-flex gap-2 justify-content-between align-items-center">
                                <!-- Main Action Button -->
                                <a href="{{ route('event.show', ['id' => $event->id, 'slug' => $event->slug]) }}"
                                   class="btn btn-outline-secondary btn-sm flex-grow-1">
                                    <i class="fas fa-info-circle me-1"></i>
                                    View
                                </a>

                                <!-- Add to Calendar Dropdown -->
                                <div class="dropdown">
                                    <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-calendar-plus me-1"></i>Calendar
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <a class="dropdown-item" href="#" onclick="addToGoogleCalendar({{ json_encode($event) }})">
                                                <i class="fab fa-google me-2"></i>Google Calendar
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="#" onclick="addToOutlookCalendar({{ json_encode($event) }})">
                                                <i class="fab fa-microsoft me-2"></i>Outlook
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="#" onclick="downloadICS({{ json_encode($event) }})">
                                                <i class="fas fa-download me-2"></i>Download ICS
                                            </a>
                                        </li>
                                    </ul>
                                </div>

                                <!-- Share Dropdown -->
                                <div class="dropdown">
                                    <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-share-alt me-1"></i>Share
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <a class="dropdown-item" href="#" onclick="shareEvent({{ json_encode($event) }}, 'copy')">
                                                <i class="fas fa-copy me-2"></i>Copy Link
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="#" onclick="shareEvent({{ json_encode($event) }}, 'email')">
                                                <i class="fas fa-envelope me-2"></i>Email
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="#" onclick="shareEvent({{ json_encode($event) }}, 'social')">
                                                <i class="fas fa-share-alt me-2"></i>Social Media
                                            </a>
                                        </li>
                                    </ul>
                                </div>

                                <!-- Online Event Join Button -->
                                @if($event->event_url)
                                <a href="{{ $event->event_url }}"
                                   target="_blank"
                                   rel="noopener noreferrer"
                                   class="btn btn-primary-custom btn-sm">
                                    <i class="fas fa-video me-1"></i>Join
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            @unless(request()->routeIs('events'))
                <!-- See All Events Button -->
                <div class="text-center mt-5">
                    <a href="{{ route('events') }}" class="btn btn-primary-custom">
                        <i class="fas fa-calendar-alt me-2"></i>
                        See All Events
                    </a>
                </div>
            @endunless

            @if(request()->routeIs('events'))
                <!-- Pagination -->
                @if($upcomingEvents->hasPages())
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div class="text-muted">
                        Showing {{ $upcomingEvents->firstItem() ?? 0 }} to {{ $upcomingEvents->lastItem() ?? 0 }} of {{ $upcomingEvents->total() }} results
                    </div>
                    <div>
                        {{ $upcomingEvents->links('pagination::bootstrap-5') }}
                    </div>
                </div>
                @endif
            @endif
        </div>
    </section>
@else
    <section id="events" class="events-section">
        <div class="container">
            <div class="text-center py-5">
                <div class="display-1 text-muted mb-4">
                    <i class="fas fa-calendar-times"></i>
                </div>
                <h5 class="text-muted mb-2">No Upcoming Events</h5>
                <p class="text-muted">Check back soon for new events and programs!</p>
            </div>
        </div>
    </section>
@endif

<!-- Include shared event functions -->
<script src="{{ asset('assets/js/event-functions.js') }}"></script>
