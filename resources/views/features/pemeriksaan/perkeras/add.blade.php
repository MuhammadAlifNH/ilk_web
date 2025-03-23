<!-- Tabel Pemeriksaan Perangkat Keras -->
<div class="mb-4" id="perangkat-keras-container" style="display: none;">
    <label class="block text-sm font-medium text-gray-700">Pemeriksaan Perangkat Keras</label>
    <table class="w-full border border-gray-300 mt-2">
        <thead>
            <tr class="bg-gray-100">
                <th class="border px-2 py-1">No Meja</th>
                <th class="border px-2 py-1 bg-gray-300">Nama Perangkat (Kondisi Fisik)</th>
                <th class="border px-2 py-1 bg-orange-200">Nama Perangkat (Kondisi Fungsional)</th>
                <th class="border px-2 py-1">Keterangan</th>
                <th class="border px-2 py-1">Aksi</th>
            </tr>
        </thead>
        <tbody id="perangkat-keras-table">
        </tbody>
    </table>
    <button type="button" onclick="addPerangkatKeras()"
        class="mt-2 bg-green-600 hover:bg-green-700 text-white font-medium py-1 px-3 rounded-lg">
        Tambah Perangkat Keras
    </button>
</div>

<script>
    function addPerangkatKeras() {
        const table = document.getElementById('perangkat-keras-table');
        const rowCount = table.rows.length;
        const row = document.createElement('tr');
        row.innerHTML = `
            <td class="border px-2 py-1 text-center">${rowCount}</td>
            <td class="border px-2 py-1 bg-gray-200">
                <input type="text" name="perkeras[${rowCount}][nama_perangkat]" class="w-full" required>
            </td>
            <td class="border px-2 py-1 bg-orange-100">
                <select name="perkeras[${rowCount}][kondisi_fungsional]" required>
                    <option value="Berfungsi">Berfungsi</option>
                    <option value="Tidak Berfungsi">Tidak Berfungsi</option>
                </select>
            </td>
            <td class="border px-2 py-1">
                <input type="text" name="perkeras[${rowCount}][keterangan]" class="w-full">
            </td>
            <td class="border px-2 py-1 text-center">
                <button type="button" onclick="this.parentElement.parentElement.remove(); updateNomorMeja()">🗑️</button>
            </td>
        `;
        table.appendChild(row);
        updateNomorMeja();
    }

    function updateNomorMeja() {
        const rows = document.querySelectorAll("#perangkat-keras-table tr");
        rows.forEach((row, index) => {
            row.cells[0].textContent = index;
        });
    }
</script>
