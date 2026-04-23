<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckPengelola
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // Kalau belum login atau bukan Pengelola/Creator → logout & redirect ke login
        if (!$user || !in_array(strtolower($user->status), ['pengelola', 'creator'])) {
            Auth::logout();
            return redirect()->route('login')->withErrors([
                'akses' => 'Akses ditolak! Hanya Pengelola atau Creator yang bisa masuk.'
            ]);
        }

        return $next($request);
    }
}
