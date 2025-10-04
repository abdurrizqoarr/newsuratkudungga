<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tanda Tangan Digital</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center">

    <div class="bg-white shadow-lg rounded-2xl p-8 w-full max-w-lg">
        <!-- Tombol Kembali -->
        <a href="{{ route('menuOptionsPage') }}" class="text-indigo-600 hover:underline text-sm">&larr; Kembali</a>

        <!-- Judul -->
        <h2 class="text-2xl font-bold text-gray-800 mt-4 mb-2 text-center">Tanda Tangan Digital</h2>
        <p class="text-gray-600 text-sm text-center mb-6">
            Unggah dokumen Anda dan masukkan passphrase untuk menambahkan <span class="font-semibold">Tanda Tangan
                Digital</span>.
        </p>

        <!-- Form Upload -->
        <form method="POST" id="signForm" enctype="multipart/form-data" class="space-y-5">
            {{-- @csrf --}}

            <!-- Input File -->
            <div>
                <label for="file" class="block text-sm font-medium text-gray-700 mb-2">Pilih Dokumen</label>
                <input type="file" id="file" name="file" accept=".pdf"
                    class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    required>
                <p class="text-xs text-gray-500 mt-1">Ukuran maksimal: 5 MB</p>
            </div>

            <!-- Input Passphrase -->
            <div>
                <label for="passphrase" class="block text-sm font-medium text-gray-700 mb-2">Passphrase</label>
                <input type="password" id="passphrase" name="passphrase" placeholder="Masukkan passphrase Anda"
                    class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    required>
                <p class="text-xs text-gray-500 mt-1">Passphrase digunakan untuk keamanan tanda tangan digital Anda.</p>
            </div>

            <!-- Tombol Kirim -->
            <div class="flex justify-end">
                <button type="submit"
                    class="bg-indigo-600 text-white px-5 py-2 rounded-lg hover:bg-indigo-700 transition-all duration-200">
                    Kirim
                </button>
            </div>
        </form>

        <div id="notif" class="hidden mt-4 text-sm text-center p-3 rounded-lg"></div>

        <!-- Peringatan -->
        <div class="mt-6 text-sm text-gray-600 bg-yellow-50 border border-yellow-200 rounded-lg p-4">
            ⚠️ <span class="font-semibold">Peringatan:</span>
            Tanda tangan digital membantu memastikan keaslian dokumen secara elektronik,
            namun <span class="font-semibold">tidak selalu menggantikan tanda tangan basah</span>
            dalam urusan hukum atau administrasi tertentu.
        </div>
    </div>

    @vite('resources/js/signDokumenNoQr.js')

</body>

</html>
