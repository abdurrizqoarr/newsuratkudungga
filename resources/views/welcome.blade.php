<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css')
    <title>Document</title>
</head>

<body class="w-full h-screen bg-gray-100">
    <div class="w-full h-screen p-8 overflow-hidden">
        <div class="mb-10">
            <div class="text-center mb-8">
                <h1 class="text-xl font-medium text-emerald-600">CHECKIN MOBILE JKN</h1>
                <h1 class="text-xl font-medium text-emerald-600">RSUD KUDUNGGA</h1>
            </div>
            <form method="GET" class="flex flex-col justify-center items-center">
                <input type="search" name="search" class="py-2 px-2 border shadow rounded-md outline-none w-full">
            </form>
        </div>

        @if ($data)
            <div class="flex flex-col justify-center items-center">
                <div class="bg-white border shadow rounded-md p-3 w-full text-gray-700">
                    <div class="grid grid-cols-2">
                        <div class="mb-2">
                            <h2 class="font-medium">NAMA PASIEN</h2>
                            <p>{{ $data->nm_pasien }}</p>
                        </div>

                        <div class="mb-2">
                            <h2 class="font-medium">NIK</h2>
                            <p>{{ $data->nik }}</p>
                        </div>

                        <div class="mb-2">
                            <h2 class="font-medium">ALAMAT</h2>
                            <p>{{ $data->alamat }}</p>
                        </div>

                        <div class="mb-2">
                            <h2 class="font-medium">NO. BOOKING</h2>
                            <p id="nobooking">{{ $data->nobooking }}</p>
                        </div>

                        <div class="mb-2">
                            <h2 class="font-medium">TANGGAL PERIKSA</h2>
                            <p>{{ $data->tanggalperiksa }}</p>
                        </div>
                    </div>

                    @if ($data->status == 'Belum')
                        @if (!$warning)
                            <button id="checkinButton"
                                class="text-white bg-emerald-600 px-6 py-1 rounded-full w-full text-center mt-8 mb-3 hover:bg-emerald-700 active:scale-95">CHECK-IN</button>
                        @else
                            <p class="font-semibold text-lg text-gray-700 text-center">{{ $warning }}</p>
                        @endif
                    @else
                        <p class="font-semibold text-lg text-gray-700 text-center">STATUS {{ $data->status }}</p>
                    @endif

                </div>
            </div>
        @else
            <div class="flex flex-col justify-center items-center">
                <div class="bg-white border shadow rounded-md p-3 w-full text-gray-700 text-center">
                    <h1 class="text-lg font-semibold">PASIEN TIDAK DITEMUKAN</h1>
                </div>
            </div>
        @endif
    </div>
    @vite('resources/js/checkin.js')
</body>

</html>
