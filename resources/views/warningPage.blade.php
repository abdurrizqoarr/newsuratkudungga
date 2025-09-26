<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="bg-white shadow-lg rounded-2xl p-8 w-full max-w-2xl">
        <a href="{{ route('menuOptionsPage') }}" class="text-indigo-600 hover:underline">Kembali</a>
        <div class="mt-4 mb-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-2">Peringatan!</h2>
            <p class="text-gray-600">Dengan menekan tombol "Lanjutkan", Anda menyetujui bahwa dokumen yang akan ditandatangani
                adalah benar dan sah. Pastikan untuk memeriksa kembali semua informasi sebelum melanjutkan.</p>
        <div class="flex justify-end">
            <a href="{{ route('sign.dokumen') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">Lanjutkan</a>
        </div>
    </div>
</body>

</html>
