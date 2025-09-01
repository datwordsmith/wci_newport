<?php

namespace App\Livewire\Public;

use App\Models\Event;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Carbon\Carbon;

#[Layout('layouts.main')]
class Events extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    #[Title('Events')]
    public $description = 'See all our upcoming events and activities.';


 public function mount()
    {

    }
    public function render()
    {
        $events = Event::where('event_date', '>=', Carbon::now()->toDateString())
            ->orderBy('event_date')
            ->orderBy('start_time')
            ->paginate(9);

        return view('livewire.public.events', [
            'upcomingEvents' => $events,
        ]);
    }
}
