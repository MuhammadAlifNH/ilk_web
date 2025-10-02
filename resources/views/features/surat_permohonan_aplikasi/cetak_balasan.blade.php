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
        .footer { margin-top: 60px; text-align: right; }
    </style>
</head>
<body>
    <div class="kop">
        <h3>UNISNU JEPARA</h3>
        <p>JL. TAMAN SISWA NO. 09 TAHUNAN JEPARA</p>
        <p>No. Dokumen: FM-Lab-02-03 | Tgl Berlaku: 31 Januari 2024</p>
    </div>

    <div class="judul">BALASAN PERMOHONAN PENGADAAN SOFTWARE</div>

    <p>Nomor : {{ $balasan->nomor_surat ?? '-' }}</p>
    <p>Tanggal : {{ $balasan->tanggal_surat ? $balasan->tanggal_surat->format('d M Y') : '-' }}</p>
    <p>Lampiran : -</p>
    <p>Perihal : Balasan Surat Permohonan Instalasi Software</p>

    <p style="margin-top:20px;">Kepada Yth.<br>
       Bapak/Ibu {{ $balasan->permohonan->pemohon->name }}<br>
       Dosen Pengampu Praktikum<br>
       Di Tempat</p>

    <p>Assalamu’alaikum Wr. Wb.</p>

    <p>Dengan hormat,</p>

    <p>
        Menindaklanjuti surat permohonan Bapak/Ibu terkait instalasi software
        <strong>{{ $balasan->nama_software }}</strong> 
        untuk keperluan praktikum pada semester <strong>{{ ucfirst($balasan->semester) }}</strong> 
        tahun akademik <strong>{{ $balasan->tahun_akademik }}</strong>, 
        kami sampaikan bahwa aplikasi yang diajukan telah berhasil diinstalasi dan siap digunakan di Laboratorium Komputer.
    </p>

    <p>
        Silakan melakukan pengecekan lebih lanjut apabila diperlukan, dan jangan ragu untuk menghubungi kami apabila terdapat kendala dalam penggunaan software tersebut.
    </p>

    <p>Wassalamu’alaikum Wr. Wb.</p>

    <div class="footer">
        <p>Hormat saya,</p>
        <br><br><br>
        <p>({{ $balasan->ditandatangani_oleh ?? '.........................' }})</p>
    </div>
</body>
</html>
