<?php

namespace App\Livewire;

use App\Models\ResumePasienRanap;
use Livewire\Component;

class SuratResumeMedisRanap extends Component
{
    public $dataSurat, $search, $tgl_awal_cari, $tgl_akhir_cari;

    public function mount()
    {
        $this->tgl_awal_cari = now()->format('Y-m-d');
        $this->tgl_akhir_cari = now()->format('Y-m-d');

        $this->dataSurat = ResumePasienRanap::join('reg_periksa', 'resume_pasien_ranap.no_rawat', '=', 'reg_periksa.no_rawat')
            ->join('pasien', 'reg_periksa.no_rkm_medis', '=', 'pasien.no_rkm_medis')
            ->join('poliklinik', 'reg_periksa.kd_poli', '=', 'poliklinik.kd_poli')
            ->join('dokter as dokter_dpjb', 'resume_pasien_ranap.kd_dokter', '=', 'dokter_dpjb.kd_dokter')
            ->select(
                'resume_pasien_ranap.no_rawat',
                'reg_periksa.tgl_registrasi',
                'reg_periksa.no_rkm_medis',
                'pasien.nm_pasien',
                'poliklinik.nm_poli',
                'dokter_dpjb.nm_dokter as dokter_dpjb',
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
        $this->dataSurat = ResumePasienRanap::join('reg_periksa', 'resume_pasien_ranap.no_rawat', '=', 'reg_periksa.no_rawat')
            ->join('pasien', 'reg_periksa.no_rkm_medis', '=', 'pasien.no_rkm_medis')
            ->join('poliklinik', 'reg_periksa.kd_poli', '=', 'poliklinik.kd_poli')
            ->join('dokter as dokter_dpjb', 'resume_pasien_ranap.kd_dokter', '=', 'dokter_dpjb.kd_dokter')
            ->select(
                'resume_pasien_ranap.no_rawat',
                'reg_periksa.tgl_registrasi',
                'reg_periksa.no_rkm_medis',
                'pasien.nm_pasien',
                'poliklinik.nm_poli',
                'dokter_dpjb.nm_dokter as dokter_dpjb',
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
                        ->orWhere('resume_pasien_ranap.no_rawat', 'like', "%{$this->search}%")
                        ->orWhere('dokter_dpjb.nm_dokter', 'like', "%{$this->search}%");
                });
            })
            ->orderBy('reg_periksa.tgl_registrasi')
            ->get();
    }

    public function render()
    {
        return view('livewire.surat-resume-medis-ranap');
    }
}
