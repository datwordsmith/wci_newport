@if($latestNews && $latestNews->count() > 0)
<section id="news-updates" class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="serif-font">News/Updates</h2>
            <p class="lead text-muted">Latest announcements and letters</p>
        </div>

        <div class="row g-4">
            @foreach($latestNews as $item)
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

                            <p class="card-text text-muted small flex-grow-1">
                                {{ $item->excerpt ?: \Illuminate\Support\Str::limit(strip_tags($item->body), 120) }}
                            </p>
                        </div>
                        <div class="card-footer bg-white d-flex justify-content-between align-items-center">
                            <small class="text-muted">{{ $item->published_at->format('M j, Y') }}</small>
                            <a href="{{ route('news_update.show', $item->slug) }}" class="btn btn-sm btn-primary-custom">
                                Read <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="text-center mt-5">
            <a href="{{ route('news_updates') }}" class="btn btn-outline-secondary">
                <i class="fas fa-newspaper me-2"></i>View All News &amp; Updates
            </a>
        </div>
    </div>
</section>
@endif
