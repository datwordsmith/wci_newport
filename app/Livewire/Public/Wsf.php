<?php

namespace App\Livewire\Public;

use Livewire\Component;
use Livewire\Attributes\Title;

class Wsf extends Component
{
    #[Title('Winners Satellite Fellowship')]

    public $description = "Bringing Jesus to your doorstep through fellowship and prayer";

    public function render()
    {
        return view('livewire.public.wsf')
            ->layout('layouts.main');
    }
}
