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
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
            $response = $next($request);
            $response->headers->set('Cache-Control', 'no-cache, no-store, must-revalidate');
            $response->headers->set('Pragma', 'no-cache');
            $response->headers->set('Expires', '0');

            if ($request->hasSession()) {
              if (Auth::check()) {
                  $user = Auth::user();

                  // Example: if you store session_id in DB for single-login enforcement
                  if ($user->session_id && $request->session()->getId() !== $user->session_id) {
                      Auth::logout();
                      $request->session()->invalidate();
                      $request->session()->regenerateToken();

                      return redirect('/login')
                          ->with('error', 'You have been logged out because another login was detected.');
                  }
              }
          }
          return $response;
    }
}
