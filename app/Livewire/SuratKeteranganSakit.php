<?php

namespace App\Livewire;

use App\Models\SuratSakit;
use Livewire\Component;

class SuratKeteranganSakit extends Component
{
    public $dataSuratSakit, $search, $tgl_awal_cari, $tgl_akhir_cari;

    public function mount()
    {
        $this->tgl_awal_cari = now()->format('Y-m-d');
        $this->tgl_akhir_cari = now()->format('Y-m-d');

        $this->dataSuratSakit = SuratSakit::join('reg_periksa', 'suratsakit.no_rawat', '=', 'reg_periksa.no_rawat')
            ->join('pasien', 'reg_periksa.no_rkm_medis', '=', 'pasien.no_rkm_medis')
            ->join('poliklinik', 'reg_periksa.kd_poli', '=', 'poliklinik.kd_poli')
            ->join('dokter', 'reg_periksa.kd_dokter', '=', 'dokter.kd_dokter')
            ->select(
                'suratsakit.*',
                'reg_periksa.tgl_registrasi',
                'reg_periksa.kd_poli',
                'reg_periksa.kd_dokter',
                'reg_periksa.no_rkm_medis',
                'pasien.nm_pasien',
                'poliklinik.nm_poli',
                'dokter.nm_dokter'
            )
            ->whereBetween('reg_periksa.tgl_registrasi', [
                $this->tgl_awal_cari,
                $this->tgl_akhir_cari
            ])
            ->orderBy('reg_periksa.tgl_registrasi')
            ->get();
    }

    public function cariSurat()
    {
        $this->dataSuratSakit = SuratSakit::join('reg_periksa', 'suratsakit.no_rawat', '=', 'reg_periksa.no_rawat')
            ->join('pasien', 'reg_periksa.no_rkm_medis', '=', 'pasien.no_rkm_medis')
            ->join('poliklinik', 'reg_periksa.kd_poli', '=', 'poliklinik.kd_poli')
            ->join('dokter', 'reg_periksa.kd_dokter', '=', 'dokter.kd_dokter')
            ->select(
                'suratsakit.*',
                'reg_periksa.tgl_registrasi',
                'reg_periksa.kd_poli',
                'reg_periksa.kd_dokter',
                'reg_periksa.no_rkm_medis',
                'pasien.nm_pasien',
                'poliklinik.nm_poli',
                'dokter.nm_dokter'
            )
            ->when($this->tgl_awal_cari && $this->tgl_akhir_cari, function ($query) {
                $query->whereBetween('reg_periksa.tgl_registrasi', [
                    $this->tgl_awal_cari,
                    $this->tgl_akhir_cari
                ]);
            })
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('pasien.nm_pasien', 'like', "%{$this->search}%")
                        ->orWhere('reg_periksa.no_rkm_medis', 'like', "%{$this->search}%")
                        ->orWhere('suratsakit.no_rawat', 'like', "%{$this->search}%")
                        ->orWhere('suratsakit.no_surat', 'like', "%{$this->search}%");
                });
            })
            ->orderBy('reg_periksa.tgl_registrasi')
            ->get();
    }

    public function render()
    {
        return view('livewire.surat-keterangan-sakit');
    }
}
