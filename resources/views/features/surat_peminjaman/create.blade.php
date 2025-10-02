<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ajukan Peminjaman Lab') }}
        </h2>
    </x-slot>
<div class="container mx-auto max-w-3xl p-6">
    <div class="bg-white shadow rounded p-6">
        <h2 class="text-xl font-bold mb-4">Form Peminjaman Lab</h2>

        <form action="{{ route('peminjaman.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label class="block text-sm font-medium">Nama Pemohon</label>
                <input type="text" value="{{ Auth::user()->name }}" readonly
                       class="w-full border rounded px-3 py-2 bg-gray-100">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium">Instansi</label>
                <input type="text" name="instansi" class="w-full border rounded px-3 py-2">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium">No. Telp</label>
                <input type="text" name="no_telp" class="w-full border rounded px-3 py-2">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium">Ruang Lab *</label>
                <select name="lab_id" class="w-full border rounded px-3 py-2" required>
                    <option value="">-- Pilih Ruang --</option>
                    @foreach($labs as $lab)
                        <option value="{{ $lab->id }}">{{ $lab->nama_ruangan }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium">Uraian Peminjaman *</label>
                <textarea name="uraian" rows="3" class="w-full border rounded px-3 py-2" required></textarea>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium">Jumlah Orang</label>
                    <input type="number" name="jumlah_orang" class="w-full border rounded px-3 py-2">
                </div>
                <div>
                    <label class="block text-sm font-medium">Lama Pinjam</label>
                    <input type="text" name="lama_pinjam" placeholder="misal: 3 jam"
                           class="w-full border rounded px-3 py-2">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium">Tanggal Mulai *</label>
                    <input type="date" name="tanggal_mulai" class="w-full border rounded px-3 py-2" required>
                </div>
                <div>
                    <label class="block text-sm font-medium">Tanggal Selesai *</label>
                    <input type="date" name="tanggal_selesai" class="w-full border rounded px-3 py-2" required>
                </div>
            </div>

            <div class="flex justify-end gap-2">
                <a href="{{ route('peminjaman.index') }}" class="px-4 py-2 border rounded">Batal</a>
                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded">Ajukan</button>
            </div>
        </form>
    </div>
</div>
</x-app-layout>