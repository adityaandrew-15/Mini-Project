<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    use HasFactory;

    protected $fillable = ['nama', 'alamat', 'no_hp', 'tanggal_lahir'];

    public function kunjungan()
    {
        return $this->hasMany(Kunjungan::class, 'pasien_id', 'id');
    }
}

