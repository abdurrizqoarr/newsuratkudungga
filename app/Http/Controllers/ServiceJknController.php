<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServiceJknController extends Controller
{
    public function taskId3()
    {
        $now = Carbon::now(); // waktu saat ini


        $data = DB::table('referensi_mobilejkn_bpjs')
            ->where('status', 'Checkin')
            ->where('statuskirim', 'Belum')
            ->whereDate('validasi', $now->toDateString())
            ->get();

        return response()->json(['message' => 'Data retrieved successfully', 'data' => $data], 200);
    }
}
