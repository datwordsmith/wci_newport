<?php

namespace App\Livewire\Public;

use Livewire\Component;
use Livewire\Attributes\Title;
use App\Models\Testimony as TestimonyModel;
use Livewire\Attributes\Layout;

#[Layout('layouts.main')]
class Testimony extends Component
{
    public $testimonyId;
    public $testimony;

    #[Title('Testimonies')]
    public $description = "Discover the powerful testimonies of our members and how God is working in their lives";

    public function mount($id)
    {
        $this->testimonyId = $id;
        $this->testimony = TestimonyModel::approved()
            ->where('publish_permission', true)
            ->with(['approvedImages' => function($q){ $q->orderBy('sort_order'); }])
            ->findOrFail($id);

        // Update the title and description based on the testimony
        $this->description = "\"" . \Illuminate\Support\Str::limit($this->testimony->content, 100) . "\" - " . $this->testimony->author;
    }

    public function render()
    {
        return view('livewire.public.testimony', [
            'testimony' => $this->testimony
        ]);
    }
}
