<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureFaceIsEnrolled
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();

            // Admins are exempt from face enrollment
            if ($user->role === 'admin') {
                return $next($request);
            }

            $onEnrollmentRoute = $request->routeIs('face.enrollment') || $request->routeIs('face.enrollment.store');
            $onLogoutRoute = $request->routeIs('logout');

            if (!$user->is_face_enrolled) {
                if (!$onEnrollmentRoute && !$onLogoutRoute) {
                    return redirect()->route('face.enrollment');
                }
            } else {
                if ($onEnrollmentRoute) {
                    return redirect('/');
                }
            }
        }

        return $next($request);
    }
}
