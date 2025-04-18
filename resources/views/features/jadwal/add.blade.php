<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Header dan Tombol -->
                    <div class="flex justify-between items-center mb-8">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-800">Jadwal Laboratorium</h1>
                            <p class="text-gray-600 mt-1">Manajemen jadwal penggunaan lab</p>
                        </div>
                        <button onclick="openUploadModal()" class="bg-purple-600 hover:bg-purple-700 text-white font-medium py-2.5 px-5 rounded-lg flex items-center transition-all duration-300 hover:scale-105">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Unggah Jadwal
                        </button>
                    </div>

                    <!-- Notifikasi -->
                    @if(session('success'))
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg flex items-center justify-between">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                {{ session('success') }}
                            </div>
                            <button onclick="this.parentElement.remove()" class="text-green-700 hover:text-green-900">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                </svg>
                            </button>
                        </div>
                    @endif

                    <!-- Grid Jadwal -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse($jadwal as $jdwl)
                            @php
                                // Ambil extension untuk dipakai di popup preview
                                $extension = strtolower(pathinfo($jdwl->jadwal, PATHINFO_EXTENSION));
                            @endphp

                            <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300">
                                <!-- Bagian header kartu (tanpa preview file) -->
                                <div class="bg-gray-900 h-16 w-full rounded-t-xl flex items-center justify-center text-white">
                                    <span class="text-sm font-semibold"> {{ $jdwl->lab->nama_lab }}</span>
                                </div>

                                <div class="p-6">
                                    <div class="flex justify-between items-start mb-4">
                                        <div>
                                            <!-- Info Lab & Fakultas -->
                                            <h3 class="text-lg font-semibold text-gray-800">{{ $jdwl->lab->nama_lab }}</h3>
                                            <p class="text-sm text-gray-500">{{ $jdwl->fakultas->nama_fakultas }}</p>
                                        </div>
                                        <!-- Tombol 'Mata' + Tombol Hapus -->
                                        <div class="flex items-center space-x-3">
                                            <!-- TOMBOL 'MATA' (untuk buka popup preview) -->
                                            <button 
                                                type="button" 
                                                class="text-gray-400 hover:text-gray-600"
                                                onclick="openPreview('{{ asset('storage/'.$jdwl->jadwal) }}','{{ $extension }}')"
                                            >
                                                <!-- Eye Icon -->
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                          d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"
                                                    />
                                                    <circle cx="12" cy="12" r="3" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                </svg>
                                            </button>

                                            <!-- TOMBOL HAPUS -->
                                            <form action="{{ route('jadwal.destroy', $jdwl->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button 
                                                    type="submit"
                                                    onclick="return confirm('Yakin ingin menghapus jadwal ini?')"
                                                    class="text-red-400 hover:text-red-600"
                                                >
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                              d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                                                        />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                    
                                    <div class="mb-4">
                                        <a href="{{ asset('storage/' . $jdwl->jadwal) }}" target="_blank" 
                                            class="inline-flex items-center text-purple-600 hover:text-purple-800"
                                        >
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                      d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                                                />
                                            </svg>
                                            Lihat Jadwal
                                        </a>
                                    </div>
                                    
                                    <div class="text-sm text-gray-500">
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                      d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                                                />
                                            </svg>
                                            {{ $jdwl->user->name }}
                                        </div>
                                        <div class="flex items-center mt-2">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                      d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                                                />
                                            </svg>
                                            {{ $jdwl->created_at->format('d M Y') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full text-center py-12">
                                <div class="text-gray-400 mb-4">
                                    <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                              d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                                        />
                                    </svg>
                                </div>
                                <p class="text-gray-500">Belum ada jadwal yang diunggah</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL: PREVIEW JADWAL (POPUP) -->
    <div id="previewModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-xl bg-white">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-semibold text-gray-800">Preview Jadwal</h3>
                <button onclick="closePreview()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M6 18L18 6M6 6l12 12"
                        />
                    </svg>
                </button>
            </div>
            <div id="previewContent"></div>
        </div>
    </div>

    <!-- MODAL: UPLOAD JADWAL -->
    <div id="uploadModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-xl bg-white">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-semibold text-gray-800">Unggah Jadwal Baru</h3>
                <button onclick="closeUploadModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 18L18 6M6 6l12 12"
                        />
                    </svg>
                </button>
            </div>

            <form id="uploadForm" enctype="multipart/form-data">
                <div class="space-y-4">
                    <!-- Fakultas -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Fakultas</label>
                        <select name="fakultas_id" class="fakultas-select w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            <option value="">Pilih Fakultas</option>
                            @foreach($fakultas as $f)
                                <option value="{{ $f->id }}">{{ $f->nama_fakultas }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Laboratorium -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Laboratorium</label>
                        <select name="lab_id" class="lab-select w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent" disabled>
                            <option value="">Pilih Lab</option>
                        </select>
                    </div>

                    <!-- File Jadwal -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">File Jadwal</label>
                        <div class="flex items-center justify-center w-full">
                            <!-- Area Upload -->
                            <label
                                id="uploadArea"
                                class="flex flex-col w-full border-2 border-dashed rounded-lg hover:border-purple-500 hover:bg-gray-50 transition-colors duration-200 cursor-pointer"
                            >
                                <!-- Placeholder Awal (ikon dan teks) -->
                                <div id="uploadPlaceholder" class="flex flex-col items-center justify-center pt-7">
                                    <svg class="w-12 h-12 text-purple-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                        <path 
                                            d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                        />
                                    </svg>
                                    <p class="text-sm text-gray-600 mt-2">Klik untuk upload</p>
                                    <p class="text-xs text-gray-500 mb-2">Format: JPG, PNG, PDF</p>
                                </div>

                                <!-- Kontainer Preview (awalnya disembunyikan) -->
                                <div id="previewContainer" class="hidden flex-col items-center justify-center pt-7"></div>

                                <!-- Input File -->
                                <input 
                                    type="file" 
                                    name="jadwal" 
                                    id="jadwalInput" 
                                    class="opacity-0" 
                                    accept="image/*, .pdf"
                                    required
                                >
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Tombol Aksi -->
                <div class="mt-6 flex justify-end space-x-3">
                    <button 
                        type="button" 
                        onclick="closeUploadModal()" 
                        class="px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg"
                    >
                        Batal
                    </button>
                    <button 
                        type="submit" 
                        class="px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-lg transition-colors duration-200"
                    >
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        /* ------------------------- MODAL UPLOAD ------------------------- */
        function openUploadModal() {
            document.getElementById('uploadModal').classList.remove('hidden');
        }
        function closeUploadModal() {
            document.getElementById('uploadModal').classList.add('hidden');
        }

        /* ------------------------- DYNAMIC LAB SELECT ------------------------- */
        document.querySelectorAll('.fakultas-select').forEach(select => {
            select.addEventListener('change', function() {
                const labSelect = this.closest('form').querySelector('.lab-select');
                labSelect.disabled = true;
                labSelect.innerHTML = '<option value=\"\">Pilih Lab</option>';
                
                if (this.value) {
                    fetch(`/get-labs/${this.value}`)
                        .then(response => response.json())
                        .then(data => {
                            data.forEach(lab => {
                                const option = document.createElement('option');
                                option.value = lab.id;
                                option.textContent = lab.nama_lab;
                                labSelect.appendChild(option);
                            });
                            labSelect.disabled = false;
                        });
                }
            });
        });

        /* ------------------------- FILE PREVIEW (SAAT UPLOAD) ------------------------- */
        const jadwalInput = document.getElementById('jadwalInput');
        const uploadPlaceholder = document.getElementById('uploadPlaceholder');
        const previewContainer = document.getElementById('previewContainer');

        jadwalInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            
            // Bersihkan preview sebelumnya
            previewContainer.innerHTML = '';

            if (!file) {
                // Kalau tidak ada file terpilih, tampilkan kembali placeholder
                uploadPlaceholder.classList.remove('hidden');
                previewContainer.classList.add('hidden');
                return;
            }

            // Sembunyikan placeholder, tampilkan kontainer preview
            uploadPlaceholder.classList.add('hidden');
            previewContainer.classList.remove('hidden');

            // Jika tipe file gambar, tampilkan <img>
            if (file.type.startsWith('image/')) {
                const img = document.createElement('img');
                img.src = URL.createObjectURL(file);
                img.alt = 'Preview Jadwal';
                img.className = 'w-full max-h-60 object-contain rounded-md';
                previewContainer.appendChild(img);
            }
            // Jika tipe file PDF, tampilkan <embed>
            else if (file.type === 'application/pdf') {
                const embed = document.createElement('embed');
                embed.src = URL.createObjectURL(file);
                embed.type = 'application/pdf';
                embed.className = 'w-full h-96 rounded-md';
                previewContainer.appendChild(embed);
            }
            // Jika bukan gambar atau PDF
            else {
                previewContainer.textContent = 'File tidak dapat ditampilkan pratinjau.';
            }
        });

        /* ------------------------- FORM SUBMIT (UPLOAD) ------------------------- */
        document.getElementById('uploadForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            
            fetch("{{ route('jadwal.store') }}", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.reload();
                } else {
                    alert(data.message || 'Terjadi kesalahan');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat mengunggah');
            });
        });

        /* ------------------------- MODAL PREVIEW (POPUP) ------------------------- */
        function openPreview(url, extension) {
            const previewModal = document.getElementById('previewModal');
            const previewContent = document.getElementById('previewContent');
            
            // Bersihkan konten sebelumnya
            previewContent.innerHTML = '';

            // Tampilkan preview sesuai tipe file
            if (['jpg','jpeg','png','gif','webp'].includes(extension)) {
                const img = document.createElement('img');
                img.src = url;
                img.alt = 'Preview Jadwal';
                img.className = 'w-full h-auto max-h-96 object-contain rounded-md';
                previewContent.appendChild(img);
            }
            else if (extension === 'pdf') {
                const embed = document.createElement('embed');
                embed.src = url;
                embed.type = 'application/pdf';
                embed.className = 'w-full h-96 rounded-md';
                previewContent.appendChild(embed);
            }
            else {
                previewContent.innerHTML = '<p class=\"text-gray-600\">Tidak dapat menampilkan preview untuk file ini.</p>';
            }

            // Buka modal
            previewModal.classList.remove('hidden');
        }

        function closePreview() {
            document.getElementById('previewModal').classList.add('hidden');
        }
    </script>
</x-app-layout>
