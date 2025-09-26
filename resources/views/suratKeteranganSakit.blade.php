<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @vite('resources/css/app.css')
</head>

<body class="w-full bg-white px-8" onload="window.print()">
    <x-template-surat.kop-surat id="jaminan_nama" name="jaminan" label="Nama Jaminan" model="jaminan" required />

    <h1 class="font-bold underline text-xl text-center">SURAT KETERANGAN SAKIT</h1>
    <h2 class="text-lg text-center mb-10">No. {{ $data->no_surat }}</h2>

    <p>Dengan ini kami menerangkan bahwa berdasarkann hasil pemeriksaan yang telah dilakukan kepada pasien:</p>

    <div class="p-4 my-2">
        <div class="grid grid-cols-[25%_1rem_1fr] gap-3 text-left">
            <p>Nama Lengkap</p>
            <p>:</p>
            <p>{{ $data->nm_pasien }}</p>
        </div>

        <div class="grid grid-cols-[25%_1rem_1fr] gap-3 text-left">
            <p>Nomor Rekam Medis</p>
            <p>:</p>
            <p>{{ $data->no_rkm_medis }}</p>
        </div>

        <div class="grid grid-cols-[25%_1rem_1fr] gap-3 text-left">
            <p>Tempat Tanggal Lahir</p>
            <p>:</p>
            <p>{{ $data->tmp_lahir }}, {{ $data->tgl_lahir }}</p>
        </div>
    </div>

    <p>Diberikan istirahat sakit selama {{ $data->lamasakit }} hari mulai tanggal {{ $data->tanggalawal }} sampai dengan
        tanggal {{ $data->tanggalakhir }}. Demikian surat ini diberikan untuk diketahui dan digunakan sebagai
        mestinya.</p>

    <div class="flex justify-end mt-20">
        <div class="text-center text-sm border-b border-gray-800">
            <p>Sangatta Utara, {{ $tanggal }} {{ $bulan }} {{ $tahun }}</p>
            <p>RSUD Kudungga Sangatta</p>
            <p class="mb-20">Dokter Yang Merawat</p>
            <p>{{ $data->nm_dokter }}</p>
        </div>
    </div>
</body>

</html>
