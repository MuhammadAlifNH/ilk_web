<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RincianKeras extends Model
{
    use HasFactory;

    protected $fillable = ['pemriksaan_id', 'keras_id', 'kondisi_fisik', 'kondisi_fungsional', 'keterangan'];

    public function pemeriksaan()
    {
        return $this->belongsTo(Pemeriksaan::class);
    }

    public function keras()
    {
        return $this->belongsTo(Perkeras::class);
    }
}
