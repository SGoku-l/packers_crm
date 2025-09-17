<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class NoCache
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, ...$guards): Response
    {
        $response = $next($request);

        // Prevent browser caching
        $response->headers->set('Cache-Control', 'no-cache, no-store, must-revalidate');
        $response->headers->set('Pragma', 'no-cache');
        $response->headers->set('Expires', '0');

        if ($request->hasSession() && Auth::check()) {
            $user = Auth::user();

            // If already logged in and visiting login/register, redirect
            if ($request->is('admin/login') || $request->is('admin/register')) {
                return redirect('admin/dashboard');
            }

            // Enforce single session (only on protected routes, not login/register)
            if (! $request->is('admin/login') && ! $request->is('admin/register')) {
                if (
                    $user->current_session_id &&
                    $request->session()->getId() !== $user->current_session_id
                ) {
                    Auth::logout();
                    $request->session()->invalidate();
                    $request->session()->regenerateToken();

                    return redirect('admin/login')
                        ->with('error', 'You have been logged out because another login was detected.');
                }
            }
        }

        return $response;
    }
}
