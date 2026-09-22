<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateProfileRequest;
use App\Models\PortfolioProfile;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class PortfolioProfileController extends Controller
{
    /**
     * Show the profile editor view.
     */
    public function edit(): Response
    {
        $profile = PortfolioProfile::firstOrCreate(['id' => 1]);

        return Inertia::render('Admin/ProfileEditor', [
            'profile' => $profile,
        ]);
    }

    /**
     * Update the portfolio profile content.
     */
    public function update(UpdateProfileRequest $request): RedirectResponse
    {
        $profile = PortfolioProfile::firstOrCreate(['id' => 1]);
        $profile->update($request->validated());

        return back()->with('status', 'Portfolio profile updated successfully.');
    }
}
