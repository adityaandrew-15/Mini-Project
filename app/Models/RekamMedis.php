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
    return $this->hasOne(Resep::class); // Make sure this is a "hasOne" relationship
}


    public function obats()
    {
        return $this->belongsToMany(Obat::class, 'obat_rekam_medis')->withPivot('jumlah');
    }

    public function pasien()
    {
        return $this->belongsTo(Pasien::class);
    }

    public function peralatans()
{
    return $this->belongsToMany(Peralatan::class, 'peralatan_rekam_medis');
}


}


