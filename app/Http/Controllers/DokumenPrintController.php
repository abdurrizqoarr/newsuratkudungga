<?php

namespace App\Http\Controllers;

use App\Models\KonsultasiMedik;
use App\Models\SuratSakit;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DokumenPrintController extends Controller
{
    public function printSuratSakit($noSurat)
    {
        $dataSuratSakit = SuratSakit::join('reg_periksa', 'suratsakit.no_rawat', '=', 'reg_periksa.no_rawat')
            ->join('pasien', 'reg_periksa.no_rkm_medis', '=', 'pasien.no_rkm_medis')
            ->join('dokter', 'reg_periksa.kd_dokter', '=', 'dokter.kd_dokter')
            ->select(
                'suratsakit.*',
                'reg_periksa.tgl_registrasi',
                'reg_periksa.kd_poli',
                'reg_periksa.kd_dokter',
                'reg_periksa.no_rkm_medis',
                'pasien.nm_pasien',
                'pasien.tmp_lahir',
                'pasien.tgl_lahir',
                'dokter.nm_dokter'
            )
            ->where('no_surat', $noSurat)
            ->orderBy('reg_periksa.tgl_registrasi')
            ->first();

        $today = Carbon::today();
        $tanggal = $today->format('d'); // Tanggal (contoh: 25)
        $bulan = $today->locale('id')->translatedFormat('F');   // Bulan (contoh: 03)
        $tahun = $today->format('Y');

        return view('suratKeteranganSakit', [
            'data' => $dataSuratSakit,
            'tanggal' => $tanggal,
            'bulan' => $bulan,
            'tahun' => $tahun
        ]);
    }

    public function printDokumenKonsultasi($noSurat)
    {
        $dataKonsultasi = KonsultasiMedik::join('reg_periksa', 'konsultasi_medik.no_rawat', '=', 'reg_periksa.no_rawat')
            ->join('pasien', 'reg_periksa.no_rkm_medis', '=', 'pasien.no_rkm_medis')
            ->join('poliklinik', 'reg_periksa.kd_poli', '=', 'poliklinik.kd_poli')
            ->join('dokter as dokter_pengirim', 'konsultasi_medik.kd_dokter', '=', 'dokter_pengirim.kd_dokter')
            ->join('dokter as dokter_dikonsuli', 'konsultasi_medik.kd_dokter_dikonsuli', '=', 'dokter_dikonsuli.kd_dokter')
            ->join('jawaban_konsultasi_medik', 'konsultasi_medik.no_permintaan', '=', 'jawaban_konsultasi_medik.no_permintaan')
            ->select(
                'konsultasi_medik.*',
                'reg_periksa.tgl_registrasi',
                'reg_periksa.kd_poli',
                'reg_periksa.no_rkm_medis',
                'pasien.nm_pasien',
                'pasien.jk',
                'pasien.tgl_lahir',
                'poliklinik.nm_poli',
                'dokter_pengirim.nm_dokter as dokter_pengirim',
                'dokter_dikonsuli.nm_dokter as dokter_dikonsuli',
                'jawaban_konsultasi_medik.diagnosa_kerja as jawaban_diagnosa_kerja',
                'jawaban_konsultasi_medik.uraian_jawaban'
            )
            ->where('konsultasi_medik.no_permintaan', $noSurat)
            ->first();

        $today = Carbon::today();
        $tanggal = $today->format('d'); // Tanggal (contoh: 25)
        $bulan = $today->locale('id')->translatedFormat('F');   // Bulan (contoh: 03)
        $tahun = $today->format('Y');

        // dd($dataKonsultasi);
        return view('dokumenKonsultasi', [
            'data' => $dataKonsultasi,
            'tanggal' => $tanggal,
            'bulan' => $bulan,
            'tahun' => $tahun
        ]);
    }
}
