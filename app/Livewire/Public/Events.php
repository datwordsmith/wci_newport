<?php

namespace App\Livewire\Public;

use Carbon\Carbon;
use App\Models\Event;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\SundayService;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

#[Layout('layouts.main')]
class Events extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    #[Title('Events')]
    public $description = 'See all our upcoming events and activities.';

    public $nextSundayService = null;
    public $featuredEvent = null;

    public function mount()
    {
        $this->loadNextSundayService();
        $this->loadFeaturedEvent();
    }

    private function loadNextSundayService()
    {
        // Get current date
        $currentDate = now()->toDateString();

        // Fetch only the next upcoming Sunday service
        $this->nextSundayService = SundayService::where('service_date', '>=', $currentDate)
            ->orderBy('service_date', 'asc')
            ->orderBy('service_time', 'asc')
            ->first(); // Get only the next service
    }

    private function loadFeaturedEvent()
    {
        // Get the next upcoming event for featured display
        $this->featuredEvent = Event::where('event_date', '>=', Carbon::now()->toDateString())
            ->orderBy('event_date')
            ->orderBy('start_time')
            ->first();
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
