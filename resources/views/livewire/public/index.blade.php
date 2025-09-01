<div>
    @section('description', $description)

    @section('action-cards')
        <div class="container action-cards">
            <div class="row g-1 justify-content-center">
                <div class="col-md-3 action-card">
                    <a href="" class="" data-bs-toggle="modal" data-bs-target="#addTestimonyModal">
                        <i class="fas fa-microphone"></i>
                        <h4>SHARE TESTIMONY</h4>
                        <p>Tell us what God has done</p>
                    </a>
                </div>
                <div class="col-md-3 action-card">
                    <a href="" class="">
                        <i class="fas fa-people-group"></i>
                        <h4>GET INVOLVED</h4>
                        <p>Join a service group</p>
                    </a>
                </div>
                <div class="col-md-3 action-card">
                    <a href="" class="">
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
