<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peralatan extends Model
{
    use HasFactory;

    protected $fillable = ['nama_peralatan','gambar', 'harga'];


    public function rekamMedis()
{
    return $this->belongsToMany(RekamMedis::class, 'peralatan_rekam_medis');
}

}
