<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use App\Models\NewsUpdate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

#[Layout('layouts.admin')]
class NewsUpdateForm extends Component
{
    use WithFileUploads;

    public ?int $newsId = null;
    public bool $editMode = false;

    // Form fields
    public string $title = '';
    public string $excerpt = '';
    public string $body = '';
    public string $source = '';
    public string $author_name = '';
    public string $status = 'draft';
    public bool $is_featured = false;
    public string $published_at = '';

    public $attachment;
    public ?string $current_attachment_path = null;
    public ?string $current_attachment_original_name = null;

    public $image;
    public ?string $current_image_path = null;

    #[Title('News & Updates')]
    public function mount(?int $newsId = null): void
    {
        if ($newsId) {
            $news = NewsUpdate::findOrFail($newsId);

            $this->newsId    = $news->id;
            $this->editMode  = true;
            $this->title     = $news->title;
            $this->excerpt   = $news->excerpt ?? '';
            $this->body      = $news->body;
            $this->source    = $news->source ?? '';
            $this->author_name = $news->author_name ?? '';
            $this->status    = $news->status;
            $this->is_featured = (bool) $news->is_featured;
            $this->published_at = $news->published_at
                ? $news->published_at->format('Y-m-d\TH:i')
                : '';
            $this->current_attachment_path = $news->attachment_path;
            $this->current_attachment_original_name = $news->attachment_original_name;
            $this->current_image_path = $news->image_path;
        }
    }

    protected function rules(): array
    {
        return [
            'title'       => 'required|string|max:255',
            'excerpt'     => 'nullable|string|max:500',
            'body'        => 'required|string',
            'source'      => 'nullable|string|max:255',
            'author_name' => 'nullable|string|max:255',
            'status'      => 'required|in:draft,published',
            'is_featured' => 'boolean',
            'published_at' => 'nullable|date',
            'attachment'  => 'nullable|file|max:5120|mimes:pdf,doc,docx,jpg,jpeg,png',
            'image'       => 'nullable|image|max:5120',
        ];
    }

    protected $messages = [
        'title.required'    => 'Please provide a title.',
        'body.required'     => 'Please provide the content.',
        'attachment.mimes'  => 'Attachment must be a PDF, Word document, or image (JPG/PNG).',
        'attachment.max'    => 'Attachment size must not exceed 5MB.',
        'image.image'       => 'The feature image must be a valid image file.',
        'image.max'         => 'The feature image size must not exceed 5MB.',
    ];

    public function save(): void
    {
        $this->validate();

        $publishedAt = $this->status === 'published'
            ? ($this->published_at ?: now()->format('Y-m-d\TH:i'))
            : null;

        $attachmentPath         = $this->current_attachment_path;
        $attachmentOriginalName = $this->current_attachment_original_name;

        if ($this->attachment) {
            if ($attachmentPath && Storage::disk('public')->exists($attachmentPath)) {
                Storage::disk('public')->delete($attachmentPath);
            }
            $attachmentPath         = $this->attachment->store('news-attachments', 'public');
            $attachmentOriginalName = $this->attachment->getClientOriginalName();
        }

        $imagePath = $this->current_image_path;

        if ($this->image) {
            if ($imagePath && Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }
            $imagePath = $this->image->store('news-images', 'public');
        }

        $excerpt = $this->excerpt ?: Str::limit(strip_tags($this->body), 180);

        if ($this->editMode && $this->newsId) {
            $news = NewsUpdate::findOrFail($this->newsId);
            $news->title                    = $this->title;
            $news->excerpt                  = $excerpt;
            $news->body                     = $this->body;
            $news->source                   = $this->source;
            $news->author_name              = $this->author_name;
            $news->status                   = $this->status;
            $news->is_featured              = $this->is_featured;
            $news->published_at             = $publishedAt;
            $news->image_path               = $imagePath;
            $news->attachment_path          = $attachmentPath;
            $news->attachment_original_name = $attachmentOriginalName;
            $news->save();
            $message = 'News item updated successfully.';
        } else {
            $news = NewsUpdate::create([
                'title'                    => $this->title,
                'slug'                     => Str::slug($this->title) ?: Str::random(8),
                'excerpt'                  => $excerpt,
                'body'                     => $this->body,
                'source'                   => $this->source,
                'author_name'              => $this->author_name,
                'status'                   => $this->status,
                'is_featured'              => $this->is_featured,
                'published_at'             => $publishedAt,
                'image_path'               => $imagePath,
                'attachment_path'          => $attachmentPath,
                'attachment_original_name' => $attachmentOriginalName,
                'created_by'               => auth()->user()->email ?? 'Unknown',
            ]);

            // Ensure unique slug
            if (NewsUpdate::where('slug', $news->slug)->where('id', '!=', $news->id)->exists()) {
                $news->slug = $news->slug . '-' . $news->id;
                $news->save();
            }

            $message = 'News item created successfully.';
        }

        session()->flash('success', $message);
        $this->redirect(route('admin.news_updates'), navigate: true);
    }

    public function render()
    {
        return view('livewire.admin.news-update-form');
    }
}
