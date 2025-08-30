<?php

namespace App\Livewire\Public;

use Livewire\Component;
use Livewire\Attributes\Title;

class About extends Component
{
    #[Title('About Us')]

    public $description = "Discover our story and the foundation of our faith";

    public function render()
    {
        return view('livewire.public.about')
            ->layout('layouts.main');
    }
}
