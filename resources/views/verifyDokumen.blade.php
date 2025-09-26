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

        <h1 class="text-2xl font-semibold text-gray-800 mb-6 text-center mt-16">
            Verifikasi PDF
        </h1>

        <!-- Input File -->
        <form id="verifyForm" class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Pilih File PDF</label>
                <input id="pdfFile" type="file" accept="application/pdf"
                    class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                    required>
            </div>

            <!-- Tombol Submit -->
            <button type="submit"
                class="w-full bg-indigo-600 text-white font-medium py-2 px-4 rounded-lg hover:bg-indigo-700 transition duration-200">
                Verifikasi
            </button>
        </form>

        <!-- Loading / Hasil -->
        <div id="result" class="mt-6 text-sm text-gray-700"></div>
    </div>

    @vite('resources/js/verifSign.js')
</body>

</html>
