<?php

namespace App\Livewire\Public;

use Livewire\Component;
use Livewire\Attributes\Title;

class ServiceUnits extends Component
{
    #[Title('Service Units')]

    public $description = "Discover our various service units and how you can get involved";


    public function render()
    {
        return view('livewire.public.service-units')
            ->layout('layouts.main');
    }
}
