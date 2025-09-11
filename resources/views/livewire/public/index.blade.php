<div>
    @section('description', $description)

    @if($nextSundayService)
        @section('hero-service-info')
            {{-- @if($nextSundayService->sunday_poster)
                <!-- Show poster on mobile, text on desktop -->
                <div class="d-block d-md-none sunday-poster-mobile mt-3">
                    <img src="{{ asset('storage/' . $nextSundayService->sunday_poster) }}"
                         alt="{{ $nextSundayService->sunday_theme }}"
                         class="img-fluid rounded shadow-lg">
                </div>
                <div class="service-info mt-3 d-none d-md-block">
                    <h5 class="text-warning mb-2">{{ \Carbon\Carbon::parse($nextSundayService->service_date)->format('l, F j, Y') }}</h5>
                    <h4 class="mb-2">{{ $nextSundayService->sunday_theme }}</h4>
                    <p class="text-light mb-0">{{ \Carbon\Carbon::parse($nextSundayService->service_time)->format('g:i A') }}</p>
                </div>
            @else --}}
                <!-- Show service info when no poster available -->
                <div class="service-info mt-3">
                    <h5 class="text-warning mb-2">{{ \Carbon\Carbon::parse($nextSundayService->service_date)->format('l, F j, Y') }}</h5>
                    <h4 class="mb-2">{{ $nextSundayService->sunday_theme }}</h4>
                    <p class="text-light mb-0">{{ \Carbon\Carbon::parse($nextSundayService->service_time)->format('g:i A') }}</p>
                </div>
            {{-- @endif --}}
        @endsection

        @section('hero-service-button')
            <a href="#services" class="btn btn-primary-custom me-3">
                Join Us This {{ \Carbon\Carbon::parse($nextSundayService->service_date)->format('l') }} |
                <small>{{ \Carbon\Carbon::parse($nextSundayService->service_time)->format('g:i A') }}</small>
            </a>
        @endsection
    @endif

    @section('action-cards')
        <div class="container action-cards">
            <div class="row g-1 justify-content-center">
                <div class="col-md-3 action-card">
                    <a href="{{ route('testimonies.create') }}" class="">
                        <i class="fas fa-microphone"></i>
                        <h4>SHARE TESTIMONY</h4>
                        <p>Tell us what God has done</p>
                    </a>
                </div>
                <div class="col-md-3 action-card">
                    <a href="{{ route('service_units') }}" class="">
                        <i class="fas fa-people-group"></i>
                        <h4>GET INVOLVED</h4>
                        <p>Join a service group</p>
                    </a>
                </div>
                <div class="col-md-3 action-card">
                    <a href="{{ route('giving') }}" class="">
                        <i class="fas fa-hand-holding-heart"></i>
                        <h4>GIVE</h4>
                        <p>Tithes, offerings & seeds</p>
                    </a>
                </div>
            </div>
        </div>
    @endsection

    @section('programmes')
        @include('layouts.inc._programmes', ['nextSundayService' => $nextSundayService])
    @endsection

    @section('events')
        @include('layouts.inc._events', ['upcomingEvents' => $upcomingEvents])
    @endsection

    @section('next-sunday-service')
        @if($nextSundayService)
            <div class="next-sunday-service">
                <h4>Next Sunday Service</h4>
                <p><strong>Theme:</strong> {{ $nextSundayService->sunday_theme }}</p>
                <p><strong>Date:</strong> {{ $nextSundayService->service_date }}</p>
                <p><strong>Time:</strong> {{ $nextSundayService->service_time }}</p>
                @if($nextSundayService->sunday_poster)
                    <img src="{{ asset('storage/' . $nextSundayService->sunday_poster) }}" alt="Service Poster">
                @endif
            </div>
        @else
            <p>No upcoming Sunday service scheduled.</p>
        @endif
    @endsection

    @section('content')

        @include('livewire.public.modals.add-testimony')
    @endsection

</div>
