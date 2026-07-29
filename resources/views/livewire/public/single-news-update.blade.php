<div>
    @push('meta')
        <meta property="og:type" content="article" />
        <meta property="og:url" content="{{ route('news_update.show', $newsUpdate->slug) }}" />
    @endpush

    @section('content')
    <section class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card shadow">
                        <div class="card-body p-4 p-md-5">

                            <!-- Top bar: back + action buttons -->
                            <div class="mb-4 d-flex justify-content-between align-items-center">
                                <a href="{{ route('news_updates') }}" class="btn btn-outline-secondary btn-sm">
                                    <i class="fas fa-arrow-left me-2"></i>Back to News &amp; Updates
                                </a>
                                <div class="d-flex gap-2">
                                    <button onclick="printNews()" class="btn btn-primary-custom btn-sm" title="Print">
                                        <i class="fas fa-print"></i>
                                    </button>
                                    <button onclick="shareNews()" class="btn btn-primary-custom btn-sm" title="Share">
                                        <i class="fas fa-share-alt"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Header -->
                            <div class="mb-4">
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    @if($newsUpdate->source)
                                        <span class="badge bg-secondary">{{ $newsUpdate->source }}</span>
                                    @endif
                                    @if($newsUpdate->is_featured)
                                        <span class="badge bg-warning text-dark"><i class="fas fa-star me-1"></i>Featured</span>
                                    @endif
                                    <small class="text-muted ms-auto">
                                        {{ $newsUpdate->published_at->format('M j, Y') }}
                                    </small>
                                </div>
                                <h2 class="mb-1">{{ $newsUpdate->title }}</h2>
                                @if($newsUpdate->author_name)
                                    <p class="text-muted mb-0">by {{ $newsUpdate->author_name }}</p>
                                @endif
                            </div>

                            @if($newsUpdate->image_path)
                                <div class="mb-4">
                                    <img src="{{ asset('storage/' . $newsUpdate->image_path) }}" class="img-fluid rounded shadow-sm w-100" alt="{{ $newsUpdate->title }}" style="max-height: 500px; object-fit: cover;">
                                </div>
                            @endif

                            @if($newsUpdate->excerpt)
                                <p class="lead text-muted border-start border-3 ps-3 mb-4">{{ $newsUpdate->excerpt }}</p>
                            @endif

                            <!-- Body -->
                            <div class="news-content mb-4 p-4 bg-light rounded">
                                <div class="news-body ql-editor" style="padding:0;">
                                    {!! $newsUpdate->body !!}
                                </div>
                            </div>

                            <!-- Attachment -->
                            @if($newsUpdate->attachment_path)
                                <div class="mb-4">
                                    <h6 class="text-muted mb-2">Attachment</h6>
                                    <a href="{{ asset('storage/' . $newsUpdate->attachment_path) }}"
                                       target="_blank"
                                       class="btn btn-outline-secondary btn-sm">
                                        <i class="fas fa-download me-2"></i>
                                        {{ $newsUpdate->attachment_original_name ?? 'Download file' }}
                                    </a>
                                </div>
                            @endif

                            <!-- Bottom CTA -->
                            <div class="d-flex justify-content-end align-items-center mt-4">
                                <a href="{{ route('news_updates') }}" class="btn btn-primary-custom">
                                    <i class="fas fa-newspaper me-2"></i>All News &amp; Updates
                                </a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endsection

    @push('scripts')
    <link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
    <style>
        .news-body.ql-editor { font-size: 1rem; line-height: 1.7; padding: 0; }
    </style>
    <script>
        function shareNews() {
            if (navigator.share) {
                navigator.share({
                    title: '{{ addslashes($newsUpdate->title) }}',
                    url: window.location.href,
                }).catch(() => {});
            } else {
                const tmp = document.createElement('input');
                document.body.appendChild(tmp);
                tmp.value = window.location.href;
                tmp.select();
                document.execCommand('copy');
                document.body.removeChild(tmp);
                alert('Link copied to clipboard!');
            }
        }

        function printNews() {
            const content = document.querySelector('.card');
            const original = document.body.innerHTML;
            document.body.innerHTML = `
                <div style="max-width:800px;margin:20px auto;font-family:Arial,sans-serif;">
                    <h2 style="text-align:center;margin-bottom:5px;">Winners Chapel International Newport</h2>
                    <h3 style="text-align:center;margin-bottom:30px;">News &amp; Updates</h3>
                    ${content.innerHTML}
                    <p style="color:#666;text-align:center;font-size:12px;margin-top:30px;">
                        Printed from WCI Newport | ${new Date().toLocaleDateString()}
                    </p>
                </div>`;
            window.print();
            document.body.innerHTML = original;
            window.Livewire && window.Livewire.rescan && window.Livewire.rescan();
        }
    </script>
    @endpush
</div>
