<div>
    @section('description', $description)

    @section('content')

    @include('layouts.inc._events', ['upcomingEvents' => $upcomingEvents])
    @endsection

</div>
