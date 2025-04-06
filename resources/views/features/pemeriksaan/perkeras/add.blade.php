<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabel Pemeriksaan Perangkat Keras</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
            text-align: center;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .fisik {
            background-color: #B0B0B0; /* Warna abu-abu */
        }
        .fungsional {
            background-color: #F4A460; /* Warna oranye */
        }
        .tanggal {
            text-align: left;
            font-weight: bold;
            padding: 8px;
        }
        .hidden {
            display: none;
        }
    </style>
</head>
<body>
    <!-- Tabel Pemeriksaan Perangkat Keras -->
    <div>
        <label class="block text-sm font-medium text-gray-700">Pemeriksaan Perangkat Keras</label>
        <table>
            <thead>
                <tr>
                    <th rowspan="2">No Meja</th>
                    <th colspan="{{ count($perangkatKeras) }}" >Kondisi Fisik</th>
                    <th colspan="1" >Kondisi Fungsional</th>
                    <th rowspan="2">Keterangan</th>
                </tr>
                <tr>
                    @foreach ($perangkatKeras as $perangkat)
                        <th class="fisik">{{ $perangkat->nama}}</th>
                    @endforeach
                    <th class="fungsional">Nama Perangkat</th>
                </tr>
            </thead>
            <tbody id="perangkat-keras-table">
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const perangkatKerasTable = document.getElementById("perangkat-keras-table");
            const namaPerangkatKeras = document.getElementById("nama-perangkat");
            const labSelect = document.getElementById("lab");

            labSelect.addEventListener("change", function () {
                const labId = this.value;
                perangkatKerasTable.innerHTML = "";

                if (labId) {
                    fetch(`/get-meja/${labId}`)
                        .then(response => response.json())
                        .then(data => {
                            let jumlahMeja = data.jumlah_meja || 0;
                            for (let i = 0; i < jumlahMeja; i++) {
                                let row = document.createElement("tr");
                                row.innerHTML = `
                                    <td>${i}</td>
                                    <td><input type="text" name="fisik[${i}]" class="border rounded px-2 py-1 w-full" placeholder="Nama Perangkat"></td>
                                    <td><input type="text" name="fungsional[${i}]" class="border rounded px-2 py-1 w-full" placeholder="Nama Perangkat"></td>
                                    <td><input type="text" name="keterangan[${i}]" class="border rounded px-2 py-1 w-full" placeholder="Keterangan"></td>
                                `;
                                perangkatKerasTable.appendChild(row);
                            }
                        })
                        .catch(error => console.error("Error fetching jumlah meja:", error));
                }
            });
        });

        $(document).ready(function () {
            $('#lab_select').on('change', function () {
                var lab_id = $(this).val();
                if (lab_id) {
                    $.ajax({
                        url: '/get-perangkat-keras/' + lab_id,
                        type: 'GET',
                        success: function (data) {
                            $('#perangkat_keras_select').empty();
                            $.each(data, function (key, value) {
                                $('#perangkat_keras_select').append('<option value="' + value.id + '">' + value.nama + '</option>');
                            });
                        }
                    });
                } else {
                    $('#perangkat_keras_select').empty();
                }
            });
        });

    </script>

</body>
</html>
