<?php

namespace App\Livewire;

use App\Models\KonsultasiMedik;
use Livewire\Component;

class SuratKonsultasiMedik extends Component
{
    public $dataSurat, $search, $tgl_awal_cari, $tgl_akhir_cari;

    public function mount()
    {
        $this->tgl_awal_cari = now()->format('Y-m-d');
        $this->tgl_akhir_cari = now()->format('Y-m-d');

        $this->dataSurat = KonsultasiMedik::join('reg_periksa', 'konsultasi_medik.no_rawat', '=', 'reg_periksa.no_rawat')
            ->join('pasien', 'reg_periksa.no_rkm_medis', '=', 'pasien.no_rkm_medis')
            ->join('poliklinik', 'reg_periksa.kd_poli', '=', 'poliklinik.kd_poli')
            ->join('dokter as dokter_pengirim', 'konsultasi_medik.kd_dokter', '=', 'dokter_pengirim.kd_dokter')
            ->join('dokter as dokter_dikonsuli', 'konsultasi_medik.kd_dokter_dikonsuli', '=', 'dokter_dikonsuli.kd_dokter')
            ->leftJoin('jawaban_konsultasi_medik', 'konsultasi_medik.no_permintaan', '=', 'jawaban_konsultasi_medik.no_permintaan')
            ->select(
                'konsultasi_medik.*',
                'reg_periksa.tgl_registrasi',
                'reg_periksa.kd_poli',
                'reg_periksa.no_rkm_medis',
                'pasien.nm_pasien',
                'poliklinik.nm_poli',
                'dokter_pengirim.nm_dokter as dokter_pengirim',
                'dokter_dikonsuli.nm_dokter as dokter_dikonsuli',
                'jawaban_konsultasi_medik.diagnosa_kerja as jawaban_diagnosa_kerja'
            )
            ->whereBetween('reg_periksa.tgl_registrasi', [
                $this->tgl_awal_cari,
                $this->tgl_akhir_cari
            ])
            ->orderBy('konsultasi_medik.tanggal')
            ->get();
    }

    public function cariSurat()
    {
        $this->dataSurat = KonsultasiMedik::join('reg_periksa', 'konsultasi_medik.no_rawat', '=', 'reg_periksa.no_rawat')
            ->join('pasien', 'reg_periksa.no_rkm_medis', '=', 'pasien.no_rkm_medis')
            ->join('poliklinik', 'reg_periksa.kd_poli', '=', 'poliklinik.kd_poli')
            ->join('dokter as dokter_pengirim', 'konsultasi_medik.kd_dokter', '=', 'dokter_pengirim.kd_dokter')
            ->join('dokter as dokter_dikonsuli', 'konsultasi_medik.kd_dokter_dikonsuli', '=', 'dokter_dikonsuli.kd_dokter')
            ->leftJoin('jawaban_konsultasi_medik', 'konsultasi_medik.no_permintaan', '=', 'jawaban_konsultasi_medik.no_permintaan')
            ->select(
                'konsultasi_medik.*',
                'reg_periksa.tgl_registrasi',
                'reg_periksa.kd_poli',
                'reg_periksa.no_rkm_medis',
                'pasien.nm_pasien',
                'poliklinik.nm_poli',
                'dokter_pengirim.nm_dokter as dokter_pengirim',
                'dokter_dikonsuli.nm_dokter as dokter_dikonsuli',
                'jawaban_konsultasi_medik.diagnosa_kerja as jawaban_diagnosa_kerja'
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
                        ->orWhere('konsultasi_medik.no_rawat', 'like', "%{$this->search}%");
                });
            })
            ->orderBy('konsultasi_medik.tanggal')
            ->get();
    }

    public function render()
    {
        return view('livewire.surat-konsultasi-medik');
    }
}
