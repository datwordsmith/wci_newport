<?php

namespace App\Livewire\Public;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Rule;
use App\Models\ContactMessage;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Mail;
use App\Notifications\ContactMessageAlert;
use Illuminate\Support\Facades\Notification;

#[Layout('layouts.main')]
class Contact extends Component
{
    #[Title('Contact Us')]
    public $description = "Get in touch with us for any inquiries or support";

    // Form fields with validation rules
    public $name = '';
    public $email = '';
    public $phone = '';
    public $subject = '';
    public $category = '';
    public $message = '';

    public $isSubmitting = false;

    // Predefined category options
    public $categoryOptions = [
        'giving' => 'Giving',
        'wsf' => 'WSF (Winners Satellite Fellowship)',
        'service_unit' => 'Service Unit',
        'programmes_events' => 'Programmes/Events',
        'testimonies' => 'Testimonies',
        'general' => 'General Inquiry'
    ];

    protected function rules()
    {
        return [
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:100',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:100',
            'category' => 'required|string|in:giving,wsf,service_unit,programmes_events,testimonies,general',
            'message' => 'required|string|min:10|max:1000',
        ];
    }

    protected $messages = [
        'name.required' => 'Please enter your full name.',
        'name.max' => 'Name cannot be longer than 100 characters.',
        'email.required' => 'Please enter your email address.',
        'email.email' => 'Please enter a valid email address.',
        'email.max' => 'Email cannot be longer than 100 characters.',
        'phone.max' => 'Phone number cannot be longer than 20 characters.',
        'subject.required' => 'Please enter a subject for your message.',
        'subject.max' => 'Subject cannot be longer than 100 characters.',
        'category.required' => 'Please select a message category.',
        'category.in' => 'Please select a valid category.',
        'message.required' => 'Please enter your message.',
        'message.min' => 'Your message must be at least 10 characters long.',
        'message.max' => 'Your message cannot be longer than 1000 characters.',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function submitForm()
    {
        $validated = $this->validate();
        $this->isSubmitting = true;

        try {
            // Save the message to the database
            $contactMessage = ContactMessage::create([
                'name' => $this->name,
                'email' => $this->email,
                'phone' => $this->phone,
                'subject' => $this->subject,
                'category' => $this->category,
                'message' => $this->message
            ]);

            // Get users with administrator role
            $admins = User::where('role', ['super_admin','administrator'])->get();

            $admins->each->notify(new ContactMessageAlert($contactMessage));

            // Reset form fields
            $this->resetForm();

            // Use toastr for success
            $this->dispatch('toastr-success', 'Your message has been sent successfully. We will get back to you soon.');
            $this->dispatch('contact-message-sent');

        } catch (\Exception $e) {
            // Use toastr for error
            $this->dispatch('toastr-error', 'Sorry, there was a problem submitting your message. Please try again.');
            // log the error
            \Log::error('Contact form submission error: ' . $e->getMessage());
        } finally {
            $this->isSubmitting = false;
        }
    }

    public function resetForm()
    {
        $this->reset(['name', 'email', 'phone', 'subject', 'category', 'message']);
        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.public.contact');
    }
}
