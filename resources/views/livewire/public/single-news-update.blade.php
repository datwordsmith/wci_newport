<div>
    @section('description', \Illuminate\Support\Str::limit(strip_tags($newsUpdate->excerpt ?: $newsUpdate->body), 160))

    @push('meta')
        <meta property="og:title" content="{{ $newsUpdate->title }} — WCI Newport" />
        <meta property="og:description" content="{{ \Illuminate\Support\Str::limit(strip_tags($newsUpdate->excerpt ?: $newsUpdate->body), 160) }}" />
        <meta property="og:type" content="article" />
        <meta property="og:url" content="{{ route('news_update.show', $newsUpdate->slug) }}" />
    @endpush

    <section class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">

                    <!-- Back link -->
                    <a href="{{ route('news_updates') }}" class="text-muted small mb-4 d-inline-block">
                        <i class="fas fa-arrow-left me-1"></i> Back to News &amp; Updates
                    </a>

                    <div class="card shadow-sm">
                        <div class="card-body p-4 p-md-5">

                            <!-- Meta badges -->
                            <div class="mb-3 d-flex flex-wrap gap-2 align-items-center">
                                @if($newsUpdate->source)
                                    <span class="badge bg-secondary">{{ $newsUpdate->source }}</span>
                                @endif
                                @if($newsUpdate->is_featured)
                                    <span class="badge bg-warning text-dark"><i class="fas fa-star me-1"></i>Featured</span>
                                @endif
                                <small class="text-muted ms-auto">
                                    <i class="fas fa-calendar-alt me-1"></i>
                                    {{ $newsUpdate->published_at->format('F j, Y') }}
                                </small>
                            </div>

                            <!-- Title -->
                            <h1 class="h3 serif-font mb-2">{{ $newsUpdate->title }}</h1>

                            @if($newsUpdate->author_name)
                                <p class="text-muted small mb-4">By {{ $newsUpdate->author_name }}</p>
                            @endif

                            @if($newsUpdate->excerpt)
                                <p class="lead text-muted border-start border-3 ps-3 mb-4">{{ $newsUpdate->excerpt }}</p>
                            @endif

                            <hr class="mb-4">

                            <!-- Body content from Quill -->
                            <div class="news-body ql-editor" style="padding: 0;">
                                {!! $newsUpdate->body !!}
                            </div>

                            <!-- Attachment -->
                            @if($newsUpdate->attachment_path)
                                <div class="mt-5 p-3 bg-light rounded d-flex align-items-center gap-3">
                                    <i class="fas fa-paperclip fa-lg text-muted"></i>
                                    <div>
                                        <div class="fw-semibold small">Attachment</div>
                                        <a href="{{ asset('storage/' . $newsUpdate->attachment_path) }}"
                                           target="_blank"
                                           class="text-decoration-none">
                                            {{ $newsUpdate->attachment_original_name ?? 'Download file' }}
                                            <i class="fas fa-download ms-1 small"></i>
                                        </a>
                                    </div>
                                </div>
                            @endif

                        </div>
                    </div>

                    <!-- Bottom nav -->
                    <div class="mt-4 text-center">
                        <a href="{{ route('news_updates') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>All News &amp; Updates
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </section>

    @push('scripts')
    <link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
    <style>
        /* Show Quill content without editor chrome */
        .news-body.ql-editor { font-size: 1rem; line-height: 1.7; }
        .news-body.ql-editor:focus { outline: none; }
    </style>
    @endpush
</div>
