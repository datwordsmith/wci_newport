// Global variable for current event
let currentEvent = null;

// Define functions in global scope
window.shareEvent = function(event) {
    console.log('Share event called:', event); // Debug log

    // Update meta tags for better social sharing
    if (typeof window.updateEventMeta === 'function') {
        window.updateEventMeta(event);
    }

    // Create a URL-friendly slug from the event title
    const titleSlug = event.title
        .toLowerCase()
        .replace(/[^a-z0-9\s-]/g, '') // Remove special characters
        .replace(/\s+/g, '-') // Replace spaces with hyphens
        .replace(/-+/g, '-') // Replace multiple hyphens with single
        .replace(/^-|-$/g, ''); // Remove leading/trailing hyphens

    // Prefer an explicit shareUrl when provided (e.g., from Blade), otherwise build it
    const eventUrl = event.shareUrl || `${window.location.origin}/event/${event.id}/${event.slug || titleSlug}`;
    const shareTitle = `${event.title} - Winners Chapel International Newport`;
    const shareText = event.description ?
        `Join us for ${event.title}! ${event.description.substring(0, 100)}${event.description.length > 100 ? '...' : ''}` :
        `Join us for ${event.title}!`;

    console.log('Share URL:', eventUrl); // Debug log

    if (navigator.share) {
        console.log('Using native share API'); // Debug log
        navigator.share({
            title: shareTitle,
            text: shareText,
            url: eventUrl
        })
        .then(() => console.log('Share successful'))
        .catch(error => console.log('Error sharing:', error));
    } else {
        console.log('Using fallback share method'); // Debug log

        // Fallback for browsers that don't support Web Share API
        const tempInput = document.createElement('input');
        tempInput.value = eventUrl;
        document.body.appendChild(tempInput);
        tempInput.select();
        tempInput.setSelectionRange(0, 99999); // For mobile devices

        try {
            const successful = document.execCommand('copy');
            document.body.removeChild(tempInput);

            if (successful) {
                console.log('Copy successful'); // Debug log
                alert('Event link copied to clipboard!\n\n' + eventUrl);
            } else {
                console.log('Copy failed'); // Debug log
                alert('Could not copy link. Please copy manually:\n\n' + eventUrl);
            }
        } catch (err) {
            console.error('Copy error:', err);
            document.body.removeChild(tempInput);
            alert('Could not copy link. Please copy manually:\n\n' + eventUrl);
        }
    }
};

window.addToGoogleCalendar = function(event) {
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
};

window.addToOutlookCalendar = function(event) {
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
};

window.downloadICS = function(event) {
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
};
