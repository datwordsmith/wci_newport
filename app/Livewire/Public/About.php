<?php

namespace App\Livewire\Public;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

#[Layout('layouts.main')]
class About extends Component
{
    #[Title('About Us')]

    public $description = "Discover our story and the foundation of our faith";

    public function render()
    {
        return view('livewire.public.about');
    }
}
