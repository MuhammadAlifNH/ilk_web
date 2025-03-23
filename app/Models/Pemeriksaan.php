<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pemeriksaan extends Model
{
    use HasFactory;

    protected $fillable =  [ 'jenis', 'fakultas_id', 'lab_id', 'user_id','tanggal' ];

    public function fakultas()
    {
        return $this->belongsTo(Fakultas::class);
    }

    public function lab()
    {
        return $this->belongsTo(Labs::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function keras()
    {
        return $this->hasMany(RincianKeras::class);
    }

    public function lunaks()
    {
        return $this->hasMany(RincianLunak::class);
    }
}
