<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kunjungan extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'is_assigned' => 'boolean',
    ];

    public function pasien()
    {
        return $this->belongsTo(Pasien::class);
    }

    
public function obats()
{
    return $this->belongsToMany(Obat::class)->withPivot('jumlah');
}

public function peralatans()
{
    return $this->belongsToMany(Peralatan::class);
}

    public function dokter()
    {
        return $this->belongsTo(Dokter::class);
    }

    public function rekamMedis()
    {
        return $this->hasOne(RekamMedis::class);
    }

    public function resep()
    {
        return $this->hasOne(Resep::class);  // Assuming each Kunjungan has one Resep
    }

    public function user()
    {
        return $this->belongsTo(User::class);  // Menambahkan 'return' untuk relasi ini
    }
}
