<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Balas Permohonan Aplikasi') }}
        </h2>
    </x-slot>
<div class="container mx-auto max-w-3xl p-6">
    <div class="bg-white shadow rounded-md p-6">
        <h2 class="text-xl font-bold mb-4">Balasan Permohonan Aplikasi</h2>

        <form action="{{ route('admin.permohonan-aplikasi.storeBalasan', $permohonan->id) }}" method="POST">
            @csrf

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Nomor Surat *</label>
                <input type="text" name="nomor_surat" 
                       value="{{ old('nomor_surat') }}" 
                       class="mt-1 w-full border rounded px-3 py-2" required>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Tanggal Surat *</label>
                <input type="date" name="tanggal_surat" 
                       value="{{ old('tanggal_surat', now()->toDateString()) }}" 
                       class="mt-1 w-full border rounded px-3 py-2" required>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Nama Software *</label>
                <input type="text" name="nama_software" 
                       value="{{ old('nama_software', $permohonan->detail->first()->nama_software ?? '') }}" 
                       class="mt-1 w-full border rounded px-3 py-2" required>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Semester *</label>
                <select name="semester" class="mt-1 w-full border rounded px-3 py-2" required>
                    <option value="">-- Pilih Semester --</option>
                    <option value="Ganjil" {{ old('semester')=='Ganjil' ? 'selected' : '' }}>Ganjil</option>
                    <option value="Genap" {{ old('semester')=='Genap' ? 'selected' : '' }}>Genap</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Tahun Akademik *</label>
                <input type="text" name="tahun_akademik" 
                       value="{{ old('tahun_akademik') }}" 
                       class="mt-1 w-full border rounded px-3 py-2" placeholder="2025/2026" required>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Ditandatangani Oleh *</label>
                <input type="text" name="ditandatangani_oleh" 
                       value="{{ old('ditandatangani_oleh', Auth::user()->name) }}" 
                       class="mt-1 w-full border rounded px-3 py-2" required>
            </div>

            <div class="flex justify-end gap-2">
                <a href="{{ route('admin.permohonan-aplikasi.index') }}" class="px-4 py-2 border rounded">Batal</a>
                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded">Simpan Balasan</button>
            </div>
        </form>
    </div>
</div>
</x-app-layout>