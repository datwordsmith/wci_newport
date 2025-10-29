<?php

namespace App\Livewire\Admin;

use App\Models\Testimony;
use App\Models\TestimonyImage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateTestimony extends Component
{
    use WithFileUploads;

    public string $title = '';
    public string $author = '';
    public string $email = '';
    public ?string $phone = null;
    public string $result_category = '';
    public ?string $testimony_date = null; // Y-m-d
    public array $engagements = [];
    public string $content = '';
    public bool $publish_permission = true;
    public string $status = 'approved';

    /** @var array<int, \Livewire\Features\SupportFileUploads\TemporaryUploadedFile> */
    public array $images = [];
    public array $imageCaptions = [];

    // Reference lists aligned with public submission page
    public function getResultCategoriesProperty(): array
    {
        return [
            'Healing' => 'Healing',
            'Breakthrough' => 'Breakthrough',
            'Restoration' => 'Restoration',
            'Provision' => 'Provision',
            'Protection' => 'Protection',
            'Favour' => 'Favour',
            'Deliverance' => 'Deliverance',
            'Success' => 'Success',
            'Family' => 'Family',
            'Other' => 'Other',
        ];
    }

    public function getEngagementTypesProperty(): array
    {
        return [
            'Prayer' => 'Prayer',
            'Anointing' => 'Anointing',
            'Communion' => 'Communion',
            'Kingdom Service' => 'Kingdom Service',
            'Sowing of Seed' => 'Sowing of Seed',
            'Fasting' => 'Fasting',
            'Mantle' => 'Mantle',
            'Evangelism' => 'Evangelism',
        ];
    }

    protected function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'author' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
            'result_category' => ['required', Rule::in(array_keys($this->resultCategories))],
            'testimony_date' => ['nullable', 'date', 'before_or_equal:today'],
            'engagements' => ['array'],
            'engagements.*' => [Rule::in(array_keys($this->engagementTypes))],
            'content' => ['required', 'string', 'min:50'],
            'publish_permission' => ['boolean'],
            'status' => ['required', Rule::in(['pending', 'approved', 'declined'])],
            'images.*' => ['nullable', 'image', 'max:2048'], // 2MB
        ];
    }

    public function updatedImages(): void
    {
        // Enforce max 3 total images
        if (count($this->images) > 3) {
            $this->images = array_slice($this->images, 0, 3);
            session()->flash('warning', 'Maximum of 3 images allowed. Extra images were ignored.');
        }
        $this->validateOnly('images.*');
    }

    public function save()
    {
        $validated = $this->validate();

        $testimony = Testimony::create([
            'title' => $this->title,
            'author' => $this->author,
            'email' => $this->email,
            'phone' => $this->phone,
            'result_category' => $this->result_category,
            'testimony_date' => $this->testimony_date,
            'engagements' => $this->engagements,
            'content' => $this->content,
            'publish_permission' => $this->publish_permission,
            'status' => $this->status,
            'reviewed_at' => in_array($this->status, ['approved', 'declined']) ? now() : null,
            'approved_by_email' => in_array($this->status, ['approved', 'declined']) ? (Auth::user()->email ?? null) : null,
        ]);

        // Handle images
        $this->storeImages($testimony);

        session()->flash('success', 'Testimony created successfully.');
        return redirect()->route('admin.testimonies.manage');
    }

    protected function storeImages(Testimony $testimony): void
    {
        if (empty($this->images)) {
            return;
        }

        $order = 1;
        foreach ($this->images as $index => $image) {
            // Use same folder as public submissions for consistency
            $path = $image->store('testimony-images', 'public');

            TestimonyImage::create([
                'testimony_id' => $testimony->id,
                'image' => $path,
                'caption' => $this->imageCaptions[$index] ?? null,
                'sort_order' => $order++,
                'is_approved' => true, // admin-uploaded defaults to approved
            ]);
        }
    }

    #[Layout('layouts.admin')]
    public function render()
    {
        return view('livewire.admin.create-testimony');
    }
}
