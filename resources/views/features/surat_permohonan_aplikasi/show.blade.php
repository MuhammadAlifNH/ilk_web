<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Permohonan Aplikasi') }}
        </h2>
    </x-slot>
<div class="container mx-auto max-w-4xl p-6">
    <div class="bg-white shadow rounded-md p-6">
        <h2 class="text-xl font-bold mb-4">Detail Permohonan Aplikasi</h2>

        <div class="mb-2"><strong>Pemohon:</strong> {{ $item->pemohon->name }}</div>
        <div class="mb-2"><strong>Program Studi:</strong> {{ $item->program_studi }}</div>
        <div class="mb-2"><strong>Fakultas:</strong> {{ $item->fakultas }}</div>
        <div class="mb-2"><strong>Tanggal Dibutuhkan:</strong> {{ $item->tgl_dibutuhkan?->format('d M Y') }}</div>
        <div class="mb-2"><strong>Alasan:</strong> {{ $item->alasan }}</div>

        <h3 class="font-semibold mt-4 mb-2">Daftar Software</h3>
        <table class="w-full text-sm border mb-4">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border px-2 py-1">No</th>
                    <th class="border px-2 py-1">Nama</th>
                    <th class="border px-2 py-1">Versi</th>
                    <th class="border px-2 py-1">Lisensi</th>
                    <th class="border px-2 py-1">Mahasiswa</th>
                </tr>
            </thead>
            <tbody>
                @foreach($item->daftar_software as $i => $sw)
                <tr>
                    <td class="border px-2 py-1 text-center">{{ $i+1 }}</td>
                    <td class="border px-2 py-1">{{ $sw['nama'] ?? '' }}</td>
                    <td class="border px-2 py-1">{{ $sw['versi'] ?? '' }}</td>
                    <td class="border px-2 py-1">{{ $sw['lisensi'] ?? '' }}</td>
                    <td class="border px-2 py-1">{{ $sw['mahasiswa'] ?? '' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <h3 class="font-semibold mt-6 mb-2">Status Permohonan</h3>
        <p class="capitalize"><strong>Status:</strong> {{ $item->status }}</p>

        @if($item->status !== 'menunggu' && $item->isi_balasan)
            <div class="mt-4 p-4 bg-gray-50 border rounded">
                <h4 class="font-semibold">Balasan Admin</h4>
                <p><strong>Nomor Surat:</strong> {{ $item->nomor_surat_balasan }}</p>
                <p><strong>Tanggal:</strong> {{ $item->tanggal_balasan?->format('d M Y') }}</p>
                <p class="mt-2 whitespace-pre-line">{{ $item->isi_balasan }}</p>
            </div>
        @endif
    </div>
</div>
</x-app-layout>