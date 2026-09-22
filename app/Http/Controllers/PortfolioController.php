<?php

namespace App\Http\Controllers;

use App\Http\Requests\Public\ContactSubmissionRequest;
use App\Models\ContactMessage;
use App\Models\Experience;
use App\Models\PortfolioProfile;
use App\Models\Project;
use App\Models\Skill;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class PortfolioController extends Controller
{
    /**
     * Display the dynamic guest portfolio showcase.
     */
    public function index(Request $request): Response
    {
        $profile = PortfolioProfile::firstOrCreate(['id' => 1]);

        $featuredProjects = Project::where('is_featured', true)
            ->orderBy('sort_order')
            ->orderByDesc('created_at')
            ->get();

        $allProjects = Project::orderBy('sort_order')
            ->orderByDesc('created_at')
            ->get();

        $skills = Skill::orderBy('sort_order')
            ->orderBy('name')
            ->get()
            ->groupBy('category');

        $experiences = Experience::orderBy('sort_order')
            ->orderByDesc('created_at')
            ->get();

        return Inertia::render('Welcome', [
            'profile' => $profile,
            'featuredProjects' => $featuredProjects,
            'allProjects' => $allProjects,
            'skills' => $skills,
            'experiences' => $experiences,
            'status' => $request->session()->get('status'),
            'isAdmin' => (bool) $request->user(),
        ]);
    }

    /**
     * Process contact form submissions from guests.
     */
    public function contact(ContactSubmissionRequest $request): RedirectResponse
    {
        // Honeypot check
        if (! empty($request->input('website_hp'))) {
            return back()->with('status', 'Your message has been received.');
        }

        ContactMessage::create([
            'name' => $request->validated('name'),
            'email' => $request->validated('email'),
            'subject' => $request->validated('subject'),
            'message' => $request->validated('message'),
            'ip_address' => $request->ip(),
        ]);

        return back()->with('status', 'Thank you! Your message has been sent successfully.');
    }
}
