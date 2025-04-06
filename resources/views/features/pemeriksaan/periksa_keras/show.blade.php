<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Data Pemeriksaan Perangkat Keras</h1>
                <a href="{{ route('periksa_keras.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg flex items-center transition duration-150 ease-in-out">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Kembali
                </a>
            </div>
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="text-center mb-6">
                        <h2 class="text-2xl font-bold">Laporan Pemeriksaan Perangkat Keras</h2>
                        <p class="text-lg font-semibold">
                            RUANG LABORATORIUM {{ $periksa_keras->lab->nama_lab }},
                            {{ $periksa_keras->fakultas->nama_fakultas }}
                        </p>
                        <p class="text-gray-600">Tanggal: {{ $periksa_keras->tanggal }}</p>
                    </div>

                    <!-- Tabel Pemeriksaan -->
                    <div class="overflow-x-auto">
                        @php
                        $detailsByMeja = $periksa_keras->details->groupBy('meja_ke');
                        $perangkatList = $periksa_keras->details->pluck('perangkat.nama')->unique()->values();
                    @endphp
                    
                    <table class="table-auto w-full border-collapse border border-gray-400 text-center">
                        <thead>
                            <tr class="bg-gray-100">
                                <th rowspan="2" class="border border-gray-400 px-4 py-2">No. Meja</th>
                                <th colspan="{{ count($perangkatList) }}" class="border border-gray-400 px-4 py-2 bg-blue-100">Kondisi Fisik</th>
                                <th colspan="{{ count($perangkatList) }}" class="border border-gray-400 px-4 py-2 bg-green-100">Kondisi Fungsional</th>
                                <th rowspan="2" class="border border-gray-400 px-4 py-2">Keterangan</th>
                            </tr>
                            <tr class="bg-gray-100">
                                @foreach ($perangkatList as $namaPerangkat)
                                    <th class="border border-gray-400 px-4 py-2">{{ $namaPerangkat }}</th>
                                @endforeach
                                @foreach ($perangkatList as $namaPerangkat)
                                    <th class="border border-gray-400 px-4 py-2">{{ $namaPerangkat }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($detailsByMeja as $mejaKe => $details)
                                <tr>
                                    <td class="border border-gray-400 px-4 py-2">{{ $mejaKe }}</td>
                                    
                                    {{-- Fisik --}}
                                    @foreach ($perangkatList as $namaPerangkat)
                                        @php
                                            $detail = $details->firstWhere('perangkat.nama', $namaPerangkat);
                                        @endphp
                                        <td class="border border-gray-400 px-4 py-2">{{ $detail->kondisi_fisik ?? '-' }}</td>
                                    @endforeach
                    
                                    {{-- Fungsional --}}
                                    @foreach ($perangkatList as $namaPerangkat)
                                        @php
                                            $detail = $details->firstWhere('perangkat.nama', $namaPerangkat);
                                        @endphp
                                        <td class="border border-gray-400 px-4 py-2">{{ $detail->kondisi_fungsional ?? '-' }}</td>
                                    @endforeach
                    
                                    {{-- Keterangan --}}
                                    <td class="border border-gray-400 px-4 py-2">
                                        {{ $details->first()->keterangan ?? '-' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    </div>

                    <!-- TTD -->
                    <div class="mt-6 text-center">
                        <p class="font-semibold">Koordinator Laboratorium Komputer</p><br><br><br>
                        <p class="font-bold">Muhamad Husen, S.Kom</p>
                    </div>

                    <!-- Tombol -->
                    <div class="my-4 flex justify-end space-x-2">
                        <button onclick="window.print()" class="bg-green-500 hover:bg-green-600 text-white font-medium py-2 px-4 rounded-lg">
                            Print
                        </button>
                        <a href="{{ route('periksa_keras.download', $periksa_keras) }}" class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-lg">
                            Download PDF
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
