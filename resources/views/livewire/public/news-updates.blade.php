<div>
    @section('description', $description)

    <section class="py-5">
        <div class="container">

            <!-- Page Header -->
            <div class="text-center mb-5">
                <h2 class="serif-font">News &amp; Updates</h2>
                <p class="lead text-muted">Church announcements, letters, and news from WCI Newport</p>
            </div>

            <!-- Search -->
            <div class="row justify-content-center mb-4">
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-text bg-white"><i class="fas fa-search"></i></span>
                        <input type="search"
                               class="form-control"
                               placeholder="Search news &amp; updates..."
                               wire:model.live.debounce.300ms="search">
                        @if($search)
                            <button class="btn btn-outline-secondary" type="button" wire:click="$set('search', '')">
                                <i class="fas fa-times"></i>
                            </button>
                        @endif
                    </div>
                </div>
            </div>

            @if($items->count())
                <div class="row g-4">
                    @foreach($items as $item)
                        <div class="col-md-6 col-lg-4">
                            <div class="card h-100 shadow-sm">
                                <div class="card-body d-flex flex-column">
                                    @if($item->source)
                                        <div class="mb-2">
                                            <span class="badge bg-secondary">{{ $item->source }}</span>
                                            @if($item->is_featured)
                                                <span class="badge bg-warning text-dark ms-1"><i class="fas fa-star me-1"></i>Featured</span>
                                            @endif
                                        </div>
                                    @elseif($item->is_featured)
                                        <div class="mb-2">
                                            <span class="badge bg-warning text-dark"><i class="fas fa-star me-1"></i>Featured</span>
                                        </div>
                                    @endif

                                    <h5 class="card-title mb-1">{{ $item->title }}</h5>

                                    @if($item->author_name)
                                        <p class="text-muted small mb-2">By {{ $item->author_name }}</p>
                                    @endif

                                    <p class="card-text text-muted flex-grow-1">
                                        {{ $item->excerpt ?: \Illuminate\Support\Str::limit(strip_tags($item->body), 160) }}
                                    </p>
                                </div>
                                <div class="card-footer bg-white d-flex justify-content-between align-items-center">
                                    <small class="text-muted">
                                        <i class="fas fa-calendar-alt me-1"></i>
                                        {{ $item->published_at->format('M j, Y') }}
                                    </small>
                                    <a href="{{ route('news_update.show', $item->slug) }}"
                                       class="btn btn-sm btn-primary-custom">
                                        Read More <i class="fas fa-arrow-right ms-1"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-5">
                    {{ $items->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-newspaper fa-3x text-muted mb-3"></i>
                    <p class="text-muted">
                        @if($search)
                            No results found for <strong>"{{ $search }}"</strong>.
                        @else
                            No news or updates published yet. Check back soon.
                        @endif
                    </p>
                </div>
            @endif

        </div>
    </section>
</div>
