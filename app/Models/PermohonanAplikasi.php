<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PermohonanAplikasi extends Model
{
    use HasFactory;

    protected $table = 'permohonan_aplikasi';

    protected $fillable = [
        'user_id','program_studi','fakultas','daftar_software','tgl_dibutuhkan',
        'alasan','status','nomor_surat_balasan','tanggal_balasan','isi_balasan','admin_id'
    ];

    protected $casts = [
        'daftar_software' => 'array',
        'tgl_dibutuhkan' => 'date',
        'tanggal_balasan' => 'date',
    ];

    public function pemohon() { return $this->belongsTo(User::class,'user_id'); }
    public function adminBalas() { return $this->belongsTo(User::class,'admin_id'); }
}

