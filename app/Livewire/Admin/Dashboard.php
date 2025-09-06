<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Testimony;
use App\Models\User;
use App\Models\SundayService;
use App\Models\Event;

#[Layout('layouts.admin')]
class Dashboard extends Component
{
    /**
     * Gather dashboard data: stats, pending items, recent activity, system info
     */
    public function render()
    {
        $totalTestimonies   = Testimony::count();
        $approvedCount      = Testimony::approved()->count();
        $pendingCount       = Testimony::pending()->count();
        $declinedCount      = Testimony::declined()->count();
        $weekSubmissions    = Testimony::where('created_at', '>=', now()->subDays(7))->count();

        $approvalRate = $totalTestimonies > 0
            ? round(($approvedCount / $totalTestimonies) * 100)
            : 0;

        // Average review time (seconds) based on a sample to avoid heavy queries
        $avgReviewSeconds = Testimony::whereNotNull('reviewed_at')
            ->latest('reviewed_at')
            ->limit(50)
            ->get()
            ->map(function ($t) {
                return $t->reviewed_at ? $t->reviewed_at->diffInSeconds($t->created_at) : null;
            })
            ->filter()
            ->avg() ?? 0;

        $stats = [
            'total' => $totalTestimonies,
            'approved' => $approvedCount,
            'pending' => $pendingCount,
            'declined' => $declinedCount,
            'week_submissions' => $weekSubmissions,
            'approval_rate' => $approvalRate,
            'avg_review_seconds' => (int) $avgReviewSeconds,
            'users_total' => User::count(),
            'users_by_role' => [
                'super_admin' => User::where('role', User::ROLE_SUPER_ADMIN)->count(),
                'administrator' => User::where('role', User::ROLE_ADMINISTRATOR)->count(),
                'editor' => User::where('role', User::ROLE_EDITOR)->count(),
                'moderator' => User::where('role', User::ROLE_MODERATOR)->count(),
            ],
        ];

        $pendingTestimonies = Testimony::pending()->latest()->take(5)->get();
        $recentReviewed     = Testimony::whereIn('status', ['approved', 'declined'])
            ->whereNotNull('reviewed_at')
            ->latest('reviewed_at')
            ->take(5)
            ->get();
        $recentUsers        = User::latest()->take(5)->get();

        // Latest Sunday Service (prefer upcoming, else most recent past)
        $latestService = SundayService::whereDate('service_date', '>=', now()->toDateString())
            ->orderBy('service_date', 'asc')
            ->first();
        if (!$latestService) {
            $latestService = SundayService::orderBy('service_date', 'desc')->first();
        }

        // Next upcoming event
        $upcomingEvent = Event::upcoming()->orderBy('event_date', 'asc')->first();

        return view('livewire.admin.dashboard', compact(
            'stats',
            'pendingTestimonies',
            'recentReviewed',
            'recentUsers',
            'latestService',
            'upcomingEvent'
        ));
    }
}
