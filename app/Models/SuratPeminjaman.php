<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratPeminjaman extends Model
{
    use HasFactory;

    protected $table = 'surat_peminjaman';

    protected $fillable = [
        'user_id','lab_id','instansi','no_telp','uraian',
        'jumlah_orang','lama_pinjam','tanggal_mulai','tanggal_selesai','status'
    ];

    public function pemohon()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function lab()
    {
        return $this->belongsTo(Lab::class, 'lab_id');
    }
}
