<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Peminjaman Lab Saya') }}
        </h2>
    </x-slot>
<div class="container mx-auto p-6">
    <h2 class="text-xl font-bold mb-4">Daftar Peminjaman Lab Saya</h2>

    <a href="{{ route('peminjaman.create') }}" 
       class="px-4 py-2 bg-blue-600 text-white rounded">+ Ajukan Peminjaman</a>

    <div class="mt-4 bg-white shadow rounded p-4">
        @if($items->count())
            <table class="w-full border text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border px-2 py-1">Ruang</th>
                        <th class="border px-2 py-1">Uraian</th>
                        <th class="border px-2 py-1">Mulai</th>
                        <th class="border px-2 py-1">Selesai</th>
                        <th class="border px-2 py-1">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $row)
                    <tr>
                        <td class="border px-2 py-1">{{ $row->lab->nama_ruangan }}</td>
                        <td class="border px-2 py-1">{{ $row->uraian }}</td>
                        <td class="border px-2 py-1">{{ $row->tanggal_mulai }}</td>
                        <td class="border px-2 py-1">{{ $row->tanggal_selesai }}</td>
                        <td class="border px-2 py-1 capitalize">{{ $row->status }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="text-gray-500">Belum ada data peminjaman.</p>
        @endif
    </div>
</div>
</x-app-layout>
