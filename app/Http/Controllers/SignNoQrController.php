<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class SignNoQrController extends Controller
{
    public function index()
    {
        return view('warningNoQr');
    }

    public function signDokumenView()
    {
        return view('signDokumenPageNoQr');
    }

    public function handleSignDokumen(Request $request)
    {
        $request->validate([
            'signed_file'  => 'required|file|mimes:pdf|max:5120', // Maks 5MB
            'passphrase'   => 'required|string',
        ]);

        $loginUser = Session::get('user_id');

        $pegawai = Pegawai::select(['no_ktp', 'nik'])->where('nik', $loginUser)->first();

        if (!$pegawai) {
            return response()->json([
                'success' => false,
                'message' => 'User tidak ditemukan.'
            ], 404);
        }

        if (!$pegawai->no_ktp) {
            return response()->json([
                'success' => false,
                'message' => 'Pegawai Tidak Memiliki NIK.'
            ], 404);
        }

        $file = $request->file('signed_file');

        $payload = [
            'nik'         => $pegawai->no_ktp,
            'passphrase'  => $request->input('passphrase'),
        ];

        // Panggil API eksternal
        $response = Http::attach(
            'signed_file',                 // nama field file sesuai yang diminta API
            file_get_contents($file->getRealPath()),
            $file->getClientOriginalName()
        )
            ->post(env('API_TTE') . 'sign/dokumen-no-qr', $payload);

        // Balikkan response ke client
        if ($response->successful()) {
            return response()->json([
                'success' => true,
                'message' => 'Dokumen berhasil ditandatangani',
                'data'    => $response->json()
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Gagal menandatangani dokumen',
            'error'   => $response->json()
        ], $response->status());
    }
}
