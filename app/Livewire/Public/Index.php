<?php

namespace App\Livewire\Public;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use App\Models\SundayService;

#[Layout('layouts.homepage')]
class Index extends Component
{
    #[Title("Winners Chapel International, Newport - Welcome Home")]

    public $description = "Winners Chapel International Newport - Liberating the World through the Preaching of the Word of Faith";
    public $nextSundayService = null;

    public function mount()
    {
        $this->loadNextSundayService();
    }

    #[On('sunday-service-updated')]
    #[On('sunday-service-created')]
    #[On('sunday-service-deleted')]
    public function refreshServices()
    {
        $this->loadNextSundayService();
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

    public function render()
    {
        return view('livewire.public.index', [
            'nextSundayService' => $this->nextSundayService
        ]);
    }
}
