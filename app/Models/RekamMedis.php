<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RekamMedis extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function kunjungan()
    {
        return $this->belongsTo(Kunjungan::class);
    }

    public function images()
    {
        return $this->hasMany(RekamMedisImage::class);
    }

    public function resep()
    {
        return $this->hasMany(Resep::class);
    }

    public function obats()
    {
        return $this->belongsToMany(Obat::class)->withPivot('jumlah');
    }

    public function pasien()
    {
        return $this->belongsTo(Pasien::class);
    }
}


