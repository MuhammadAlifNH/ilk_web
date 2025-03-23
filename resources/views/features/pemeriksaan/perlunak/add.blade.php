<!-- Tabel Pemeriksaan Perangkat Lunak -->
<div class="mb-4" id="perangkat-lunak-container" style="display: none;">
    <label class="block text-sm font-medium text-gray-700">Pemeriksaan Perangkat Lunak</label>
    <table class="w-full border border-gray-300 mt-2">
        <thead>
            <tr class="bg-gray-100">
                <th class="border px-2 py-1">Nama Perangkat Lunak</th>
                <th class="border px-2 py-1">Kondisi</th>
                <th class="border px-2 py-1">Keterangan</th>
                <th class="border px-2 py-1">Aksi</th>
            </tr>
        </thead>
        <tbody id="perangkat-lunak-table">
        </tbody>
    </table>
    <button type="button" onclick="addPerangkatLunak()"
        class="mt-2 bg-green-600 hover:bg-green-700 text-white font-medium py-1 px-3 rounded-lg">
        Tambah Perangkat Lunak
    </button>
</div>

<script>
    function addPerangkatLunak() {
            const table = document.getElementById('perangkat-lunak-table');
            const rowCount = table.rows.length;
            const row = document.createElement('tr');
            row.innerHTML = `
                <td class="border px-2 py-1"><input type="text" name="perlunak[${rowCount}][lunak_id]" class="w-full" required></td>
                <td class="border px-2 py-1">
                    <select name="perlunak[${rowCount}][kondisi]" required>
                        <option value="Normal">Normal</option>
                        <option value="Error">Error</option>
                    </select>
                </td>
                <td class="border px-2 py-1"><input type="text" name="perlunak[${rowCount}][keterangan]" class="w-full"></td>
                <td class="border px-2 py-1"><button type="button" onclick="this.parentElement.parentElement.remove()">🗑️</button></td>
            `;
            table.appendChild(row);
        }
</script>