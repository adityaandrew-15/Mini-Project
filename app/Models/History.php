<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    use HasFactory;

    protected $fillable = ['type', 'action', 'reference_id', 'details'];

    protected $casts = [
        'details' => 'array',
    ];
}
