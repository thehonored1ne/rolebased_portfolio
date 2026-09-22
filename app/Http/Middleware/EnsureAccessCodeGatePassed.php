<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAccessCodeGatePassed
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Only guard login endpoint
        if ($request->is('login')) {
            if ($request->user()) {
                return redirect()->route('dashboard');
            }

            $isVerified = $request->session()->get('access_code_verified', false);
            $expiresAt = $request->session()->get('access_code_expires_at');

            if (! $isVerified || ! $expiresAt || now()->timestamp > $expiresAt) {
                $request->session()->forget(['access_code_verified', 'access_code_expires_at']);

                return redirect()->route('access-gate.show');
            }
        }

        return $next($request);
    }
}
