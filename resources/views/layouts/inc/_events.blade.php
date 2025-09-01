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
                    <div class="card h-100 event-card shadow-sm">
                        <div class="card-header event-card-header">
                            <div class="d-flex align-items-baseline">
                                <div class="event-day">{{ \Carbon\Carbon::parse($event->event_date)->format('d') }}</div>
                                <div class="event-month">{{ \Carbon\Carbon::parse($event->event_date)->format('M') }}</div>
                            </div>
                            <div class="event-year">{{ \Carbon\Carbon::parse($event->event_date)->format('Y') }}</div>
                        </div>
                        <div class="card-body d-flex flex-column h-100">
                            <div>
                                <h5 class="card-title serif-font">{{ $event->title }}</h5>
                                @if($event->description)
                                    <p class="card-text">{{ Str::limit($event->description, 150) }}</p>
                                @else
                                    <p class="card-text text-muted">
                                        No description available for this event.
                                    </p>
                                @endif
                            </div>

                            <div class="event-meta small mt-auto">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-clock me-2"></i>
                                    <span>{{ $event->getTimeRange() }}</span>
                                </div>
                                @if($event->location)
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-map-marker-alt me-2"></i>
                                    <span>{{ $event->location }}</span>
                                </div>
                                @endif
                                @if($event->event_url)
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-laptop me-2"></i>
                                        <span>Online Event</span>
                                    </div>
                                    <a href="{{ $event->event_url }}"
                                       target="_blank"
                                       rel="noopener noreferrer"
                                       class="btn btn-primary-custom btn-sm">
                                        <i class="fas fa-external-link-alt me-1 text-white"></i>
                                        Join
                                    </a>
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="d-flex gap-2 justify-content-center">
                                <button type="button"
                                        class="btn btn-outline-secondary btn-sm"
                                        data-bs-toggle="modal"
                                        data-bs-target="#eventModal{{ $event->id }}">
                                    <i class="fas fa-info-circle me-1"></i>
                                    View
                                </button>

                                <div class="btn-group">
                                    <button type="button"
                                            class="btn btn-outline-secondary btn-sm dropdown-toggle"
                                            data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                        <i class="fas fa-calendar-plus me-1"></i>
                                        Calendar
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item" href="#" onclick="addToGoogleCalendar({{ json_encode($event) }})">
                                                <i class="fab fa-google me-2"></i>Google
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

                                <button type="button"
                                        class="btn btn-outline-secondary btn-sm"
                                        onclick="shareEvent({{ json_encode($event) }})">
                                    <i class="fas fa-share-alt me-1"></i>
                                    Share
                                </button>
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
        @else
            <div class="text-center py-5">
                <div class="display-1 text-muted mb-4">
                    <i class="fas fa-calendar-times"></i>
                </div>
                <h5 class="text-muted mb-2">No Upcoming Events</h5>
                <p class="text-muted">Check back soon for new events and programs!</p>
            </div>
        @endif
    </div>
</section>

<!-- Event Detail Modals -->
@if($upcomingEvents && count($upcomingEvents) > 0)
@foreach($upcomingEvents as $event)
<div class="modal fade event-modal" id="eventModal{{ $event->id }}" tabindex="-1" aria-labelledby="eventModalLabel{{ $event->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable modal-fullscreen-sm-down">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Row 1: Poster -->
                @if($event->poster)
                <div class="row mb-4">
                    <div class="col-12">
                        <img src="{{ Storage::url($event->poster) }}" alt="{{ $event->title }}" class="img-fluid rounded shadow-sm w-100">
                    </div>
                </div>
                @endif

                <!-- Row 2: Description and Meta -->
                <div class="row g-4 align-items-start">
                    <div class="col-12 col-md-7">
                        <h3 class="serif-font mb-3">{{ $event->title }}</h3>
                        @if($event->description)
                        <div class="event-description">
                            <h6 class="text-primary mb-3">About This Event</h6>
                            <div class="lh-lg">{{ $event->description }}</div>
                        </div>
                        @endif
                    </div>
                    <div class="col-12 col-md-5">
                        <div class="event-quick-info mb-4">
                            <div class="event-date-badge mb-4 text-center p-3 rounded">
                                <div class="display-4 fw-bold mb-0">{{ \Carbon\Carbon::parse($event->event_date)->format('d') }}</div>
                                <div class="text-uppercase fs-5">{{ \Carbon\Carbon::parse($event->event_date)->format('M') }}</div>
                                <div class="opacity-75">{{ \Carbon\Carbon::parse($event->event_date)->format('Y') }}</div>
                            </div>

                            <div class="info-list">
                                <div class="info-item d-flex align-items-center mb-3">
                                    <div class="icon-wrapper me-3">
                                        <i class="fas fa-clock"></i>
                                    </div>
                                    <div>
                                        <div class="text-muted small">Time</div>
                                        <div>{{ $event->getTimeRange() }}</div>
                                    </div>
                                </div>

                                @if($event->location)
                                <div class="info-item d-flex align-items-center mb-3">
                                    <div class="icon-wrapper me-3">
                                        <i class="fas fa-map-marker-alt"></i>
                                    </div>
                                    <div>
                                        <div class="text-muted small">Location</div>
                                        <div>{{ $event->location }}</div>
                                    </div>
                                </div>
                                @endif

                                @if($event->event_url)
                                <div class="info-item d-flex align-items-center">
                                    <div class="icon-wrapper me-3">
                                        <i class="fas fa-laptop"></i>
                                    </div>
                                    <div>
                                        <a href="{{ $event->event_url }}" target="_blank" class="btn btn-primary-custom btn-sm mt-1">
                                            <i class="fas fa-external-link-alt me-1"></i>
                                            Join Event
                                        </a>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Row 3: Actions -->
                <div class="row mt-3">
                    <div class="col-12">
                        <div class="event-actions">
                            <div class="d-grid gap-2 gap-md-3 d-md-flex justify-content-md-start">
                                <div class="btn-group">
                                    <button type="button"
                                            class="btn btn-outline-secondary dropdown-toggle"
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
                                <button type="button" class="btn btn-outline-secondary" onclick="shareEvent({{ json_encode($event) }})">
                                    <i class="fas fa-share-alt me-2"></i>
                                    Share Event
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach
@endif

