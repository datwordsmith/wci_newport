<div>
    @section('description', $description)

    @if($featuredEvent)
        @section('og_image', $featuredEvent->poster ? asset('storage/' . $featuredEvent->poster) : asset('assets/images/lfww_logo.png'))

        {{-- Dynamic meta tags for social sharing --}}
        @push('meta')
        <script>
            // Function to update meta tags dynamically when events are shared
            window.updateEventMeta = function(event) {
                // Update Open Graph meta tags
                updateMetaTag('property', 'og:title', `${event.title} - Winners Chapel International Newport`);
                updateMetaTag('property', 'og:description', event.description ? event.description.substring(0, 160) : 'Join us for this exciting event at Winners Chapel International Newport!');
                updateMetaTag('property', 'og:image', event.poster ? `{{ asset('storage/') }}/${event.poster}` : '{{ asset('assets/images/lfww_logo.png') }}');

                // Update Twitter meta tags
                updateMetaTag('property', 'twitter:title', `${event.title} - Winners Chapel International Newport`);
                updateMetaTag('property', 'twitter:description', event.description ? event.description.substring(0, 160) : 'Join us for this exciting event at Winners Chapel International Newport!');
                updateMetaTag('property', 'twitter:image', event.poster ? `{{ asset('storage/') }}/${event.poster}` : '{{ asset('assets/images/lfww_logo.png') }}');

                // Update page title
                document.title = `${event.title} - Winners Chapel International Newport`;
            };

            function updateMetaTag(attribute, name, content) {
                let element = document.querySelector(`meta[${attribute}="${name}"]`);
                if (element) {
                    element.setAttribute('content', content);
                } else {
                    // Create new meta tag if it doesn't exist
                    element = document.createElement('meta');
                    element.setAttribute(attribute, name);
                    element.setAttribute('content', content);
                    document.head.appendChild(element);
                }
            }
        </script>
        @endpush
    @endif

    @section('content')

    @include('layouts.inc._events', ['upcomingEvents' => $upcomingEvents])

    @include('layouts.inc._programmes', ['nextSundayService' => $nextSundayService])
    @endsection

</div>
