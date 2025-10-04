<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100">
    <div class="p-10 w-full">
        {{-- <div class="mb-10">
            <input type="search" name="search-modul" id="search-modul"
                class="w-full max-w-md px-4 py-2 border bg-white border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-emerald-500 focus:border-emerald-500"
                placeholder="Cari Modul" />
        </div> --}}

        <div class="grid grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
            <a href="{{ route('surat.keterangan-sakit') }}"
                class="w-full h-48 rounded-lg bg-white shadow flex items-center justify-center flex-col gap-3 text-center lg:text-lg font-medium text-gray-700">
                <img src="{{ url('ico/ket-sakit.png') }}" alt="ket-sakit" class="w-20">
                <p>Surat Keterangan Sakit</p>
            </a>
            <a href="{{ route('dokumen.resume-ralan') }}"
                class="w-full h-48 rounded-lg bg-white shadow flex items-center justify-center flex-col gap-3 text-center lg:text-lg font-medium text-gray-700">
                <img src="{{ url('ico/resume.png') }}" alt="ket-sakit" class="w-20">
                <p>Dokumen Resume Ralan</p>
            </a>
            <a href="{{ route('dokumen.resume-ranap') }}"
                class="w-full h-48 rounded-lg bg-white shadow flex items-center justify-center flex-col gap-3 text-center lg:text-lg font-medium text-gray-700">
                <img src="{{ url('ico/resume.png') }}" alt="ket-sakit" class="w-20">
                <p>Dokumen Resume Ranap</p>
            </a>
            <a href="{{ route('dokumen.konsultasi-dokter') }}"
                class="w-full h-48 rounded-lg bg-white shadow flex items-center justify-center flex-col gap-3 text-center lg:text-lg font-medium text-gray-700">
                <img src="{{ url('ico/konsul.png') }}" alt="ket-sakit" class="w-20">
                <p>Dokumen Konsultasi Dokter</p>
            </a>
            <a href="{{ route('verifikasi.dokumen') }}"
                class="w-full h-48 rounded-lg bg-white shadow flex items-center justify-center flex-col gap-3 text-center lg:text-lg font-medium text-gray-700">
                <img src="{{ url('ico/verif.png') }}" alt="ket-sakit" class="w-20">
                <p>CEK DOKUMEN TTE</p>
            </a>
            <a href="{{ route('sign.warningPage') }}"
                class="w-full h-48 rounded-lg bg-white shadow flex items-center justify-center flex-col gap-3 text-center lg:text-lg font-medium text-gray-700">
                <img src="{{ url('ico/sign.png') }}" alt="ket-sakit" class="w-20">
                <p>SIGN DOKUMEN WITH QR</p>
            </a>
            <a href="{{ route('sign.warningPage-no-qr') }}"
                class="w-full h-48 rounded-lg bg-white shadow flex items-center justify-center flex-col gap-3 text-center lg:text-lg font-medium text-gray-700">
                <img src="{{ url('ico/sign.png') }}" alt="ket-sakit" class="w-20">
                <p>SIGN DOKUMEN NO QR</p>
            </a>
        </div>
    </div>

    <div class="fixed bottom-0 left-0 right-0 h-24 bg-white border-t border-gray-200">
        <div class="flex justify-between items-center p-4 h-full">
            <div>
                <h3 class="text-gray-900 font-bold text-xl">{{ $user->nama }}</h3>
                <p class="text-gray-600 font-medium">{{ $user->nik }}</p>
            </div>
            <div class="flex space-x-4">
                <a href="/logout"
                    class="rounded-full border border-red-600 px-6 py-2 font-medium text-red-600 hover:bg-red-600 hover:text-white">logout</a>
            </div>
        </div>
    </div>
</body>

</html>
