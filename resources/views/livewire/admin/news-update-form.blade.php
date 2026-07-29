@section('page-header')
@endsection

@section('title', $editMode ? 'Edit News Item' : 'Add News Item')
@section('subtitle', 'Publish church news, letters, and announcements')

<div>
    <div class="container-fluid py-4">

        <!-- Header -->
        <div class="row mb-2">
            <div class="col-12">
                <h1 class="h3 mb-1">{{ $editMode ? 'Edit News Item' : 'Add News Item' }}</h1>
                <p class="text-muted mb-0">{{ $editMode ? 'Update the content of this announcement or post.' : 'Write a new announcement, epistle, or update.' }}</p>
            </div>
        </div>

        <!-- Actions -->
        <div class="row mb-4">
            <div class="col-12 d-flex gap-2 justify-content-end">
                <a href="{{ route('admin.news_updates') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Back to List
                </a>
                <button type="button" class="btn btn-primary-custom" wire:click="save" wire:loading.attr="disabled" wire:target="save">
                    <span wire:loading.remove wire:target="save"><i class="fas fa-save me-2"></i>Save</span>
                    <span wire:loading wire:target="save"><span class="spinner-border spinner-border-sm me-2" role="status"></span>Saving...</span>
                </button>
            </div>
        </div>


        @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row g-4">

            <!-- Main content column -->
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <form wire:submit.prevent="save">

                            <!-- Title -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Title <span class="text-danger">*</span></label>
                                <input type="text"
                                       class="form-control @error('title') is-invalid @enderror"
                                       wire:model.defer="title"
                                       placeholder="Enter title">
                                @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <!-- Excerpt -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Short Excerpt</label>
                                <textarea class="form-control @error('excerpt') is-invalid @enderror"
                                          rows="2"
                                          wire:model.defer="excerpt"
                                          placeholder="Brief summary shown on listings and the homepage (optional — auto-generated if left blank)"></textarea>
                                @error('excerpt')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <!-- Body / Quill editor -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Content <span class="text-danger">*</span></label>
                                <input type="hidden" wire:model.defer="body" id="bodyInput">
                                <div id="quillEditor"
                                     style="min-height: 300px; background:#fff;"
                                     class="@error('body') border border-danger rounded @enderror">
                                </div>
                                @error('body')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                        </form>
                    </div>
                </div>
            </div>

            <!-- Sidebar column -->
            <div class="col-lg-4">

                <!-- Publish settings -->
                <div class="card mb-4">
                    <div class="card-header fw-semibold">
                        <i class="fas fa-cog me-2"></i>Publish Settings
                    </div>
                    <div class="card-body">

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Status</label>
                            <select class="form-select @error('status') is-invalid @enderror" wire:model.defer="status">
                                <option value="draft">Draft</option>
                                <option value="published">Published</option>
                            </select>
                            @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Publish Date &amp; Time</label>
                            <input type="datetime-local"
                                   class="form-control @error('published_at') is-invalid @enderror"
                                   wire:model.defer="published_at">
                            <div class="form-text">Leave blank to publish immediately when status is set to Published.</div>
                            @error('published_at')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="is_featured" wire:model.defer="is_featured">
                            <label class="form-check-label" for="is_featured">
                                <i class="fas fa-star me-1 text-warning"></i>Mark as featured
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Source & Author -->
                <div class="card mb-4">
                    <div class="card-header fw-semibold">
                        <i class="fas fa-building me-2"></i>Source &amp; Author
                    </div>
                    <div class="card-body">

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Source</label>
                            <input type="text"
                                   class="form-control @error('source') is-invalid @enderror"
                                   wire:model.defer="source"
                                   placeholder="e.g. WCI HQ, Bishop's Office, Local Assembly">
                            @error('source')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-0">
                            <label class="form-label fw-semibold">Display Author Name</label>
                            <input type="text"
                                   class="form-control @error('author_name') is-invalid @enderror"
                                   wire:model.defer="author_name"
                                   placeholder="Optional name shown on the post">
                            @error('author_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>

                <!-- Feature Image -->
                <div class="card mb-4">
                    <div class="card-header fw-semibold">
                        <i class="fas fa-image me-2"></i>Feature Image
                    </div>
                    <div class="card-body">
                        <div class="mb-0">
                            <label class="form-label fw-semibold">Upload Image</label>
                            <input type="file"
                                   class="form-control @error('image') is-invalid @enderror"
                                   wire:model="image"
                                   accept="image/*">
                            <div class="form-text">JPG, PNG, or GIF — max 5MB.</div>
                            @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror

                            @if($image)
                                <div class="mt-3">
                                    <p class="small text-muted mb-1"><i class="fas fa-check-circle text-success me-1"></i>New Image Preview:</p>
                                    <img src="{{ $image->temporaryUrl() }}" class="img-thumbnail" alt="Preview" style="max-height: 150px;">
                                </div>
                            @elseif($current_image_path)
                                <div class="mt-3 p-2 bg-light rounded small">
                                    <p class="small text-muted mb-1"><i class="fas fa-image me-1"></i>Current Image:</p>
                                    <img src="{{ asset('storage/' . $current_image_path) }}" class="img-thumbnail mb-2" alt="Current Image" style="max-height: 150px;">
                                    <div class="text-muted mt-1">Upload a new image above to replace it.</div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Attachment -->
                <div class="card">
                    <div class="card-header fw-semibold">
                        <i class="fas fa-paperclip me-2"></i>Attachment
                    </div>
                    <div class="card-body">
                        <div class="mb-0">
                            <label class="form-label fw-semibold">Upload File</label>
                            <input type="file"
                                   class="form-control @error('attachment') is-invalid @enderror"
                                   wire:model="attachment">
                            <div class="form-text">PDF, Word (doc/docx), JPG or PNG — max 5MB.</div>
                            @error('attachment')<div class="invalid-feedback">{{ $message }}</div>@enderror

                            @if($current_attachment_path)
                                <div class="mt-3 p-2 bg-light rounded small">
                                    <i class="fas fa-file me-1"></i>
                                    <strong>Current:</strong>
                                    <a href="{{ asset('storage/' . $current_attachment_path) }}" target="_blank">
                                        {{ $current_attachment_original_name ?? 'Download' }}
                                    </a>
                                    <div class="text-muted mt-1">Upload a new file above to replace it.</div>
                                </div>
                            @endif

                            @if($attachment)
                                <div class="mt-2 small text-muted">
                                    <i class="fas fa-check-circle text-success me-1"></i>
                                    Ready to upload: {{ $attachment->getClientOriginalName() }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>

@push('scripts')
<link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>
<script>
    (function () {
        let quill = null;

        function initQuill() {
            const editorEl = document.getElementById('quillEditor');
            const inputEl  = document.getElementById('bodyInput');
            if (!editorEl || !inputEl || quill) return;

            quill = new Quill('#quillEditor', {
                theme: 'snow',
                placeholder: 'Write the full content of this news item or announcement...',
                modules: {
                    toolbar: [
                        [{ header: [1, 2, 3, false] }],
                        ['bold', 'italic', 'underline', 'strike'],
                        [{ list: 'ordered' }, { list: 'bullet' }],
                        [{ indent: '-1' }, { indent: '+1' }],
                        [{ align: [] }],
                        ['blockquote'],
                        ['link'],
                        ['clean']
                    ]
                }
            });

            // Seed with existing body when editing
            const existing = inputEl.value;
            if (existing && existing.trim() !== '') {
                quill.root.innerHTML = existing;
            }

            quill.on('text-change', function () {
                const html = quill.root.innerHTML;
                inputEl.value = (html === '<p><br></p>') ? '' : html;
                inputEl.dispatchEvent(new Event('input', { bubbles: true }));
            });
        }

        // livewire:navigated fires on both initial page load and SPA navigation in Livewire v3
        document.addEventListener('livewire:navigated', function () {
            quill = null;
            initQuill();
        });
    })();
</script>
@endpush
