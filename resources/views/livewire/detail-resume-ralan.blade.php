<div class="p-6" x-data="{ show: true }" x-transition.opacity.duration.400ms>

    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Detail Resume Rawat Jalan</h1>
        <a href="{{ route('dokumen.resume-ralan') }}"
            class="px-4 py-2 bg-gray-700 text-white rounded-lg shadow hover:bg-gray-800 transition">
            Kembali
        </a>
    </div>

    <!-- Card Utama -->
    <div class="bg-white rounded-xl shadow-md p-6 border">

        <!-- Informasi Pasien -->
        <h2 class="text-lg font-semibold text-emerald-700 mb-4">Informasi Pasien</h2>
        <table class="w-full border border-gray-200 rounded-lg overflow-hidden mb-6">
            <tbody class="divide-y divide-gray-200 text-gray-700">
                <tr>
                    <td class="px-4 py-2 font-medium bg-gray-50 w-1/3">No. Rawat</td>
                    <td class="px-4 py-2">{{ $resume['no_rawat'] }}</td>
                </tr>
                <tr>
                    <td class="px-4 py-2 font-medium bg-gray-50">No. RM</td>
                    <td class="px-4 py-2">{{ $resume['no_rkm_medis'] }}</td>
                </tr>
                <tr>
                    <td class="px-4 py-2 font-medium bg-gray-50">Nama Pasien</td>
                    <td class="px-4 py-2">{{ $resume['nm_pasien'] }}</td>
                </tr>
                <tr>
                    <td class="px-4 py-2 font-medium bg-gray-50">Dokter DPJB</td>
                    <td class="px-4 py-2">{{ $resume['dokter_dpjb'] }}</td>
                </tr>
                <tr>
                    <td class="px-4 py-2 font-medium bg-gray-50">Poli</td>
                    <td class="px-4 py-2">{{ $resume['nm_poli'] }}</td>
                </tr>
            </tbody>
        </table>

        <!-- Keluhan & Pemeriksaan -->
        <h2 class="text-lg font-semibold text-emerald-700 mb-4">Keluhan & Pemeriksaan</h2>
        <table class="w-full border border-gray-200 rounded-lg overflow-hidden mb-6">
            <tbody class="divide-y divide-gray-200 text-gray-700">
                <tr>
                    <td class="px-4 py-2 font-medium bg-gray-50 w-1/3">Keluhan Utama</td>
                    <td class="px-4 py-2 whitespace-pre-wrap">{{ $resume['keluhan_utama'] ?: '-' }}</td>
                </tr>
                <tr>
                    <td class="px-4 py-2 font-medium bg-gray-50">Jalannya Penyakit</td>
                    <td class="px-4 py-2 whitespace-pre-wrap">{{ $resume['jalannya_penyakit'] ?: '-' }}</td>
                </tr>
                <tr>
                    <td class="px-4 py-2 font-medium bg-gray-50">Pemeriksaan Penunjang</td>
                    <td class="px-4 py-2 whitespace-pre-wrap">{{ $resume['pemeriksaan_penunjang'] ?: '-' }}</td>
                </tr>
                <tr>
                    <td class="px-4 py-2 font-medium bg-gray-50">Hasil Laborat</td>
                    <td class="px-4 py-2 whitespace-pre-wrap">{{ $resume['hasil_laborat'] ?: '-' }}</td>
                </tr>
            </tbody>
        </table>

        <!-- Diagnosa -->
        <h2 class="text-lg font-semibold text-emerald-700 mb-4">Diagnosa</h2>
        <table class="w-full border border-gray-200 rounded-lg overflow-hidden mb-6">
            <tbody class="divide-y divide-gray-200 text-gray-700">
                <tr>
                    <td class="px-4 py-2 font-medium bg-gray-50 w-1/3">Diagnosa Utama</td>
                    <td class="px-4 py-2">
                        {{ $resume['diagnosa_utama'] ?: '-' }} ({{ $resume['kd_diagnosa_utama'] }})
                    </td>
                </tr>
                <tr>
                    <td class="px-4 py-2 font-medium bg-gray-50">Diagnosa Sekunder</td>
                    <td class="px-4 py-2 whitespace-pre-wrap">{{ $resume['diagnosa_sekunder'] ?: '-' }}</td>
                </tr>
            </tbody>
        </table>

        <!-- Kondisi Pulang -->
        <h2 class="text-lg font-semibold text-emerald-700 mb-4">Kondisi Pulang</h2>
        <table class="w-full border border-gray-200 rounded-lg overflow-hidden mb-6">
            <tbody class="divide-y divide-gray-200 text-gray-700">
                <tr>
                    <td class="px-4 py-2 font-medium bg-gray-50 w-1/3">Kondisi Pulang</td>
                    <td class="px-4 py-2 whitespace-pre-wrap">{{ $resume['kondisi_pulang'] ?: '-' }}</td>
                </tr>
            </tbody>
        </table>

        <!-- Obat Pulang -->
        <h2 class="text-lg font-semibold text-emerald-700 mb-4">Obat Pulang</h2>
        <table class="w-full border border-gray-200 rounded-lg overflow-hidden">
            <tbody class="divide-y divide-gray-200 text-gray-700">
                <tr>
                    <td class="px-4 py-2 font-medium bg-gray-50 w-1/3">Obat Pulang</td>
                    <td class="px-4 py-2 whitespace-pre-wrap">{{ $resume['obat_pulang'] ?: '-' }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    @if ($isUserLoggedIn)
        <div class="mt-8 bg-white rounded-xl shadow-md p-6 border">
            <h2 class="text-lg font-semibold text-emerald-700 mb-4">Tanda Tangan Digital</h2>

            <form wire:submit.prevent="signResumeRalan" class="space-y-4" autocomplete="off">
                <!-- NIK -->
                <div>
                    <label for="nik" class="block text-sm font-medium text-gray-700">NIK</label>
                    <input type="text" id="nik" autocomplete="off" autocorrect="off" disabled
                        value="{{ $nik }}" autocapitalize="off" spellcheck="false"
                        class="mt-1 block w-full border rounded-lg px-3 py-2 text-sm text-gray-800 focus:ring-emerald-500 focus:border-emerald-500"
                        required>
                    @error('nik')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Passphrase -->
                <div>
                    <label for="passphrase" class="block text-sm font-medium text-gray-700">Passphrase</label>
                    <input type="password" id="passphrase" wire:model="passphrase" autocomplete="new-password"
                        autocorrect="off" autocapitalize="off" spellcheck="false"
                        class="mt-1 block w-full border rounded-lg px-3 py-2 text-sm text-gray-800 focus:ring-emerald-500 focus:border-emerald-500"
                        required>
                    @error('passphrase')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Tombol Submit -->
                <div class="flex justify-end">
                    <button type="submit"
                        class="px-4 py-2 bg-emerald-600 text-white rounded-lg shadow hover:bg-emerald-700 transition"
                        wire:loading.attr="disabled">
                        <span wire:loading.remove>Kirim</span>
                        <span wire:loading>Memproses...</span>
                    </button>
                    @if ($downloadButtonStatus)
                        <button wire:click="downloadFile" type="button" wire:loading.attr="disabled"
                            class="ml-4 px-4 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition">
                            <span wire:loading.remove>Simpan Resume</span>
                            <span wire:loading>Memproses...</span>
                        </button>
                    @endif
                </div>
            </form>
        </div>
    @endif

    @if ($signedFile)
        <div class="mt-8 bg-white rounded-xl shadow-md p-6 border">
            <h2 class="text-lg font-semibold text-emerald-700 mb-4">Resume Telah Ditandatangani</h2>
            <p class="text-gray-700 mb-4">Dokumen resume rawat jalan telah ditandatangani secara digital.</p>
            <button wire:click="downloadFileResume" type="button"
                class="px-4 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition">
                Download File
            </button>
        </div>
    @endif
</div>
