<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Permohonan Aplikasi (Admin)') }}
        </h2>
    </x-slot>
<div class="container mx-auto p-6">
    <h2 class="text-xl font-bold mb-4">Daftar Permohonan Aplikasi (Admin)</h2>

    <div class="bg-white shadow rounded-md p-4">
        @if($items->count())
            <table class="w-full text-sm border">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border px-2 py-1">Pemohon</th>
                        <th class="border px-2 py-1">Program Studi</th>
                        <th class="border px-2 py-1">Fakultas</th>
                        <th class="border px-2 py-1">Status</th>
                        <th class="border px-2 py-1">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $row)
                        <tr>
                            <td class="border px-2 py-1">{{ $row->pemohon->name }}</td>
                            <td class="border px-2 py-1">{{ $row->program_studi }}</td>
                            <td class="border px-2 py-1">{{ $row->fakultas }}</td>
                            <td class="border px-2 py-1 capitalize">{{ $row->status }}</td>
                            <td class="border px-2 py-1">
                                <a href="{{ route('permohonan-aplikasi.show',$row->id) }}" 
                                   class="text-blue-600 hover:underline">Detail</a>
                                |
                                <a href="{{ route('admin.permohonan-aplikasi.balas',$row->id) }}" 
                                   class="text-green-600 hover:underline">Balas</a>
                                @if($row->status !== 'menunggu' && $row->isi_balasan)
                                    |
                                    <a href="{{ route('admin.permohonan-aplikasi.cetakBalasan',$row->id) }}" 
                                       class="text-purple-600 hover:underline">Cetak Balasan</a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-3">{{ $items->links() }}</div>
        @else
            <p class="text-gray-500">Belum ada permohonan masuk.</p>
        @endif
    </div>
</div>
</x-app-layout>