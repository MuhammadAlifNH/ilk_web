<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeriksaKerasDetail extends Model
{
    use HasFactory;
    protected $fillable = ['periksa_keras_id', 'meja_ke', 'perkeras_id', 'kondisi_fisik', 'kondisi_fungsional', 'keterangan'];

    public function periksaKeras()
    {
        return $this->belongsTo(PeriksaKeras::class, 'periksa_keras_id');
    }
    
    public function perangkat()
    {
        return $this->belongsTo(Perkeras::class, 'perkeras_id');
    }
    

}
