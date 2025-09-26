<?php

namespace App\Http\Controllers;

use App\Models\ReferensiMobileJKNBPJS;
use App\Models\RegPeriksa;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CheckInController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');

        if ($search) {
            $results = ReferensiMobileJKNBPJS::query()
                ->leftJoin('pasien', 'referensi_mobilejkn_bpjs.norm', '=', 'pasien.no_rkm_medis')
                ->when($search, function ($query, $search) {
                    return $query->where(function ($q) use ($search) {
                        $q->orWhere('nomorkartu', $search)
                            ->orWhere('nik', $search)
                            ->orWhere('norm', $search)
                            ->orWhere('nobooking', $search);
                    });
                })
                ->select('referensi_mobilejkn_bpjs.*', 'pasien.nm_pasien', 'pasien.alamat')
                ->where('referensi_mobilejkn_bpjs.tanggalperiksa', today())
                ->orderByDesc('referensi_mobilejkn_bpjs.tanggalperiksa')
                ->first();

            if ($results) {
                $currentDate = Carbon::now()->format('Y-m-d');
                $currentTime = Carbon::now()->format('H:i');

                $tanggalPeriksa = $results->tanggalperiksa;
                $jamPraktek = explode('-', $results->jampraktek);


                if ($tanggalPeriksa != $currentDate || count($jamPraktek) != 2 || $currentTime < $jamPraktek[0] || $currentTime > $jamPraktek[1]) {
                    return view('welcome', ['data' => $results, 'warning' => 'Tanggal periksa atau jam praktek tidak sesuai. Jam peraktek adalah ' . $results->jampraktek]);
                }
            }
        } else {
            $results = null;
        }

        return view('welcome', ['data' => $results, 'warning' => null]);
    }

    public function updateStatus(Request $request)
    {
        try {
            $nobooking = $request->input('nobooking');
            $logFile = storage_path('logs/checkin_log.txt'); // Path file log

            $record = ReferensiMobileJKNBPJS::where('nobooking', $nobooking)->first();

            if (!$record) {
                $message = "[$nobooking] Data tidak ditemukan.\n";
                file_put_contents($logFile, date('Y-m-d H:i:s') . " " . $message, FILE_APPEND);
                return response()->json(['success' => false, 'message' => 'Data tidak ditemukan'], 404);
            }

            $updated = $record->update([
                'status' => 'Checkin',
                'validasi' => now()
            ]);

            // Tulis ke log jika berhasil diperbarui
            if ($updated) {
                $message = "[$nobooking] Status berhasil diupdate menjadi 'Checkin'.\n";
            } else {
                $message = "[$nobooking] Status gagal diperbarui.\n";
            }

            file_put_contents($logFile, date('Y-m-d H:i:s') . " " . $message, FILE_APPEND);

            return response()->json(['success' => $updated > 0]);
        } catch (\Throwable $th) {
            // Tulis error ke log
            $errorMessage = "[$nobooking] ERROR: " . $th->getMessage() . "\n";
            file_put_contents($logFile, date('Y-m-d H:i:s') . " " . $errorMessage, FILE_APPEND);

            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
