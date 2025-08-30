<?php

namespace App\Livewire\Public;

use Livewire\Component;
use Livewire\Attributes\Title;

class Testimony extends Component
{

    #[Title('Testimonies')]
    public $description = "Discover the powerful testimonies of our members and how God is working in their lives";

    public function render()
    {
        return view('livewire.public.testimony')
            ->layout('layouts.main');
    }
}
