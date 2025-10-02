<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Surat Permohonan Aplikasi') }}
        </h2>
    </x-slot>
<div class="container mx-auto p-6">
    <h2 class="text-xl font-bold mb-4">Permohonan Aplikasi Saya</h2>

    <a href="{{ route('permohonan-aplikasi.create') }}" 
       class="px-4 py-2 bg-blue-600 text-white rounded shadow">+ Buat Permohonan</a>

    <div class="mt-4 bg-white shadow rounded-md p-4">
        @if($items->count())
            <table class="w-full text-sm border">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border px-2 py-1">No</th>
                        <th class="border px-2 py-1">Program Studi</th>
                        <th class="border px-2 py-1">Fakultas</th>
                        <th class="border px-2 py-1">Status</th>
                        <th class="border px-2 py-1">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $i => $row)
                        <tr>
                            <td class="border px-2 py-1 text-center">{{ $i+1 }}</td>
                            <td class="border px-2 py-1">{{ $row->program_studi }}</td>
                            <td class="border px-2 py-1">{{ $row->fakultas }}</td>
                            <td class="border px-2 py-1 capitalize">{{ $row->status }}</td>
                            <td class="border px-2 py-1">
                                <a href="{{ route('permohonan-aplikasi.show',$row->id) }}" 
                                   class="text-blue-600 hover:underline">Detail</a>
                                |
                                <a href="{{ route('permohonan-aplikasi.cetak',$row->id) }}" 
                                   class="text-green-600 hover:underline">Cetak</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-3">{{ $items->links() }}</div>
        @else
            <p class="text-gray-500">Belum ada permohonan.</p>
        @endif
    </div>
</div>
</x-app-layout>