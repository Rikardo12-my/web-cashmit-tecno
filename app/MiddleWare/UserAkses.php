<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserAkses
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        $userRole = $user->role ?? $user->jenis ?? null;
        if (!$userRole) {
            Auth::logout();
            return redirect()->route('login')->withErrors([
                'akses' => 'Akun Anda tidak memiliki role yang valid.'
            ]);
        }
        if (!in_array($userRole, $roles)) {
            Auth::logout();
            return redirect()->route('login')
                ->withErrors(['akses' => 'Anda tidak memiliki akses ke halaman ini']);
        }

        return $next($request);
    }
}
