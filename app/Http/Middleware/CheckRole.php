<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class CheckRole
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // Debug: log middleware execution
        Log::debug('CheckRole middleware executed', ['role_param' => $role, 'url' => $request->url()]);

        if (!auth()->check()) {
            Log::debug('CheckRole: User not authenticated');
            return redirect()->route('login');
        }

        $user = auth()->user();
        Log::debug('CheckRole: User authenticated', ['user_id' => $user->id, 'role' => $user->peran]);

        // Cek status akun aktif
        if (!$user->isAktif()) {
            auth()->logout();
            return redirect()->route('login')->with('error', 'Akun Anda tidak aktif.');
        }

        // Cek role admin
        if ($role === 'admin') {
            if (!$user->isAdmin()) {
                Log::debug('CheckRole: Access denied - not admin', ['user_role' => $user->peran]);
                
                // Flash error message to session
                session()->flash('error', 'Akses ditolak! Halaman ini hanya untuk Admin.');
                
                if ($user->isSeniman()) {
                    return redirect()->route('seniman.dashboard');
                }
                abort(403, 'Akses ditolak.');
            }
        }

        // Cek role seniman
        if ($role === 'seniman') {
            if (!$user->isSeniman()) {
                Log::debug('CheckRole: Access denied - not seniman', ['user_role' => $user->peran]);
                
                // Flash error message to session
                session()->flash('error', 'Akses ditolak! Halaman ini hanya untuk Seniman.');
                
                if ($user->isAdmin()) {
                    return redirect()->route('admin.dashboard');
                }
                abort(403, 'Akses ditolak.');
            }
        }

        Log::debug('CheckRole: Access granted');
        return $next($request);
    }
}
