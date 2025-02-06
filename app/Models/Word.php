<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Word extends Model
{
    protected $fillable = [
        'word', 'letter', 'verified', 'source', 'data',
    ];

    protected $casts = [
        'data' => 'array',
        'verified' => 'boolean',
    ];
}
