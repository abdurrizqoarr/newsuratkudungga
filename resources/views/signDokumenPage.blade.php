<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen font-sans">

    <div class="bg-white shadow-xl rounded-2xl p-6 w-full max-w-7xl border border-gray-200 my-6">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6 border-b pb-4">
            <h1 class="text-2xl font-bold text-gray-800">Upload & Sign PDF</h1>
            <a href="{{ route('menuOptionsPage') }}" class="text-indigo-600 font-medium hover:underline">
                Kembali
            </a>
        </div>

        <!-- Grid 2 Kolom -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Kolom Kiri -->
            <div class="col-span-1 flex flex-col space-y-6">
                <!-- Upload Form -->
                <form id="pdfForm"
                    class="flex flex-col items-center border-2 border-dashed border-indigo-400 rounded-xl p-6 bg-indigo-50 hover:bg-indigo-100 transition">
                    <label for="pdfInput" class="cursor-pointer flex flex-col items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-indigo-500 mb-3" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        <span class="text-gray-700 font-medium">Pilih file PDF</span>
                        <span class="text-xs text-gray-500 mt-1">Maksimal 5MB</span>
                    </label>
                    <input type="file" id="pdfInput" accept="application/pdf" class="hidden" />

                    <!-- Hidden Input untuk koordinat -->
                    <input type="hidden" id="page_number" name="page_number" value="1" />
                    <input type="hidden" id="x_coordinate" name="x_coordinate" value="0" />
                    <input type="hidden" id="y_coordinate" name="y_coordinate" value="0" />
                </form>

                <!-- Input Passphrase -->
                <div class="flex flex-col space-y-2">
                    <label for="passphrase" class="text-sm font-medium text-gray-700">Passphrase</label>
                    <input type="password" id="passphrase" name="passphrase"
                        class="border rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-400 focus:outline-none"
                        placeholder="Masukkan passphrase..." />
                </div>

                <!-- Tombol Simpan -->
                <button id="saveBtn" onclick="saveSignedPDF()"
                    class="bg-indigo-600 text-white font-medium px-4 py-2 rounded-lg shadow hover:bg-indigo-700 transition">
                    Simpan Dokumen
                </button>

                <!-- Tempat pesan error -->
                <div id="errorMsg" class="mt-2 text-sm text-red-600 hidden"></div>
                <div id="successMsg" class="mt-2 text-sm text-green-600 hidden"></div>
            </div>

            <!-- Kolom Kanan -->
            <div class="col-span-2">
                <h2 class="text-lg font-semibold text-gray-700 mb-3">Preview PDF:</h2>
                <div id="pdfPreviewContainer" class="hidden border rounded-lg bg-gray-50 h-[80vh] overflow-y-auto p-4">
                    <div id="pdfPreviewWrapper" class="space-y-6"></div>
                </div>
            </div>
        </div>
    </div>

    @vite('resources/js/signDokumen.js')
</body>

</html>
