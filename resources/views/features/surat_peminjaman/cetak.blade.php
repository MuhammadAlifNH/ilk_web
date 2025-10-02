<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; line-height: 1.4; }
        h2 { text-align: center; margin-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 4px; text-align: center; }
        .kop { text-align: center; }
    </style>
</head>
<body>
    <div class="kop">
        <h3>UNISNU JEPARA</h3>
        <p>BUKU PEMINJAMAN RUANG LABORATORIUM KOMPUTER</p>
        <p>No. Dokumen: FM-Lab-04-02 | Tgl Berlaku: 31 Januari 2024</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Peminjam / Instansi</th>
                <th>No. Telp</th>
                <th>Uraian Peminjaman</th>
                <th>Nama Ruang</th>
                <th>Jumlah</th>
                <th>Lama Pinjam</th>
                <th>TTD</th>
                <th>Tanggal Mulai</th>
                <th>Tanggal Selesai</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $i => $row)
            <tr>
                <td>{{ $i+1 }}</td>
                <td>{{ $row->pemohon->name }} / {{ $row->instansi }}</td>
                <td>{{ $row->no_telp }}</td>
                <td>{{ $row->uraian }}</td>
                <td>{{ $row->lab->nama_ruangan }}</td>
                <td>{{ $row->jumlah_orang ?? '-' }}</td>
                <td>{{ $row->lama_pinjam ?? '-' }}</td>
                <td></td>
                <td>{{ $row->tanggal_mulai }}</td>
                <td>{{ $row->tanggal_selesai }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
