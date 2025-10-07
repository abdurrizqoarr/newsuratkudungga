<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @vite('resources/css/app.css')
</head>

<body class="p-10 w-full min-h-screen bg-gray-100">
    {{-- Breadcrumb --}}
    <div>
        <nav class="mb-2" aria-label="Breadcrumb">
            <ol class="flex items-center space-x-2 text-sm text-gray-500">
                <li>
                    <a href="{{ route('menuOptionsPage') }}" class="hover:underline text-emerald-600">Home</a>
                </li>
                <li>
                    <span class="mx-2">/</span>
                </li>
                <li class="text-gray-700 font-semibold">
                    Riwayat Dokumen TTE
                </li>
            </ol>
        </nav>
    </div>

    <h1 class="text-gray-900 font-bold text-4xl">Riwayat Dokumen TTE</h1>

    <!-- Form Pencarian -->
    <form action="{{ route('riwayat.dokumen-tte') }}" method="GET" class="my-6">
        <div class="flex items-center space-x-2">
            <input type="text" name="search" value="{{ request('search') }}"
                class="w-full px-4 py-2 border bg-white border-gray-300 rounded-lg focus:outline-none focus:ring-emerald-500 focus:border-emerald-500"
                placeholder="Cari Berdasarkan nama file">
            <button type="submit"
                class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition lg:w-40">
                Cari
            </button>
        </div>
    </form>

    <!-- Tabel -->
    <div class="bg-white pb-4 rounded-lg border border-gray-200 mt-8 h-[28rem] overflow-y-auto relative">
        <table class="min-w-full divide-y divide-gray-200 rounded-lg">
            <thead class="bg-gray-50 sticky top-0 shadow">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama File
                    </th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No Rawat
                    </th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Download
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
                @forelse ($signDokumens as $index => $dokumen)
                    <tr class="hover:bg-emerald-100 cursor-pointer">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            {{ $signDokumens->firstItem() + $index }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $dokumen->nama_file }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $dokumen->no_rawat }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            <a target="_blank" href="{{ route('download.dokumen', $dokumen->id) }}">Download</a>
                        </td>
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

</body>

</html>
