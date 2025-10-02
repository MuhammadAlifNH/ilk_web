<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Surat Pemberitahuan') }}
        </h2>
    </x-slot>
<div class="container mx-auto p-6">
    <h2 class="text-xl font-bold mb-4">Daftar Surat Pemberitahuan</h2>

    <a href="{{ route('surat-pemberitahuan.create') }}" 
       class="px-4 py-2 bg-blue-600 text-white rounded shadow">+ Buat Surat</a>

    <div class="mt-4 bg-white shadow rounded-md p-4">
        @if($surat->count())
            <table class="w-full text-sm border">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border px-2 py-1">Nomor</th>
                        <th class="border px-2 py-1">Tanggal</th>
                        <th class="border px-2 py-1">Perihal</th>
                        <th class="border px-2 py-1">Pengirim</th>
                        <th class="border px-2 py-1">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($surat as $row)
                        <tr>
                            <td class="border px-2 py-1">{{ $row->nomor_surat }}</td>
                            <td class="border px-2 py-1">{{ $row->tanggal_surat->format('d/m/Y') }}</td>
                            <td class="border px-2 py-1">{{ $row->perihal }}</td>
                            <td class="border px-2 py-1">{{ $row->pengirim }}</td>
                            <td class="border px-2 py-1">
                                <a href="{{ route('surat-pemberitahuan.show',$row->id) }}" 
                                   class="text-blue-600 hover:underline">Detail</a>
                                |
                                <a href="{{ route('surat-pemberitahuan.cetak',$row->id) }}" 
                                   class="text-green-600 hover:underline">Cetak</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="text-gray-500">Belum ada surat pemberitahuan.</p>
        @endif
    </div>
</div>
</x-app-layout>