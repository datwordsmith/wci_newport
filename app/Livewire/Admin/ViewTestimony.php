<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use App\Models\Testimony;
use Illuminate\Support\Facades\Mail;

#[Layout('layouts.admin')]
class ViewTestimony extends Component
{
    #[Title('Review Testimony')]

    public Testimony $testimony;
    public $adminFeedback = '';

    // Modal states
    public $showApproveModal = false;
    public $showDeclineModal = false;
    public $showResetModal = false;

    public function mount($id)
    {
        $this->testimony = Testimony::findOrFail($id);
        $this->adminFeedback = $this->testimony->admin_feedback ?? '';
    }

    public function openApproveModal()
    {
        $this->showApproveModal = true;
    }

    public function openDeclineModal()
    {
        $this->showDeclineModal = true;
    }

    public function openResetModal()
    {
        $this->showResetModal = true;
    }

    public function closeModals()
    {
        $this->showApproveModal = false;
        $this->showDeclineModal = false;
        $this->showResetModal = false;
    }

    public function approveTestimony()
    {
        $this->testimony->approve(auth()->user()->email ?? 'admin@wci.org');

        // TODO: Send approval email to testifier
        $this->sendApprovalEmail($this->testimony);

        session()->flash('success', 'Testimony approved successfully!');
        $this->closeModals();
        return redirect()->route('admin.testimonies.manage');
    }

    public function declineTestimony()
    {
        $this->validate([
            'adminFeedback' => 'required|string|min:10'
        ], [
            'adminFeedback.required' => 'Please provide feedback for declining this testimony.',
            'adminFeedback.min' => 'Feedback must be at least 10 characters long.'
        ]);

        $this->testimony->decline(auth()->user()->email ?? 'admin@wci.org', $this->adminFeedback);

        // TODO: Send decline email with feedback to testifier
        $this->sendDeclineEmail($this->testimony);

        session()->flash('success', 'Testimony declined and feedback sent to the author.');
        $this->closeModals();
        return redirect()->route('admin.testimonies.manage');
    }

    public function resetToPending()
    {
        $this->testimony->resetToPending();

        session()->flash('success', 'Testimony status reset to pending review.');
        $this->closeModals();
        return redirect()->route('admin.testimonies.manage');
    }

    private function sendApprovalEmail($testimony)
    {
        // TODO: Implement email sending for approval
        // Mail::to($testimony->email)->send(new TestimonyApproved($testimony));
    }

    private function sendDeclineEmail($testimony)
    {
        // TODO: Implement email sending for decline with feedback
        // Mail::to($testimony->email)->send(new TestimonyDeclined($testimony));
    }

    public function render()
    {
        return view('livewire.admin.view-testimony');
    }
}
