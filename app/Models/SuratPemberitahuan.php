<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratPemberitahuan extends Model
{
    use HasFactory;

    protected $table = 'surat_pemberitahuan';

    protected $fillable = [
        'nomor_surat',
        'tanggal_surat',
        'perihal',
        'isi_surat',
        'pengirim',
    ];

    protected $casts = [
        'tanggal_surat' => 'date',
    ];
}
