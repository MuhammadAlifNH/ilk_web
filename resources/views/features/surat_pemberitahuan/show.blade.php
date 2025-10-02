<x-app-layout>
<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Detail Surat Pemberitahuan') }}
    </h2>
</x-slot>
<div class="container mx-auto max-w-3xl p-6">
    <div class="bg-white shadow rounded-md p-6">
        <h2 class="text-xl font-bold mb-4">Detail Surat Pemberitahuan</h2>

        <div class="mb-4">
            <strong>Nomor Surat:</strong> {{ $surat->nomor_surat }}
        </div>
        <div class="mb-4">
            <strong>Tanggal Surat:</strong> {{ $surat->tanggal_surat->format('d M Y') }}
        </div>
        <div class="mb-4">
            <strong>Perihal:</strong> {{ $surat->perihal }}
        </div>
        <div class="mb-4">
            <strong>Isi Surat:</strong>
            <p class="mt-1 whitespace-pre-line">{{ $surat->isi_surat }}</p>
        </div>
        <div class="mb-4">
            <strong>Pengirim:</strong> {{ $surat->pengirim }}
        </div>

        <div class="flex gap-2 mt-6">
            <a href="{{ route('surat-pemberitahuan.cetak',$surat->id) }}" 
               class="px-4 py-2 bg-green-600 text-white rounded">Cetak Surat</a>
            <a href="{{ route('surat-pemberitahuan.index') }}" 
               class="px-4 py-2 border rounded">Kembali</a>
        </div>
    </div>
</div>
</x-app-layout>