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
            <h2 class="text-2xl font-bold text-gray-800 mb-2">Deskripsi</h2>
            <p class="text-gray-600 mb-4">
                Fitur ini digunakan untuk menambahkan <span class="font-semibold">Tanda Tangan Digital</span> pada
                dokumen Anda.
                Dengan fitur ini, Anda dapat menandatangani dokumen digital—baik yang dihasilkan oleh sistem maupun
                dokumen asli yang telah dipindai (scan)—secara cepat dan aman.
            </p>
            <p class="text-gray-600 italic mb-4">
                ⚠️ <span class="font-semibold">Penting:</span> Tanda tangan digital membantu memperkuat keaslian dokumen
                secara elektronik,
                namun <span class="font-semibold">tidak selalu dapat menggantikan tanda tangan basah (tanda tangan
                    manual di atas kertas)</span>
                untuk keperluan hukum atau administrasi tertentu. Pastikan Anda memahami kebutuhan dokumen sebelum
                menggunakannya.
            </p>
            <div class="flex justify-end">
                <a href="{{ route('sign.dokumen-no-qr') }}"
                    class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">
                    Lanjutkan
                </a>
            </div>
        </div>
    </div>

</body>

</html>
