<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use function Laravel\Prompts\select;

class AntrianController extends Controller
{
    public function indexAntrian()
    {
        $hari = [
            "SENIN",
            "SELASA",
            'RABU',
            "KAMIS",
            "JUMAT",
            "SABTU",
            "AKHAD"
        ];

        $today = strtoupper(Carbon::now()->locale('id')->dayName);

        // Cocokkan dengan array $hari
        if (!in_array($today, $hari)) {
            $today = "SENIN"; // default kalau tidak cocok
        }

        $jadwal = DB::table('jadwal')
            ->select(['nm_poli', 'nama', 'hari_kerja', 'jam_mulai', 'jadwal.kd_dokter', 'jadwal.kd_poli'])
            ->where('hari_kerja', $today)
            ->join('pegawai', 'pegawai.nik', '=', 'jadwal.kd_dokter')
            ->join('poliklinik', 'poliklinik.kd_poli', '=', 'jadwal.kd_poli')
            ->orderBy('pegawai.nama')
            ->get();

        return view('antrian-index', ['jadwal' => $jadwal, 'today' => $today]);
    }

    public function jadwalKlinikApi(Request $request)
    {
        $pasien = DB::table('reg_periksa')
            ->select(['nm_pasien'])
            ->join('pasien', 'pasien.no_rkm_medis', '=', 'reg_periksa.no_rkm_medis')
            ->where('kd_dokter', $request->dokter)
            ->where('kd_poli', $request->poli)
            ->where('tgl_registrasi', now()->format('Y-m-d'))
            ->whereIn('reg_periksa.stts', ['Belum', 'Berkas Diterima'])
            ->orderBy('reg_periksa.jam_reg')
            ->get();

        return response()->json(['data' => $pasien]);
    }

    public function jadwalKlinik(Request $request)
    {
        $poliData = DB::table('poliklinik')->where('kd_poli', $request->poli)->first();
        return view('antrian-poli', ['dokter' => $request->dokter, 'poli' => $poliData]);
    }
}
