<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class History extends Model
{
    use HasFactory;

    protected static function booted()
    {
        static::addGlobalScope('latest', function (Builder $builder) {
            $builder->orderBy('created_at', 'desc');  // Mengurutkan berdasarkan created_at
        });
    }

    protected $fillable = ['type', 'action', 'reference_id', 'details'];

    protected $casts = [
        'details' => 'array',
    ];
}
