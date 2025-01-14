<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $table = 'payments'; // Nama tabel
    protected $fillable = [
        'rekam_medis_id',
        'total_bayar',
        'metode_pembayaran',
        'status_pembayaran',
    ];

    /**
     * Relasi ke model RekamMedis.
     */
    public function rekamMedis()
    {
        return $this->belongsTo(RekamMedis::class);
    }
}
