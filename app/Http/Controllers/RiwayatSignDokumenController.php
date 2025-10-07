<?php

namespace App\Http\Controllers;

use App\Models\SignDokumen;
use Illuminate\Http\Request;

class RiwayatSignDokumenController extends Controller
{
    public function index(Request $request)
    {
        $loginUser = session('user_id');
        $pegawai = \App\Models\Pegawai::where('nik', $loginUser)->first();
        if (!$pegawai) {
            return redirect()->back()->with('error', 'Pegawai tidak ditemukan.');
        }

        $search = $request->input('search');

        $query = SignDokumen::where('pegawai_id', $pegawai->id);

        if ($search) {
            $query->where('nama_file', 'like', '%' . $search . '%');
        }

        $signDokumens = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('riwayatDokumenSign', compact('signDokumens', 'search'));
    }
}
