<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pengadaan Software') }}
        </h2>
    </x-slot>
<div class="container mx-auto px-4 py-6 max-w-4xl">
    <div class="bg-white shadow rounded-md p-6">
        <div class="text-center mb-6">
            <h2 class="text-xl font-bold uppercase">Formulir Pengadaan Software</h2>
        </div>

        <form action="{{ route('permohonan-aplikasi.store') }}" method="POST">
            @csrf

            <!-- Identitas -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Nama Pemohon</label>
                <input type="text" value="{{ Auth::user()->name }}" readonly
                       class="mt-1 w-full border rounded px-3 py-2 bg-gray-100">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Program Studi *</label>
                    <input type="text" name="program_studi" value="{{ old('program_studi') }}"
                           class="mt-1 w-full border rounded px-3 py-2" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Fakultas *</label>
                    <input type="text" name="fakultas" value="{{ old('fakultas') }}"
                           class="mt-1 w-full border rounded px-3 py-2" required>
                </div>
            </div>

            <!-- Tabel Software -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Daftar Software</label>
                <table class="min-w-full border border-gray-300 text-sm">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="border px-2 py-1">No</th>
                            <th class="border px-2 py-1">Nama Software</th>
                            <th class="border px-2 py-1">Versi</th>
                            <th class="border px-2 py-1">Lisensi</th>
                            <th class="border px-2 py-1">Mahasiswa</th>
                        </tr>
                    </thead>
                    <tbody id="software-rows">
                        <tr>
                            <td class="border px-2 py-1 text-center">1</td>
                            <td class="border px-2 py-1"><input type="text" name="software[0][nama]" class="w-full border px-2 py-1"></td>
                            <td class="border px-2 py-1"><input type="text" name="software[0][versi]" class="w-full border px-2 py-1"></td>
                            <td class="border px-2 py-1"><input type="number" name="software[0][lisensi]" class="w-full border px-2 py-1"></td>
                            <td class="border px-2 py-1"><input type="number" name="software[0][mahasiswa]" class="w-full border px-2 py-1"></td>
                        </tr>
                    </tbody>
                </table>
                <button type="button" onclick="addRow()" 
                        class="mt-2 px-3 py-1 bg-blue-600 text-white rounded">+ Tambah Baris</button>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Tanggal Dibutuhkan *</label>
                <input type="date" name="tgl_dibutuhkan" value="{{ old('tgl_dibutuhkan') }}"
                       class="mt-1 w-full border rounded px-3 py-2" required>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Alasan / Kebutuhan *</label>
                <textarea name="alasan" rows="4" class="mt-1 w-full border rounded px-3 py-2" required>{{ old('alasan') }}</textarea>
            </div>

            <div class="flex justify-end gap-2">
                <a href="{{ route('permohonan-aplikasi.saya') }}" class="px-4 py-2 border rounded">Batal</a>
                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded">Kirim Permohonan</button>
            </div>
        </form>
    </div>
</div>

<script>
function addRow() {
    let tbody = document.getElementById('software-rows');
    let rowCount = tbody.rows.length;
    let newRow = tbody.insertRow();
    newRow.innerHTML = `
        <td class="border px-2 py-1 text-center">${rowCount+1}</td>
        <td class="border px-2 py-1"><input type="text" name="software[${rowCount}][nama]" class="w-full border px-2 py-1"></td>
        <td class="border px-2 py-1"><input type="text" name="software[${rowCount}][versi]" class="w-full border px-2 py-1"></td>
        <td class="border px-2 py-1"><input type="number" name="software[${rowCount}][lisensi]" class="w-full border px-2 py-1"></td>
        <td class="border px-2 py-1"><input type="number" name="software[${rowCount}][mahasiswa]" class="w-full border px-2 py-1"></td>
    `;
}
</script>
</x-app-layout>
