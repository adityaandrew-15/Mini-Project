<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Pasien extends Model
{
    use HasFactory;

    protected $fillable = ['nama', 'alamat', 'no_hp', 'tanggal_lahir', 'user_id'];

    protected static function booted()
    {
        static::addGlobalScope('latest', function (Builder $builder) {
            $builder->orderBy('created_at', 'desc');  // Mengurutkan berdasarkan created_at
        });
    }

    public function kunjungan()
    {
        return $this->hasMany(Kunjungan::class);
    }

    public function rekamMedis() // Tambahkan relasi rekam medis
    {
        return $this->hasMany(RekamMedis::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
