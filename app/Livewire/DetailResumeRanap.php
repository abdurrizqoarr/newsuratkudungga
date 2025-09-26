<?php

namespace App\Livewire;

use App\Models\Pegawai;
use App\Models\ResumePasienRanap;
use App\Models\SignDokumen;
use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class DetailResumeRanap extends Component
{
    public $norawat;
    public $resume;
    public $nik;
    public $passphrase;
    public $downloadButtonStatus = false;
    public $id_dokumen = '';
    public $isUserLoggedIn;
    public $nama_pasien;
    public $signedFile;

    public function mount()
    {
        $this->norawat = request()->no_rawat;
        $this->resume = $this->loadResume();
        $this->loadSignedFile();

        if (empty($this->signedFile)) {
            $this->nama_pasien = $this->resume ? $this->resume->nm_pasien : '';
            $nik_db = Pegawai::select(['no_ktp', 'nik'])->where('nik', $this->resume->kd_dokter)->first();
            $this->nik = $nik_db ? $nik_db->no_ktp : '';
            $loginUser = Session::get('user_id');
            if ($nik_db->nik === $loginUser) {
                $this->isUserLoggedIn = true;
            } else {
                $this->isUserLoggedIn = false;
            }
        }
    }

    public function loadSignedFile()
    {
        $this->signedFile = SignDokumen::where('no_rawat', 'ranap_' . $this->norawat)->first();
    }

    public function loadResume()
    {
        return ResumePasienRanap::select(
            'resume_pasien_ranap.*',
            'reg_periksa.tgl_registrasi',
            'reg_periksa.no_rkm_medis',
            'pasien.nm_pasien',
            'poliklinik.nm_poli',
            'dokter_dpjb.nm_dokter as dokter_dpjb',
        )
            ->where('resume_pasien_ranap.no_rawat', request()->no_rawat)
            ->join('reg_periksa', 'resume_pasien_ranap.no_rawat', '=', 'reg_periksa.no_rawat')
            ->join('pasien', 'reg_periksa.no_rkm_medis', '=', 'pasien.no_rkm_medis')
            ->join('poliklinik', 'reg_periksa.kd_poli', '=', 'poliklinik.kd_poli')
            ->join('dokter as dokter_dpjb', 'resume_pasien_ranap.kd_dokter', '=', 'dokter_dpjb.kd_dokter')
            ->first();
    }

    public function signResumeRanap()
    {
        $this->validate([
            'nik' => 'required|string',
            'passphrase' => 'required|string',
        ]);

        try {
            $resumeMedisRalan = ResumePasienRanap::select(
                'resume_pasien_ranap.*',
                'reg_periksa.tgl_registrasi',
                'reg_periksa.no_rkm_medis',
                'pasien.nm_pasien',
                'poliklinik.nm_poli',
                'dokter_dpjb.nm_dokter as dokter_dpjb',
            )
                ->where('resume_pasien_ranap.no_rawat', $this->norawat)
                ->join('reg_periksa', 'resume_pasien_ranap.no_rawat', '=', 'reg_periksa.no_rawat')
                ->join('pasien', 'reg_periksa.no_rkm_medis', '=', 'pasien.no_rkm_medis')
                ->join('poliklinik', 'reg_periksa.kd_poli', '=', 'poliklinik.kd_poli')
                ->join('dokter as dokter_dpjb', 'resume_pasien_ranap.kd_dokter', '=', 'dokter_dpjb.kd_dokter')
                ->first()
                ->toArray();

            // payload API
            $payload = [
                'nik'        => $this->nik,
                'passphrase' => $this->passphrase,
                'resume'     => $resumeMedisRalan,
            ];

            // kirim request ke API dalam bentuk JSON
            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])->withBody(json_encode($payload, JSON_UNESCAPED_UNICODE), 'application/json')
                ->post(env('API_TTE') . 'sign/resume-ranap');

            if ($response->successful()) {
                $data = $response->json();
                $this->id_dokumen = $data['api_response']['id_dokumen'][0] ?? "";
                $this->dispatch('notify', [
                    'type' => 'success',
                    'message' => 'Data berhasil dikirim dan ditandatangani secara digital.'
                ]);
                $this->downloadButtonStatus = true;
            } else {
                Log::error("Gagal mengirim data ke API TTE", [
                    'status' => $response->status(),
                    'body'   => $response->body()
                ]);
                $this->dispatch('notify', [
                    'type' => 'error',
                    'message' => 'Gagal mengirim data: ' . $response->body()
                ]);
            }
        } catch (\Exception $e) {
            Log::error("Error saat sign dokumen", ['error' => $e->getMessage()]);
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }

    public function downloadFile()
    {
        try {
            $url = env('API_TTE') . 'sign/download/' . $this->id_dokumen;
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

            $filename = 'sign_resume_ranap_' . $this->nama_pasien . '_' . now()->timestamp . '.pdf';
            Storage::put("private/{$filename}", $response->body());

            SignDokumen::create([
                'file' => "private/{$filename}",
                'nik' => $this->nik,
                'nama_file' => $filename,
                'no_rawat' => 'ranap_' . $this->norawat,
            ]);

            $this->downloadButtonStatus = false;
            $this->isUserLoggedIn = false;
            $this->loadSignedFile();

            $this->dispatch('notify', [
                'type' => 'success',
                'message' => 'Dokumen berhasil disimpan secara private'
            ]);
        } catch (\Exception $e) {
            Log::error("Error saat download dokumen", ['error' => $e->getMessage()]);
            $this->downloadButtonStatus = false;

            $this->dispatch('notify', [
                'type' => 'error',
                'message' => 'Terjadi kesalahan saat menyimpan dokumen'
            ]);
        }
    }

    public function downloadFileResume()
    {
        if (!empty($this->signedFile)) {
            return Storage::download($this->signedFile->file, $this->signedFile->nama_file);
        }
        $this->dispatch('notify', [
            'type' => 'error',
            'message' => 'File belum tersedia, silakan tanda tangani terlebih dahulu.'
        ]);
        return;
    }

    public function render()
    {
        return view('livewire.detail-resume-ranap');
    }
}
