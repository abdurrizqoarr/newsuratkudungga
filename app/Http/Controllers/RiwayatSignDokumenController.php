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

        $query = SignDokumen::where('nik', $pegawai->no_ktp);

        if ($search) {
            $query->where('nama_file', 'like', '%' . $search . '%');
        }

        $signDokumens = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('riwayatDokumenSign', compact('signDokumens', 'search'));
    }

    public function downloadPrivateFile($idSign)
    {
        $signDokumen = SignDokumen::find($idSign);

        if (!$signDokumen) {
            return abort(404, 'Dokumen tidak ditemukan.');
        }

        $path = storage_path("app/{$signDokumen->file}");

        if (!file_exists($path)) {
            return abort(404, 'Dokumen tidak ditemukan.');
        }

        return response()->download($path, $signDokumen->nama_file);
    }
}