<!-- Calendar Options Modal (for dropdown alternative) -->
<div class="modal fade" id="calendarOptionsModal" tabindex="-1" aria-labelledby="calendarOptionsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="calendarOptionsModalLabel">Add to Calendar</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="d-grid gap-2">
                    <button type="button" class="calendar-btn calendar-btn-google" onclick="addToGoogleCalendar(currentEvent)">
                        <i class="fab fa-google"></i>
                        Google Calendar
                    </button>
                    <button type="button" class="calendar-btn calendar-btn-outlook" onclick="addToOutlookCalendar(currentEvent)">
                        <i class="fab fa-microsoft"></i>
                        Outlook
                    </button>
                    <button type="button" class="calendar-btn calendar-btn-download" onclick="downloadICS(currentEvent)">
                        <i class="fas fa-download"></i>
                        Download ICS
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript Functions -->
<script>
let currentEvent = null;

function openCalendarOptions(eventId) {
    @if($upcomingEvents && count($upcomingEvents) > 0)
    const events = @json($upcomingEvents);
    currentEvent = events.find(event => event.id == eventId);
    const modal = new bootstrap.Modal(document.getElementById('calendarOptionsModal'));
    modal.show();
    @endif
}

function addToGoogleCalendar(event) {
    const startDate = new Date(event.event_date + ' ' + event.start_time);
    const endDate = event.end_date && event.end_time ?
        new Date(event.end_date + ' ' + event.end_time) :
        new Date(startDate.getTime() + (2 * 60 * 60 * 1000)); // Default 2 hours

    const formatDate = (date) => {
        return date.toISOString().replace(/[-:]/g, '').split('.')[0] + 'Z';
    };

    const params = new URLSearchParams({
        action: 'TEMPLATE',
        text: event.title,
        dates: formatDate(startDate) + '/' + formatDate(endDate),
        details: event.description || '',
        location: event.location || '',
        trp: 'false'
    });

    window.open('https://calendar.google.com/calendar/render?' + params.toString(), '_blank');

    // Close modal if open
    const modal = bootstrap.Modal.getInstance(document.getElementById('calendarOptionsModal'));
    if (modal) modal.hide();
}

function addToOutlookCalendar(event) {
    const startDate = new Date(event.event_date + ' ' + event.start_time);
    const endDate = event.end_date && event.end_time ?
        new Date(event.end_date + ' ' + event.end_time) :
        new Date(startDate.getTime() + (2 * 60 * 60 * 1000));

    const params = new URLSearchParams({
        subject: event.title,
        startdt: startDate.toISOString(),
        enddt: endDate.toISOString(),
        body: event.description || '',
        location: event.location || ''
    });

    window.open('https://outlook.live.com/calendar/0/deeplink/compose?' + params.toString(), '_blank');

    // Close modal if open
    const modal = bootstrap.Modal.getInstance(document.getElementById('calendarOptionsModal'));
    if (modal) modal.hide();
}

function shareEvent(event) {
    if (navigator.share) {
        navigator.share({
            title: event.title,
            text: event.description || 'Join us for this event!',
            url: window.location.href
        })
        .catch(error => console.log('Error sharing:', error));
    } else {
        // Fallback for browsers that don't support Web Share API
        const tempInput = document.createElement('input');
        tempInput.value = window.location.href;
        document.body.appendChild(tempInput);
        tempInput.select();
        document.execCommand('copy');
        document.body.removeChild(tempInput);

        // Show a tooltip or alert that URL was copied
        alert('Event URL copied to clipboard!');
    }
}

function downloadICS(event) {
    const startDate = new Date(event.event_date + ' ' + event.start_time);
    const endDate = event.end_date && event.end_time ?
        new Date(event.end_date + ' ' + event.end_time) :
        new Date(startDate.getTime() + (2 * 60 * 60 * 1000));

    const formatDate = (date) => {
        return date.toISOString().replace(/[-:]/g, '').split('.')[0] + 'Z';
    };

    const icsContent = [
        'BEGIN:VCALENDAR',
        'VERSION:2.0',
        'PRODID:-//Winners Chapel International Newport//Event//EN',
        'BEGIN:VEVENT',
        'UID:' + Date.now() + '@winnersnewport.org',
        'DTSTAMP:' + formatDate(new Date()),
        'DTSTART:' + formatDate(startDate),
        'DTEND:' + formatDate(endDate),
        'SUMMARY:' + event.title,
        'DESCRIPTION:' + (event.description || '').replace(/\n/g, '\\n'),
        'LOCATION:' + (event.location || ''),
        ...(event.event_url ? ['URL:' + event.event_url] : []),
        'END:VEVENT',
        'END:VCALENDAR'
    ].join('\r\n');

    const blob = new Blob([icsContent], { type: 'text/calendar' });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = event.title.replace(/[^a-z0-9]/gi, '_').toLowerCase() + '.ics';
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    window.URL.revokeObjectURL(url);

    // Close modal if open
    const modal = bootstrap.Modal.getInstance(document.getElementById('calendarOptionsModal'));
    if (modal) modal.hide();
}
</script>
