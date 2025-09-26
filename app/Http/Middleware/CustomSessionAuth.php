<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class CustomSessionAuth
{
    public function handle($request, Closure $next)
    {
        $token = Session::get('session_token');
        $userId = Session::get('user_id');

        if (!$token || !$userId) {
            return redirect('/login');
        }

        $session = DB::table('session_user')
            ->where('user_id', $userId)
            ->where('session_token', hash('sha256', $token))
            ->first();

        if (!$session) {
            Session::flush();
            return redirect('/login');
        }

        // ✅ Cek jika last_activity lebih dari 3 jam
        if (now()->diffInHours($session->last_activity) >= 3) {
            // Hapus sesi dari database atau biarkan
            DB::table('session_user')->where('id', $session->id)->delete();

            Session::flush();
            return redirect('/login')->with('error', 'Sesi Anda telah berakhir. Silakan login kembali.');
        }

        // ✅ Update last_activity jika belum kadaluarsa
        DB::table('session_user')
            ->where('id', $session->id)
            ->update(['last_activity' => now()]);

        return $next($request);
    }
}
