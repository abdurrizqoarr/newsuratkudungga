<?php

namespace App\Http\Controllers;

use App\Http\Services\AuthCusService;
use App\Models\RegPeriksa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    private $userKey = 'nur'; // Key untuk dekripsi username
    private $passwordKey = 'windi';

    public function loginPage()
    {
        return view('auth.login');
    }

    public function handleLogin(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = DB::table('user')
            ->selectRaw("AES_DECRYPT(id_user, ?) AS id_user, AES_DECRYPT(password, ?) AS password", [$this->userKey, $this->passwordKey])
            ->whereRaw("AES_DECRYPT(id_user, ?) = ?", [$this->userKey, $request->username])
            ->first();


        if (!$user || $user->password !== $request->password) {
            return back()->withErrors(['login' => 'Username atau password salah']);
        }

        $token = Str::random(60);

        DB::table('session_user')->insert([
            'user_id'      => $user->id_user,
            'session_token' => hash('sha256', $token),
            'ip_address'   => $request->ip(),
            'user_agent'   => $request->header('User-Agent'),
            'last_activity' => now(),
        ]);

        Session::put('session_token', $token);
        Session::put('user_id', $user->id_user);

        return redirect()->route('menuOptionsPage');
    }

    public function menuOptionsPage(Request $request)
    {
        $user = AuthCusService::AuthData();
        return view('menuOptionsPage', ['user' => $user]);
    }

    public function logout(Request $request)
    {
        $token = Session::get('session_token');

        if ($token) {
            DB::table('session_user')->where('session_token', hash('sha256', $token))->delete();
        }

        Session::flush(); // hapus session dari Laravel
        return redirect('/login');
    }
}
