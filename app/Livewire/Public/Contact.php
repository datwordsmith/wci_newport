<?php

namespace App\Livewire\Public;

use Livewire\Component;
use Livewire\Attributes\Title;

class Contact extends Component
{

    #[Title('Contact Us')]
    public $description = "Get in touch with us for any inquiries or support";

    public function render()
    {
        return view('livewire.public.contact')
            ->layout('layouts.main');
    }
}
