@push('scripts')
<script src="{{ asset('assets/js/event-functions.js') }}"></script>
@endpush

@section('title', $event->title . ' - Winners Chapel International Newport')

@push('meta')
    <meta property="og:title" content="{{ $event->title }}" />
    <meta property="og:description" content="{{ strip_tags(Str::limit($event->description, 200)) }}" />
    @if($event->poster)
    <meta property="og:image" content="{{ asset(Storage::url($event->poster)) }}" />
    @else
    <meta property="og:image" content="{{ asset('assets/images/lfww_logo.png') }}" />
    @endif
    <meta property="og:type" content="article" />
    <meta property="og:url" content="{{ route('event.show', ['id' => $event->id, 'slug' => $event->slug]) }}" />

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $event->title }}">
    <meta name="twitter:description" content="{{ strip_tags(Str::limit($event->description, 200)) }}">
    @if($event->poster)
    <meta name="twitter:image" content="{{ asset(Storage::url($event->poster)) }}">
    @else
    <meta name="twitter:image" content="{{ asset('assets/images/lfww_logo.png') }}">
    @endif
@endpush

<div>
    <!-- Main Content -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <!-- Event Details -->
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h4 class="serif-font mb-4">{{ $event->title }}</h4>

                            @if($event->poster)
                            <div class="d-block d-lg-none mb-4">
                                <img src="{{ Storage::url($event->poster) }}" alt="{{ $event->title }}" class="img-fluid rounded shadow">
                            </div>
                            @endif

                            <div class="event-meta mb-4">
                                <div class="mb-2">
                                    <i class="fas fa-calendar me-2"></i>
                                    {{ \Carbon\Carbon::parse($event->event_date)->format('F d, Y') }}
                                </div>
                                <div class="mb-2">
                                    <i class="fas fa-clock me-2"></i>
                                    {{ $event->getTimeRange() }}
                                </div>

                                @if($event->location)
                                <div class="mb-2">
                                    <i class="fas fa-map-marker-alt me-2"></i>
                                    {{ $event->location }}
                                </div>
                                @endif

                                @if($event->event_url)
                                <div class="mb-2">
                                    <a href="{{ $event->event_url }}" target="_blank" class="btn btn-primary-custom">
                                        <i class="fas fa-external-link-alt me-1 text-white"></i>
                                        Join Event
                                    </a>
                                </div>
                                @endif
                            </div>

                            <!-- Event Description -->
                            <div class="event-description mb-4">
                                <h5 class="serif-font mb-3">About This Event</h5>
                                <div class="lh-lg">
                                    @if($event->description)
                                        {{ $event->description }}
                                    @else
                                        <p class="text-muted">No description available.</p>
                                    @endif
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="d-flex flex-column flex-md-row gap-2">
                                <div class="btn-group flex-fill">
                                    <button type="button"
                                            class="btn btn-outline-secondary dropdown-toggle w-100"
                                            data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                        <i class="fas fa-calendar-plus me-2"></i>
                                        Add to Calendar
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item" href="#" onclick="addToGoogleCalendar({{ json_encode($event) }})">
                                                <i class="fab fa-google me-2"></i>Google Calendar
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="#" onclick="addToOutlookCalendar({{ json_encode($event) }})">
                                                <i class="fab fa-microsoft me-2"></i>Outlook Calendar
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="#" onclick="downloadICS({{ json_encode($event) }})">
                                                <i class="fas fa-download me-2"></i>Download ICS File
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <button type="button" class="btn btn-outline-secondary flex-fill" onclick="shareEvent({{ json_encode($event) }})">
                                    <i class="fas fa-share-alt me-2"></i>
                                    Share Event
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar with Poster -->
                <div class="col-lg-6 d-none d-lg-block">
                    @if($event->poster)
                    <div class="mb-4">
                        <img src="{{ Storage::url($event->poster) }}" alt="{{ $event->title }}" class="img-fluid rounded shadow">
                    </div>
                    @else
                    <div class="mb-4">
                        <div class="ratio ratio-4x3 bg-light rounded shadow border">
                            <div class="d-flex align-items-center justify-content-center h-100 w-100">
                                <div class="text-center text-muted">
                                    <i class="fas fa-calendar fa-4x mb-3"></i>
                                    <div>Event poster unavailable</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
</div>
