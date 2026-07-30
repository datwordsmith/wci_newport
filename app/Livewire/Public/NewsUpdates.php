<?php

namespace App\Livewire\Public;

use App\Models\NewsUpdate;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

#[Layout('layouts.main')]
class NewsUpdates extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    #[Title('News & Updates')]
    public $description = 'Stay informed with the latest news, letters, and announcements from WCI Newport.';

    public $search = '';

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $items = NewsUpdate::published()
            ->when($this->search, fn($q) => $q->where('title', 'like', "%{$this->search}%")
                ->orWhere('excerpt', 'like', "%{$this->search}%")
                ->orWhere('source', 'like', "%{$this->search}%"))
            ->orderByDesc('published_at')
            ->paginate(9);

        return view('livewire.public.news-updates', compact('items'))->layoutData(['description' => $this->description]);
    }
}
