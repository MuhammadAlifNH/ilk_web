<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Kelola Pemeriksaan') }}
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
                        <h1 class="text-2xl font-bold text-gray-800">Tambah Data Pemeriksaan</h1>
                        <a href="{{ route('pemeriksaan.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg flex items-center">
                            ⬅ Kembali
                        </a>
                    </div>

                    <form action="{{ route('pemeriksaan.store') }}" method="POST">
                        @csrf

                        <!-- Input Tanggal -->
                        <div class="mb-4">
                            <label for="tanggal" class="block text-sm font-medium text-gray-700">Tanggal</label>
                            <input type="date" name="tanggal" id="tanggal" required
                                class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:ring-emerald-500 focus:border-emerald-500">
                        </div>

                        <!-- Input Fakultas -->
                        <div class="mb-4">
                            <label for="fakultas" class="block text-sm font-medium text-gray-700">Fakultas</label>
                            <select name="fakultas_id" id="fakultas" required
                                class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:ring-emerald-500 focus:border-emerald-500">
                                <option value="">Pilih Fakultas</option>
                                @foreach($fakultas as $fakultas)
                                    <option value="{{ $fakultas->id }}">{{ $fakultas->nama_fakultas }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Input Lab -->
                        <div class="mb-4">
                            <label for="lab" class="block text-sm font-medium text-gray-700">Lab</label>
                            <select name="lab_id" id="lab" required disabled
                                class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:ring-emerald-500 focus:border-emerald-500">
                                <option value="">Pilih Lab</option>
                            </select>
                        </div>

                        <!-- Input Jenis Pemeriksaan -->
                        <div class="mb-4">
                            <label for="jenis" class="block text-sm font-medium text-gray-700">Jenis Pemeriksaan</label>
                            <select name="jenis" id="jenis" required
                                class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:ring-emerald-500 focus:border-emerald-500">
                                <option value="">Pilih Jenis</option>
                                <option value="Perangkat Keras">Perangkat Keras</option>
                                <option value="Perangkat Lunak">Perangkat Lunak</option>
                            </select>
                        </div>

                        @include('features.pemeriksaan.perkeras.add')

                        @include('features.pemeriksaan.perlunak.add')

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
            const jenisSelect = document.getElementById("jenis");
            const perangkatKerasContainer = document.getElementById("perangkat-keras-container");
            const perangkatLunakContainer = document.getElementById("perangkat-lunak-container");

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
                jenisSelect.addEventListener("change", function () {
                perangkatKerasContainer.style.display = "none";
                perangkatLunakContainer.style.display = "none";

                if (this.value === "Perangkat Keras") {
                    perangkatKerasContainer.style.display = "block";
                } else if (this.value === "Perangkat Lunak") {
                    perangkatLunakContainer.style.display = "block";
                }
            });
        });
    </script>
</x-app-layout>
