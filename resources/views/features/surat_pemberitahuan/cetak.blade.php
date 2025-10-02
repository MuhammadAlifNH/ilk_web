<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        .kop { text-align: center; }
        .judul { text-align: center; font-weight: bold; text-decoration: underline; margin: 20px 0; }
    </style>
</head>
<body>
    <div class="kop">
        <h3>UNISNU JEPARA</h3>
        <p>Fakultas Sains & Teknologi – Laboratorium Komputer</p>
        <hr>
    </div>

    <div class="judul">SURAT PEMBERITAHUAN</div>

    <p>Nomor: {{ $surat->nomor_surat }}</p>
    <p>Tanggal: {{ $surat->tanggal_surat->format('d M Y') }}</p>
    <p>Perihal: {{ $surat->perihal }}</p>

    <p style="margin-top:20px; white-space: pre-line;">
        {{ $surat->isi_surat }}
    </p>

    <div style="margin-top:50px; text-align:right;">
        <p>Hormat kami,</p>
        <p style="margin-top:60px;">{{ $surat->pengirim }}</p>
    </div>
</body>
</html>
