<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (! auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        if (! $user->isAktif()) {
            auth()->logout();

            return redirect()->route('login')->with('error', 'Akun Anda tidak aktif.');
        }

        if ($role === 'admin' && ! $user->isAdmin()) {
            if ($user->isSeniman()) {
                return redirect()->route('seniman.dashboard')->with('error', 'Akses ditolak.');
            }

            abort(403, 'Akses ditolak.');
        }

        if ($role === 'seniman' && ! $user->isSeniman()) {
            if ($user->isAdmin()) {
                return redirect()->route('admin.dashboard')->with('error', 'Akses ditolak.');
            }

            abort(403, 'Akses ditolak.');
        }

        return $next($request);
    }
}
