<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RincianLunak extends Model
{
    use HasFactory;

    protected $fillable = ['pemriksaan_id', 'lunak_id', 'kondisi', 'keterangan'];

    public function pemeriksaan()
    {
        return $this->belongsTo(Pemeriksaan::class);
    }

    public function lunak()
    {
        return $this->belongsTo(Perlunak::class);
    }
}
