<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  $role  The required role (e.g., 'doctor', 'admin')
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // 1. Check if the user is authenticated at all.
        if (!Auth::check()) {
            // If not authenticated, redirect them to the login page.
            return redirect('/login');
        }

        // --- DEBUG: Log the values being compared to help solve the redirection loop ---
        // This line will write the actual user role and the required role to your storage/logs/laravel.log file.
        // This is a powerful step to reveal database mismatches (e.g., 'Doctor' vs 'doctor').
        Log::info('Role Check Debug:', [
            'User ID' => Auth::id(), 
            'User Role (DB)' => Auth::user()->role, 
            'Required Role (Route)' => $role
        ]);

        // 2. Check if the authenticated user's 'role' matches the required role.
        // We use the authenticated user's object directly.
        if (Auth::user()->role !== $role) {
            // If the role does not match, log the user out and redirect with an error.
            // This prevents access by doctors impersonating admins, etc.
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            
            // Redirect them to login or an error page.
            // Using back() might cause issues; redirecting to a named route is safer.
            return redirect()->route('login')->withErrors(['unauthorized' => 'Access denied due to insufficient role permissions.']);
        }
        
        // If checks pass, proceed to the requested route.
        return $next($request);
    }
}
