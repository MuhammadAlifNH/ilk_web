<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; line-height: 1.5; }
        .kop { text-align: center; margin-bottom: 10px; }
        .kop h3 { margin: 0; }
        .kop p { margin: 2px 0; }
        .judul { text-align: center; font-weight: bold; text-decoration: underline; margin: 15px 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table th, table td { border: 1px solid #000; padding: 5px; text-align: center; }
        .footer { margin-top: 40px; text-align: right; }
    </style>
</head>
<body>
    <div class="kop">
        <h3>UNISNU JEPARA</h3>
        <p>JL. TAMAN SISWA NO. 09 TAHUNAN JEPARA</p>
        <p>No. Dokumen: FM-Lab-02-01 | Tgl Berlaku: 31 Januari 2024</p>
    </div>

    <div class="judul">FORMULIR PENGADAAN SOFTWARE</div>

    <p>Tanggal: {{ $permohonan->created_at->format('d M Y') }}</p>

    <p>Kepada Yth.<br>
       Kepala Laboratorium Komputer Universitas Islam Nahdlatul Ulama Jepara<br>
       Di Tempat</p>

    <p>Dengan hormat,</p>

    <p>
        Bersama ini saya <strong>{{ $permohonan->pemohon->name }}</strong> dari 
        Program Studi <strong>{{ $permohonan->program_studi }}</strong>, 
        Fakultas <strong>{{ $permohonan->fakultas }}</strong> 
        mengajukan permohonan pengadaan software untuk keperluan praktikum sebagai berikut:
    </p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Software</th>
                <th>Versi Software</th>
                <th>Jumlah Lisensi</th>
                <th>Jumlah Mahasiswa</th>
            </tr>
        </thead>
        <tbody>
            @foreach($permohonan->detail as $i => $item)
            <tr>
                <td>{{ $i+1 }}</td>
                <td>{{ $item->nama_software }}</td>
                <td>{{ $item->versi }}</td>
                <td>{{ $item->jumlah_lisensi }}</td>
                <td>{{ $item->jumlah_mahasiswa }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <p style="margin-top:20px;">
        Demikian permohonan ini saya sampaikan.  
        Atas perhatian dan kerjasamanya, kami ucapkan terima kasih.
    </p>

    <div class="footer">
        <p>Hormat saya,</p>
        <br><br><br>
        <p>({{ $permohonan->pemohon->name }})</p>
    </div>
</body>
</html>
