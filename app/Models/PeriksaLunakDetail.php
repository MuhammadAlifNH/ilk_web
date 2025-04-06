<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Testing\Fluent\Concerns\Has;

class PeriksaLunakDetail extends Model
{
    use HasFactory;
    protected $fillable = ['periksa_lunak_id', 'meja_ke', 'perlunak_id', 'kondisi_fisik', 'kondisi_fungsional', 'keterangan'];
    
    public function periksaLunak()
    {
        return $this->belongsTo(PeriksaLunak::class, 'periksa_lunak_id');
    }

    public function perangkat()
    {
        return $this->belongsTo(PerLunak::class, 'perlunak_id');
    }
}
