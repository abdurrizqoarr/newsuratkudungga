<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticatedCustom
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

    public function handle(Request $request, Closure $next)
    {
        // Ambil token dan user_id dari session
        $token = Session::get('session_token');
        $userId = Session::get('user_id');

        // Jika ada session, cek validasi di DB
        if ($token && $userId) {
            $session = DB::table('session_user')
                ->where('user_id', $userId)
                ->where('session_token', hash('sha256', $token))
                ->first();

            // Jika sesi valid, redirect ke dashboard (atau halaman home)
            if ($session) {
                return redirect('/home');
            }
        }

        // Jika tidak ada session, lanjutkan request (boleh buka login)
        return $next($request);
    }
}
