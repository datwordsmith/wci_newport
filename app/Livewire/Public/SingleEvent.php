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

    public function render()
    {
        return view('livewire.public.single-event')
            ->title($this->event->title)
            ->layoutData([
                'description' => strip_tags(\Illuminate\Support\Str::limit($this->event->description, 200)),
                'og_image' => $this->event->poster ? asset('storage/' . $this->event->poster) : null,
            ]);
    }
}
