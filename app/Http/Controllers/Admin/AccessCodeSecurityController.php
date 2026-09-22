<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AccessCode;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class AccessCodeSecurityController extends Controller
{
    public function edit(): Response
    {
        return Inertia::render('Admin/Security/AccessCode');
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'code' => ['required', 'string', 'size:6', 'regex:/^[0-9]{6}$/', 'confirmed'],
        ]);

        $accessCode = AccessCode::firstOrCreate([], ['code_hash' => bcrypt('123456')]);
        $accessCode->updatePin($validated['code']);

        return back()->with('status', 'Secret access PIN updated successfully.');
    }
}
