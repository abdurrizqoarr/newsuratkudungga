<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @vite('resources/css/app.css')
    <style>
        @media print {
            .page-break {
                page-break-before: always;
                /* Mulai halaman baru */
            }
        }
    </style>
</head>

<body class="w-full bg-white px-8" onload="window.print()">
    <x-template-surat.kop-surat id="jaminan_nama" name="jaminan" label="Nama Jaminan" model="jaminan" required />

    <h1 class="font-bold underline text-xl text-center">KONSULTASI MEDIK</h1>
    <h2 class="text-lg text-center mb-6">No. {{ $data->no_permintaan }}</h2>

    <table class="w-full border-collapse text-sm">
        <tbody>
            <tr class="border">
                <td class="border bg-gray-100 px-3 py-2 font-semibold w-1/6">Nama Pasien</td>
                <td class="border px-3 py-2 w-1/6">{{ $data->nm_pasien }}</td>

                <td class="border bg-gray-100 px-3 py-2 font-semibold w-1/6">Jenis Kelamin</td>
                <td class="border px-3 py-2 w-1/6 whitespace-nowrap">
                    {{ $data->jk === 'L' ? 'Laki-Laki' : 'Perempuan' }}
                </td>

                <td class="border bg-gray-100 px-3 py-2 font-semibold w-1/6">Tanggal Lahir</td>
                <td class="border px-3 py-2 w-1/6">{{ $data->tgl_lahir }}</td>
            </tr>

            <tr class="border">
                <td class="border bg-gray-100 px-3 py-2 font-semibold">No. RM</td>
                <td class="border px-3 py-2">{{ $data->no_rkm_medis }}</td>

                <td class="border bg-gray-100 px-3 py-2 font-semibold">Umur</td>
                <td class="border px-3 py-2 text-center">{{ \Carbon\Carbon::parse($data->tgl_lahir)->age }} tahun</td>

                <td class="border bg-gray-100 px-3 py-2 font-semibold">Jenis</td>
                <td class="border px-3 py-2">{{ $data->jenis_permintaan }}</td>
            </tr>
        </tbody>
    </table>

    <table class="w-full text-sm mt-8">
        <tbody>
            <tr>
                <td class="border-r bg-gray-100 px-1 py-2 font-semibold w-[20%] align-top">Kepada Yth.</td>
                <td class="border-l px-3 py-2">{{ $data->dokter_dikonsuli }}</td>
            </tr>
            <tr>
                <td class="border-r bg-gray-100 px-1 py-2 font-semibold align-top">Diagnosa Kerja</td>
                <td class="border-l px-3 py-2">{{ $data->diagnosa_kerja }}</td>
            </tr>
            <tr>
                <td class="border-r bg-gray-100 px-1 py-2 font-semibold align-top">Uraian Konsultasi</td>
                <td class="border-l px-3 py-2">{{ $data->uraian_konsultasi }}</td>
            </tr>
        </tbody>
    </table>

    <div class="flex justify-end mt-20">
        <div class="text-center text-sm border-b border-gray-800">
            <p>Sangatta Utara, {{ $tanggal }} {{ $bulan }} {{ $tahun }}</p>
            <p>RSUD Kudungga Sangatta</p>
            <p class="mb-20">Dokter Yang Merawat</p>
            <p>{{ $data->dokter_pengirim }}</p>
        </div>
    </div>

    <div class="page-break"></div>

    <x-template-surat.kop-surat id="jaminan_nama" name="jaminan" label="Nama Jaminan" model="jaminan" required />

    <h1 class="font-bold underline text-xl text-center">JAWABAN KONSULTASI MEDIK</h1>
    <h2 class="text-lg text-center mb-6">No. {{ $data->no_permintaan }}</h2>

    <table class="w-full border-collapse text-sm">
        <tbody>
            <tr class="border">
                <td class="border bg-gray-100 px-3 py-2 font-semibold w-1/6">Nama Pasien</td>
                <td class="border px-3 py-2 w-1/6">{{ $data->nm_pasien }}</td>

                <td class="border bg-gray-100 px-3 py-2 font-semibold w-1/6">Jenis Kelamin</td>
                <td class="border px-3 py-2 w-1/6 whitespace-nowrap">
                    {{ $data->jk === 'L' ? 'Laki-Laki' : 'Perempuan' }}
                </td>

                <td class="border bg-gray-100 px-3 py-2 font-semibold w-1/6">Tanggal Lahir</td>
                <td class="border px-3 py-2 w-1/6">{{ $data->tgl_lahir }}</td>
            </tr>

            <tr class="border">
                <td class="border bg-gray-100 px-3 py-2 font-semibold">No. RM</td>
                <td class="border px-3 py-2">{{ $data->no_rkm_medis }}</td>

                <td class="border bg-gray-100 px-3 py-2 font-semibold">Umur</td>
                <td class="border px-3 py-2 text-center">{{ \Carbon\Carbon::parse($data->tgl_lahir)->age }} tahun</td>

                <td class="border bg-gray-100 px-3 py-2 font-semibold">Jenis</td>
                <td class="border px-3 py-2">{{ $data->jenis_permintaan }}</td>
            </tr>
        </tbody>
    </table>

    <table class="w-full text-sm mt-8">
        <tbody>
            <tr>
                <td class="border-r bg-gray-100 px-1 py-2 font-semibold w-[20%] align-top">Kepada Yth.</td>
                <td class="border-l px-3 py-2">{{ $data->dokter_pengirim }}</td>
            </tr>
            <tr>
                <td class="border-r bg-gray-100 px-1 py-2 font-semibold align-top">Diagnosa Kerja</td>
                <td class="border-l px-3 py-2">{{ $data->jawaban_diagnosa_kerja }}</td>
            </tr>
            <tr>
                <td class="border-r bg-gray-100 px-1 py-2 font-semibold align-top">Uraian Konsultasi</td>
                <td class="border-l px-3 py-2">{{ $data->uraian_jawaban }}</td>
            </tr>
        </tbody>
    </table>

    <div class="flex justify-end mt-20">
        <div class="text-center text-sm border-b border-gray-800">
            <p>Sangatta Utara, {{ $tanggal }} {{ $bulan }} {{ $tahun }}</p>
            <p>RSUD Kudungga Sangatta</p>
            <p class="mb-20">Dokter Yang Merawat</p>
            <p>{{ $data->dokter_dikonsuli }}</p>
        </div>
    </div>
</body>

</html>
