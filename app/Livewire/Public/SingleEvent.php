<?php

namespace App\Livewire\Public;

use App\Models\Event;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

#[Layout('layouts.main')]
class SingleEvent extends Component
{
    public Event $event;

    public function mount($id, $slug = null)
    {
        $this->event = Event::findOrFail($id);

        // If no slug provided or wrong slug, redirect to the correct URL
        if (!$slug || $slug !== $this->event->slug) {
            return redirect()->route('event.show', ['id' => $id, 'slug' => $this->event->slug]);
        }
    }

    #[Title('Event Details')]
    public function render()
    {
        return view('livewire.public.single-event');
    }
}
