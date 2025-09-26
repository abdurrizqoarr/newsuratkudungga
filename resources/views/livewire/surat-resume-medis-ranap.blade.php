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
                    Surat Konsultasi Medik
                </li>
            </ol>
        </nav>
    </div>

    <h1 class="text-gray-900 font-bold text-4xl">Surat Konsultasi Medik</h1>

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
                    placeholder="Cari Berdasarkan nama pasien, nomer RM, nomer rawat" />

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
                        Rawat</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No RM
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama
                        Pasien</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Dokter DPJB</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Nama Poli</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
                @foreach ($dataSurat as $surat)
                    <tr class="hover:bg-emerald-100 cursor-pointer"
                        wire:key="surat-{{ $surat->no_rawat }}-{{ $surat->no_rkm_medis }}">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $surat->no_rawat }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $surat->no_rkm_medis }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $surat->nm_pasien }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $surat->dokter_dpjb }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $surat->nm_poli }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700"> <a
                                href="{{ route('dokumen.resume-ranap.detail') }}?no_rawat={{ $surat->no_rawat }}">
                                Detail
                            </a></td>
                    </tr>
                @endforeach
                @if ($dataSurat->isEmpty())
                    <tr>
                        <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 text-center">
                            Tidak ada data ditemukan.
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>

    </div>
</div>
