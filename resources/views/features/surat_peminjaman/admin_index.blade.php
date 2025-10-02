<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Peminjaman Lab (Admin)') }}
        </h2>
    </x-slot>
<div class="container mx-auto p-6">
    <h2 class="text-xl font-bold mb-4">Daftar Peminjaman Lab (Admin)</h2>

    <a href="{{ route('admin.peminjaman.cetak') }}" 
       class="px-4 py-2 bg-purple-600 text-white rounded">Cetak Buku Peminjaman</a>

    <div class="mt-4 bg-white shadow rounded p-4">
        @if($items->count())
            <table class="w-full border text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border px-2 py-1">Pemohon</th>
                        <th class="border px-2 py-1">Ruang</th>
                        <th class="border px-2 py-1">Uraian</th>
                        <th class="border px-2 py-1">Mulai</th>
                        <th class="border px-2 py-1">Selesai</th>
                        <th class="border px-2 py-1">Status</th>
                        <th class="border px-2 py-1">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $row)
                    <tr>
                        <td class="border px-2 py-1">{{ $row->pemohon->name }}</td>
                        <td class="border px-2 py-1">{{ $row->lab->nama_ruangan }}</td>
                        <td class="border px-2 py-1">{{ $row->uraian }}</td>
                        <td class="border px-2 py-1">{{ $row->tanggal_mulai }}</td>
                        <td class="border px-2 py-1">{{ $row->tanggal_selesai }}</td>
                        <td class="border px-2 py-1 capitalize">{{ $row->status }}</td>
                        <td class="border px-2 py-1">
                            @if($row->status == 'menunggu')
                                <form action="{{ route('admin.peminjaman.approve',$row->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="text-green-600 hover:underline">Setujui</button>
                                </form>
                                |
                                <form action="{{ route('admin.peminjaman.reject',$row->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="text-red-600 hover:underline">Tolak</button>
                                </form>
                            @else
                                <span class="text-gray-500">Sudah diproses</span>
                            @endif
                        </td>
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