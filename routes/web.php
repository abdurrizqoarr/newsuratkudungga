<?php

use App\Http\Controllers\AntrianController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CheckInController;
use App\Http\Controllers\DokumenPrintController;
use App\Http\Controllers\SignDokumenController;
use App\Http\Controllers\verifyDokumenController;
use App\Http\Middleware\CustomSessionAuth;
use App\Http\Middleware\RedirectIfAuthenticatedCustom;
use App\Livewire\DetailResumeRalan;
use App\Livewire\DetailResumeRanap;
use App\Livewire\SuratKeteranganSakit;
use App\Livewire\SuratKonsultasiMedik;
use App\Livewire\SuratResumeMedisRalan;
use App\Livewire\SuratResumeMedisRanap;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/jadwal', [AntrianController::class, 'indexAntrian']);
Route::get('/jadwal-poli', [AntrianController::class, 'jadwalKlinik']);
Route::get('/jadwal-poli-api', [AntrianController::class, 'jadwalKlinikApi']);

Route::get('/', [CheckInController::class, 'index']);
Route::post('/checkin', [CheckInController::class, 'updateStatus']);

Route::get('/login', [AuthController::class, 'loginPage'])->name('loginPage')->middleware(RedirectIfAuthenticatedCustom::class);
Route::post('/login', [AuthController::class, 'handleLogin'])->name('handleLogin')->middleware(RedirectIfAuthenticatedCustom::class);
Route::get('/logout', [AuthController::class, 'logout'])->name('handleLogout')->middleware(CustomSessionAuth::class);

Route::get('/home', [AuthController::class, 'menuOptionsPage'])->name('menuOptionsPage')->middleware(CustomSessionAuth::class);

Route::get('/surat-keterangan-sakit', SuratKeteranganSakit::class)->name('surat.keterangan-sakit')->middleware(CustomSessionAuth::class);
Route::get('/surat-keterangan-sakit/{id}', [DokumenPrintController::class, 'printSuratSakit'])->name('surat.keterangan-sakit.print')->middleware(CustomSessionAuth::class);

Route::get('/dokumen-resume-medis-ralan', SuratResumeMedisRalan::class)->name('dokumen.resume-ralan')->middleware(CustomSessionAuth::class);
Route::get('/detail-resume-medis-ralan', DetailResumeRalan::class)->name('dokumen.resume-ralan.detail')->middleware(CustomSessionAuth::class);

Route::get('/dokumen-resume-medis-ranap', SuratResumeMedisRanap::class)->name('dokumen.resume-ranap')->middleware(CustomSessionAuth::class);
Route::get('/detail-resume-medis-ranap', DetailResumeRanap::class)->name('dokumen.resume-ranap.detail')->middleware(CustomSessionAuth::class);

Route::get('/dokumen-konsultasi-dokter', SuratKonsultasiMedik::class)->name('dokumen.konsultasi-dokter')->middleware(CustomSessionAuth::class);
Route::get('/dokumen-konsultasi-dokter/{id}', [DokumenPrintController::class, 'printDokumenKonsultasi'])->name('surat.konsultas-medik.print')->middleware(CustomSessionAuth::class);

Route::get('/verifikasi-dokumen', [verifyDokumenController::class, 'index'])->name('verifikasi.dokumen')->middleware(CustomSessionAuth::class);

Route::get('/user-konfirmasi', [SignDokumenController::class, 'index'])->name('sign.warningPage')->middleware(CustomSessionAuth::class);
Route::get('/sign-dokumen', [SignDokumenController::class, 'signDokumenView'])->name('sign.dokumen')->middleware(CustomSessionAuth::class);


Route::post('/sign-dokumen-qr', [SignDokumenController::class, 'handleSignDokumen']);
