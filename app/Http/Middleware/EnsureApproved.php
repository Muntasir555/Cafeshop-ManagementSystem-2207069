<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureApproved
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        // Not logged in — let other middleware handle it
        if (! $user) {
            return $next($request);
        }

        // Admins bypass the approval check entirely
        if ($user->isAdmin()) {
            return $next($request);
        }

        if ($user->isPending()) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')
                ->withErrors(['email' => 'Your account is awaiting admin approval. Please check back later.']);
        }

        if ($user->isRejected()) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')
                ->withErrors(['email' => 'Your registration has been rejected. Please contact support for assistance.']);
        }

        return $next($request);
    }
}
