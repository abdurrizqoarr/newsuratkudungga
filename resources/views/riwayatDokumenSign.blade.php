<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <h2 class="text-2xl font-semibold text-gray-800 mb-6">📄 Daftar Dokumen Tertanda</h2>

        <!-- Form Pencarian -->
        <form action="{{ route('sign-dokumen.index') }}" method="GET" class="mb-6">
            <div class="flex items-center space-x-2">
                <input type="text" name="search" placeholder="Cari berdasarkan nama file..."
                    value="{{ request('search') }}"
                    class="w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                <button type="submit"
                    class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition">
                    Cari
                </button>
            </div>
        </form>

        <!-- Tabel -->
        <div class="overflow-x-auto bg-white shadow-md rounded-lg">
            <table class="min-w-full text-sm text-left text-gray-600">
                <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
                    <tr>
                        <th class="px-4 py-3">#</th>
                        <th class="px-4 py-3">ID</th>
                        <th class="px-4 py-3">File</th>
                        <th class="px-4 py-3">NIK</th>
                        <th class="px-4 py-3">Nama File</th>
                        <th class="px-4 py-3">No Rawat</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($signDokumens as $index => $dokumen)
                        <tr class="border-b hover:bg-gray-50 transition">
                            <td class="px-4 py-3">{{ $signDokumens->firstItem() + $index }}</td>
                            <td class="px-4 py-3">{{ $dokumen->id }}</td>
                            <td class="px-4 py-3 truncate max-w-xs">{{ $dokumen->file }}</td>
                            <td class="px-4 py-3">{{ $dokumen->nik }}</td>
                            <td class="px-4 py-3">{{ $dokumen->nama_file }}</td>
                            <td class="px-4 py-3">{{ $dokumen->no_rawat }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-6 text-center text-gray-400">
                                Tidak ada data ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6 flex justify-center">
            {{ $signDokumens->appends(['search' => request('search')])->links() }}
        </div>

    </div>
</body>

</html>
