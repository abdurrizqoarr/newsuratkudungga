<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AuthCusService
{
    public static function AuthData()
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

        $user = DB::table('pegawai')->select(['nik', 'nama'])->where('nik', $session->user_id)->first();
        return $user;
    }
}
