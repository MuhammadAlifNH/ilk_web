<x-app-layout>
<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Buat Surat Pemberitahuan') }}
    </h2>
</x-slot>
<div class="container mx-auto max-w-3xl p-6">
    <div class="bg-white shadow rounded-md p-6">
        <h2 class="text-xl font-bold mb-4">Buat Surat Pemberitahuan</h2>

        <form action="{{ route('surat-pemberitahuan.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Nomor Surat *</label>
                <input type="text" name="nomor_surat" value="{{ old('nomor_surat') }}"
                       class="mt-1 w-full border rounded px-3 py-2" required>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Tanggal Surat *</label>
                <input type="date" name="tanggal_surat" value="{{ old('tanggal_surat') }}"
                       class="mt-1 w-full border rounded px-3 py-2" required>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Perihal *</label>
                <input type="text" name="perihal" value="{{ old('perihal') }}"
                       class="mt-1 w-full border rounded px-3 py-2" required>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Isi Surat *</label>
                <textarea name="isi_surat" rows="6" 
                          class="mt-1 w-full border rounded px-3 py-2" required>{{ old('isi_surat') }}</textarea>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Pengirim *</label>
                <input type="text" name="pengirim" value="{{ old('pengirim', Auth::user()->name) }}"
                       class="mt-1 w-full border rounded px-3 py-2">
            </div>

            <div class="flex justify-end gap-2">
                <a href="{{ route('surat-pemberitahuan.index') }}" class="px-4 py-2 border rounded">Batal</a>
                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded">Kirim</button>
            </div>
        </form>
    </div>
</div>
</x-app-layout>
