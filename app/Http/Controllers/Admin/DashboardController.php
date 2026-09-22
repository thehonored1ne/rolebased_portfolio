<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\Experience;
use App\Models\PortfolioProfile;
use App\Models\Project;
use App\Models\Skill;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    /**
     * Render the admin CMS dashboard.
     */
    public function index(): Response
    {
        $stats = [
            'unread_messages' => ContactMessage::where('is_read', false)->count(),
            'total_messages' => ContactMessage::count(),
            'total_projects' => Project::count(),
            'total_skills' => Skill::count(),
            'total_experiences' => Experience::count(),
        ];

        $recentMessages = ContactMessage::orderByDesc('created_at')->take(5)->get();
        $profile = PortfolioProfile::firstOrCreate(['id' => 1]);

        return Inertia::render('Admin/Dashboard', [
            'stats' => $stats,
            'recentMessages' => $recentMessages,
            'profile' => $profile,
        ]);
    }
}
