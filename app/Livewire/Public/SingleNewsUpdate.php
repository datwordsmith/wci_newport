<?php

namespace App\Livewire\Public;

use App\Models\NewsUpdate;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.main')]
class SingleNewsUpdate extends Component
{
    public NewsUpdate $newsUpdate;

    public function mount(string $slug): void
    {
        $this->newsUpdate = NewsUpdate::published()->where('slug', $slug)->firstOrFail();
    }

    public function render()
    {
        return view('livewire.public.single-news-update')
            ->title($this->newsUpdate->title)
            ->layoutData([
                'description' => strip_tags(\Illuminate\Support\Str::limit($this->newsUpdate->excerpt ?: $this->newsUpdate->body, 160)),
                'og_image' => $this->newsUpdate->image_path ? asset('storage/' . $this->newsUpdate->image_path) : null,
            ]);
    }
}
