<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\SignDokumen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

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
        $response = Http::withoutVerifying() // ⬅️ LEWATI SSL
            ->attach(
                'signed_file',
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

    public function simpanAndDownload(Request $request)
    {
        $request->validate([
            'id_dokumen' => 'required|string',
            'nama_file'  => 'required|string|max:255',
        ]);

        try {

            $loginUser = Session::get('user_id');

            $pegawai = Pegawai::select(['no_ktp', 'nik'])->where('nik', $loginUser)->first();

            if (!$pegawai) {
                $this->dispatch('notify', [
                    'type' => 'error',
                    'message' => 'User tidak ditemukan.'
                ]);
                return;
            }

            $url = env('API_TTE') . 'sign/download/' . $request->input('id_dokumen');
            Log::info("Mengunduh dokumen dari API TTE", ['url' => $url]);
            $response = Http::withOptions(['verify' => false])->get($url);

            if (!$response->successful()) {
                Log::error("Gagal mengunduh dokumen dari API TTE", [
                    'status' => $response->status(),
                    'body'   => $response->body()
                ]);

                $this->dispatch('notify', [
                    'type' => 'error',
                    'message' => 'Gagal mengunduh dokumen yang sudah ditandatangani'
                ]);

                return;
            }

            $filename = $request->input('nama_file') . '_' . now()->timestamp . '.pdf';
            Storage::put("private/{$filename}", $response->body());

            SignDokumen::create([
                'file' => "private/{$filename}",
                'nik' => $pegawai->no_ktp,
                'nama_file' => $filename,
                'no_rawat' => null,
            ]);

            $path = storage_path("app/private/{$filename}");
            return response()->download($path, $filename)->deleteFileAfterSend(false);
        } catch (\Throwable $th) {
            Log::error("Error saat simpan dan download dokumen", ['error' => $th->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan dokumen: ' . $th->getMessage()
            ], 500);
        }
    }
}
