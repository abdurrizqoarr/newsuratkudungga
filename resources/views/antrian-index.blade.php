<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Dokter</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-50 font-sans">
    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-bold text-gray-800 mb-8 text-center">Jadwal Dokter Hari {{ $today }}</h1>

        <div class="grid grid-cols-1 sm:grid-cols-3 lg:grid-cols-5 gap-6">
            @forelse($jadwal as $item)
                <a href="{{ url('/jadwal-poli') . '?dokter=' . $item->kd_dokter . '&poli=' . $item->kd_poli }}"
                    class="block bg-sky-100 rounded-3xl shadow-sm p-6 hover:shadow-lg transition duration-300 transform hover:-translate-y-1">
                    
                    <h2 class="text-lg font-semibold text-gray-900 mb-1 truncate">
                        {{ $item->nama }}
                    </h2>
                    <p class="text-gray-600 text-sm mb-1">
                        <span class="font-medium">Poli:</span> {{ $item->nm_poli }}
                    </p>
                    <p class="text-gray-600 text-sm mb-1">
                        <span class="font-medium">Hari:</span> {{ $item->hari_kerja }}
                    </p>
                    <p class="text-gray-600 text-sm">
                        <span class="font-medium">Jam:</span> {{ \Carbon\Carbon::parse($item->jam_mulai)->format('H:i') }}
                    </p>
                </a>
            @empty
                <div class="col-span-full text-center text-gray-400 py-10">
                    Tidak ada jadwal untuk hari ini.
                </div>
            @endforelse
        </div>
    </div>
</body>

</html>
