<div class="p-10 w-full min-h-screen bg-gray-100">

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
                    Surat Keterangan Sakit
                </li>
            </ol>
        </nav>
    </div>

    <h1 class="text-gray-900 font-bold text-4xl">Surat Keterangan Sakit</h1>

    <div class="bg-white p-4 rounded-lg border border-gray-200 mt-8">
        <form wire:submit.prevent="cariSurat">
            <div class="grid grid-cols-3 gap-8 mb-4 w-full">
                <x-forms.date-input id="tgl_cari_awal" name="tgl_cari_awal" label="Tanggal Cari Awal"
                    model="tgl_awal_cari" type="date" required />
                <x-forms.date-input id="tgl_cari_akhir" name="tgl_cari_akhir" label="Tanggal Cari Akhir"
                    model="tgl_akhir_cari" type="date" required />
            </div>

            <div>
                <input type="text" wire:model="search"
                    class="w-full px-4 py-2 border bg-white border-gray-300 rounded-lg focus:outline-none focus:ring-emerald-500 focus:border-emerald-500"
                    placeholder="Cari Berdasarkan nama pasien, nomer RM, nomer rawat, atau nomer surat" />
            </div>
            
            <div class="flex justify-end mt-6">
                <button type="submit"
                    class="px-12 py-2 bg-emerald-600 text-sm text-white rounded-md hover:bg-emerald-700 transition font-medium cursor-pointer flex items-center justify-center"
                    wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target="cariSurat">Cari</span>
                    <span wire:loading wire:target="cariSurat" class="flex items-center">
                        <svg class="animate-spin h-5 w-5 mr-2 text-white" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                        </svg>
                    </span>
                </button>
            </div>
        </form>
    </div>

    <div class="bg-white pb-4 rounded-lg border border-gray-200 mt-8 h-[28rem] overflow-y-auto relative">
        <table class="min-w-full divide-y divide-gray-200 rounded-lg">
            <thead class="bg-gray-50 sticky top-0 shadow">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No
                        Surat</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No
                        Rawat</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No RM
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama
                        Pasien</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Dokter</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Klinik</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Tanggal Awal</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Tanggal Akhir</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lama
                        Sakit</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
                @forelse ($dataSuratSakit as $surat)
                    <tr class="hover:bg-emerald-100 cursor-pointer"
                        onclick="window.open('{{ route('surat.keterangan-sakit.print', $surat->no_surat) }}', '_blank')">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $surat->no_surat }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $surat->no_rawat }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $surat->no_rkm_medis }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $surat->nm_pasien }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $surat->nm_poli }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $surat->nm_dokter }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            {{ $surat->tanggalawal ?? '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            {{ $surat->tanggalakhir ?? '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $surat->lamasakit ?? '-' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="px-6 py-4 text-center text-sm text-gray-500">Tidak ada data
                            ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

    </div>
</div>
