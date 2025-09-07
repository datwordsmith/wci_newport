<?php

namespace App\Livewire\Public;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

#[Layout('layouts.main')]
class Giving extends Component
{
    #[Title('Giving - Ways to Give')]

    public $description = 'Support the ministry through tithes, offerings, transport fund, kingdom care seed and more.';

    public function render()
    {
        return view('livewire.public.giving');
    }
}
