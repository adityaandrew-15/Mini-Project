<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RekamMedisImage extends Model
{
    use HasFactory;

    protected $fillable = ['rekam_medis_id', 'image_path'];

    public function rekamMedis()
    {
        return $this->belongsTo(RekamMedis::class);
    }
}
