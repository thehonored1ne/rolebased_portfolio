<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\AccessCodeResetMail;
use App\Models\AccessCode;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class AccessCodeController extends Controller
{
    /**
     * Display the access code verification view.
     */
    public function show(Request $request): Response|RedirectResponse
    {
        if ($request->user()) {
            return redirect()->route('dashboard');
        }

        return Inertia::render('auth/AccessCodeGate', [
            'status' => $request->session()->get('status'),
        ]);
    }

    /**
     * Verify the 6-digit access PIN.
     */
    public function verify(Request $request): RedirectResponse
    {
        $throttleKey = 'access-code-gate:'.$request->ip();

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);

            return back()->withErrors([
                'code' => "Too many incorrect attempts. Please wait {$seconds} seconds before trying again.",
            ]);
        }

        $validated = $request->validate([
            'code' => ['required', 'string', 'size:6', 'regex:/^[0-9]{6}$/'],
        ]);

        if (! AccessCode::checkCode($validated['code'])) {
            RateLimiter::hit($throttleKey, 60);

            $accessCode = AccessCode::first();
            if ($accessCode) {
                $accessCode->increment('failed_attempts');
            }

            return back()->withErrors([
                'code' => 'The provided access PIN is incorrect.',
            ]);
        }

        RateLimiter::clear($throttleKey);

        $request->session()->put('access_code_verified', true);
        $request->session()->put('access_code_expires_at', now()->addMinutes(30)->timestamp);

        return redirect()->route('login');
    }

    /**
     * Send a reset link to the admin's verified email.
     */
    public function sendReset(Request $request): RedirectResponse
    {
        $throttleKey = 'access-code-reset:'.$request->ip();

        if (RateLimiter::tooManyAttempts($throttleKey, 3)) {
            $seconds = RateLimiter::availableIn($throttleKey);

            return back()->withErrors([
                'reset' => "Please wait {$seconds} seconds before requesting another reset email.",
            ]);
        }

        RateLimiter::hit($throttleKey, 300);

        $admin = User::first();
        $email = $admin?->email ?? config('mail.from.address');

        if (! $email) {
            return back()->withErrors([
                'reset' => 'No admin email is registered to receive reset instructions.',
            ]);
        }

        $token = Str::random(64);
        $accessCode = AccessCode::firstOrCreate(
            [],
            ['code_hash' => bcrypt('123456')]
        );

        $accessCode->update([
            'reset_token' => hash('sha256', $token),
            'reset_expires_at' => now()->addMinutes(30),
        ]);

        try {
            Mail::to($email)->send(
                new AccessCodeResetMail(route('access-gate.reset', ['token' => $token]))
            );
        } catch (\Throwable $e) {
            return back()->withErrors([
                'reset' => 'Failed to send reset email. Verify email configuration: '.$e->getMessage(),
            ]);
        }

        return back()->with('status', 'A reset link has been dispatched to the admin email address.');
    }

    /**
     * Display the PIN reset form.
     */
    public function showReset(string $token): Response|RedirectResponse
    {
        $accessCode = AccessCode::first();

        if (! $accessCode || ! $accessCode->reset_token || ! $accessCode->reset_expires_at) {
            return redirect()->route('access-gate.show')->withErrors([
                'code' => 'Invalid or expired reset token.',
            ]);
        }

        if (! hash_equals($accessCode->reset_token, hash('sha256', $token)) || now()->isAfter($accessCode->reset_expires_at)) {
            return redirect()->route('access-gate.show')->withErrors([
                'code' => 'This reset token has expired or is invalid.',
            ]);
        }

        return Inertia::render('auth/AccessCodeReset', [
            'token' => $token,
        ]);
    }

    /**
     * Update the access PIN using the reset token.
     */
    public function updateCode(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'token' => ['required', 'string'],
            'code' => ['required', 'string', 'size:6', 'regex:/^[0-9]{6}$/', 'confirmed'],
        ]);

        $accessCode = AccessCode::first();

        if (! $accessCode || ! $accessCode->reset_token || ! $accessCode->reset_expires_at) {
            return redirect()->route('access-gate.show')->withErrors([
                'code' => 'Invalid or expired reset request.',
            ]);
        }

        if (! hash_equals($accessCode->reset_token, hash('sha256', $validated['token'])) || now()->isAfter($accessCode->reset_expires_at)) {
            return redirect()->route('access-gate.show')->withErrors([
                'code' => 'Reset token has expired.',
            ]);
        }

        $accessCode->updatePin($validated['code']);

        return redirect()->route('access-gate.show')->with(
            'status',
            'Access PIN updated successfully. Please enter your new PIN to proceed.'
        );
    }
}
