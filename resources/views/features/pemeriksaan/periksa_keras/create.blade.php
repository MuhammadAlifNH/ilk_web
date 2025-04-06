<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Pemeriksaan Perangkat Keras') }}
            </h2>
        </div>
    </x-slot>

    @if(session('success'))
        <div class="bg-green-500 text-white p-3 rounded-md mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-500 text-white p-3 rounded-md mb-4">
            {{ session('error') }}
        </div>
    @endif


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h1 class="text-2xl font-bold text-gray-800">Tambah Data Pemeriksaan Perangkat Keras</h1>
                        <a href="{{ route('periksa_keras.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg flex items-center transition duration-150 ease-in-out">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Kembali
                        </a>
                    </div>

                    <form action="{{ route('periksa_keras.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Input Tanggal -->
                        <div class="mb-4">
                            <label for="tanggal" class="block text-sm font-medium text-gray-700">Tanggal</label>
                            <input type="date" name="tanggal" id="tanggal" required
                                class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-emerald-500 focus:border-emerald-500 sm:text-sm">
                        </div>

                        <!-- Input Fakultas -->
                        <div class="mb-4">
                            <label for="fakultas" class="block text-sm font-medium text-gray-700">Fakultas</label>
                            <select name="fakultas_id" id="fakultas" required
                                class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-emerald-500 focus:border-emerald-500 sm:text-sm">
                                <option value="">Pilih Fakultas</option>
                                @foreach($fakultas as $fakults)
                                    <option value="{{ $fakults->id }}">{{ $fakults->nama_fakultas }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Input Lab -->
                        <div class="mb-4">
                            <label for="labs" class="block text-sm font-medium text-gray-700">Lab</label>
                            <select name="lab_id" id="lab" required disabled
                                class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-emerald-500 focus:border-emerald-500 sm:text-sm">
                                <option value="">Pilih Lab</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700">Ditambahkan Oleh</label>
                            <input type="text" name="name" id="name" value="{{ Auth::user()->name ?? '' }}" readonly
                                class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-gray-100 rounded-md shadow-sm">
                        </div>

                        <!-- Input Pemeriksaan -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Data Pemeriksaan</label>
                            <table class="w-full border border-gray-300 mt-2" id="data-table">
                                <thead>
                                    <tr id="main-header"></tr>
                                    <tr id="sub-header"></tr>
                                </thead>
                                
                                <tbody id="isi-table"></tbody>
                            </table>
                        </div>

                        <!-- Tombol Simpan -->
                        <div class="mt-6">
                            <button type="submit"
                                class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-lg flex items-center transition duration-150 ease-in-out">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7"></path>
                                </svg>
                                Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const fakultasSelect = document.getElementById("fakultas");
            const labSelect = document.getElementById("lab");
            const mainHeader = document.getElementById("main-header");
            const subHeader = document.getElementById("sub-header");
            const namaHeader = document.getElementById("nama-header");
            const isiTable = document.getElementById("isi-table");

            fakultasSelect.addEventListener("change", function () {
                const fakultasId = this.value;
                labSelect.innerHTML = '<option value="">Pilih Lab</option>';
                labSelect.disabled = true;

                if (fakultasId) {
                    fetch(`/get-labs/${fakultasId}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.length > 0) {
                                data.forEach(lab => {
                                    const option = document.createElement("option");
                                    option.value = lab.id;
                                    option.textContent = lab.nama_lab;
                                    labSelect.appendChild(option);
                                });
                                labSelect.disabled = false;
                            }
                        })
                        .catch(error => console.error("Error fetching labs:", error));
                }
            });
            
            labSelect.addEventListener("change", function () {
                const labId = this.value;
                isiTable.innerHTML = "";
                mainHeader.innerHTML = "";
                subHeader.innerHTML = "";

                if (labId) {
                    fetch(`/get-keras/${labId}`)
                        .then(response => response.json())
                        .then(data => {
                            const perangkatList = data.nama;
                            const jumlahMeja = data.jumlah_meja;
                            const colspan = perangkatList.length;

                            // Header Utama (Baris 1)
                            mainHeader.innerHTML = `
                                <th rowspan="2" class="text-center border px-3 py-2 bg-gray-200">No. Meja</th>
                                <th colspan="${colspan}" class="text-center border px-3 py-2 bg-blue-200">Kondisi Fisik</th>
                                <th colspan="${colspan}" class="text-center border px-3 py-2 bg-green-200">Kondisi Fungsional</th>
                                <th rowspan="2" class="text-center border px-3 py-2 bg-gray-200">Keterangan</th>
                            `;

                            // Header Nama Perangkat (Baris 2)
                            subHeader.innerHTML = '';
                            perangkatList.forEach(perangkat => {
                                subHeader.innerHTML += `<th class="text-center border px-3 py-2 bg-blue-100">${perangkat.nama}</th>`;
                            });
                            perangkatList.forEach(perangkat => {
                                subHeader.innerHTML += `<th class="text-center border px-3 py-2 bg-green-100">${perangkat.nama}</th>`;
                            });

                            // Baris Data Meja
                            for (let i = 0; i < jumlahMeja; i++) {
                                let row = document.createElement("tr");

                                let noCell = `<td class="text-center border px-3 py-2 bg-gray-50">${i}</td>`;

                                let fisikInputs = perangkatList.map((perangkat, index) =>
                                    `<td class="border px-3 py-2">
                                        <select name="fisik[${i}][${index}]" class="border rounded px-2 py-1 w-full">
                                            <option value="">-- Pilih --</option>
                                            <option value="Baik">Baik</option>
                                            <option value="Buruk">Buruk</option>
                                        </select>
                                    </td>`
                                ).join("");

                                let fungsiInputs = perangkatList.map((perangkat, index) =>
                                    `<td class="border px-3 py-2">
                                        <select name="fungsi[${i}][${index}]" class="border rounded px-2 py-1 w-full">
                                            <option value="">-- Pilih --</option>
                                            <option value="Baik">Baik</option>
                                            <option value="Buruk">Buruk</option>
                                        </select>
                                    </td>`
                                ).join("");

                                let ketCell = `<td class="border px-3 py-2">
                                    <input type="text" name="keterangan[${i}]" class="border rounded px-2 py-1 w-full" placeholder="Catatan tambahan">
                                </td>`;

                                row.innerHTML = `${noCell}${fisikInputs}${fungsiInputs}${ketCell}`;
                                isiTable.appendChild(row);
                            }
                        })
                        .catch(error => console.error("Error fetching perangkat keras:", error));
                }
            });
        });
    </script>
</x-app-layout>
