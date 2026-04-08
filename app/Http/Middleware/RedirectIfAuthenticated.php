<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        if (auth()->check()) {
            $user = auth()->user();
            
            // Redirect ke dashboard sesuai role
            if ($user->isAdmin()) {
                return redirect()->route('admin.dashboard');
            }
            
            if ($user->isSeniman()) {
                return redirect()->route('seniman.dashboard');
            }
        }

        return $next($request);
    }
}
