<?php

namespace App\Livewire\Public;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

#[Layout('layouts.main')]
class Csr extends Component
{
    #[Title('Corporate Social Responsibility')]

    public $description = 'Community outreach, education, healthcare initiatives, and social welfare programmes.';

    public function render()
    {
        return view('livewire.public.csr');
    }
}
