<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Dokter extends Model
{
    use HasFactory;

    protected $fillable = ['nama', 'spesialis', 'no_hp', 'image', 'user_id'];

    protected static function booted()
    {
        static::addGlobalScope('latest', function (Builder $builder) {
            $builder->orderBy('created_at', 'desc');  // Mengurutkan berdasarkan created_at
        });
    }

    public function jadwalPraktek()
    {
        return $this->hasMany(JadwalPraktek::class);
    }

    // Di dalam model Dokter

    public function jadwals()
    {
        return $this->hasMany(JadwalPraktek::class, 'dokter_id');
    }

    public function kunjungan()
    {
        return $this->hasMany(Kunjungan::class);
    }

    // Dokter.php

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
