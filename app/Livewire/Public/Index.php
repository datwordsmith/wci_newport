<?php

namespace App\Livewire\Public;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use App\Models\SundayService;
use App\Models\Event;
use App\Models\NewsUpdate;

#[Layout('layouts.homepage')]
class Index extends Component
{
    #[Title("Winners Chapel International, Newport - Welcome Home")]

    public $description = "Winners Chapel International Newport - Liberating the World through the Preaching of the Word of Faith";
    public $nextSundayService = null;
    public $upcomingEvents = [];
    public $latestNews = [];

    public function mount()
    {
        $this->loadNextSundayService();
        $this->loadUpcomingEvents();
        $this->loadLatestNews();
    }

    #[On('sunday-service-updated')]
    #[On('sunday-service-created')]
    #[On('sunday-service-deleted')]
    public function refreshServices()
    {
        $this->loadNextSundayService();
    }

    #[On('event-updated')]
    #[On('event-created')]
    #[On('event-deleted')]
    public function refreshEvents()
    {
        $this->loadUpcomingEvents();
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

    private function loadUpcomingEvents()
    {
        // Get upcoming events with only next occurrence of recurring series (limit to 3 events)
        $filteredEvents = Event::getUpcomingUniqueRecurring();
        $this->upcomingEvents = $filteredEvents->take(3);
    }

    private function loadLatestNews()
    {
        $this->latestNews = NewsUpdate::published()
            ->orderByDesc('published_at')
            ->take(3)
            ->get();
    }

    public function render()
    {
        return view('livewire.public.index', [
            'nextSundayService' => $this->nextSundayService,
            'upcomingEvents' => $this->upcomingEvents,
            'latestNews' => $this->latestNews,
        ])->layoutData(['description' => $this->description]);
    }
}
