<div>
    @section('description', $description)

    @section('content')

    @include('layouts.inc._events', ['upcomingEvents' => $upcomingEvents])

    @include('layouts.inc._programmes', ['nextSundayService' => $nextSundayService])
    @endsection

</div>
