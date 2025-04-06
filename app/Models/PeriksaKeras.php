<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeriksaKeras extends Model
{
    use HasFactory;

    protected $fillable =  [ 'fakultas_id', 'lab_id', 'user_id','tanggal' ];

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

    public function details()
    {
        return $this->hasMany(PeriksaKerasDetail::class);
    }
}
