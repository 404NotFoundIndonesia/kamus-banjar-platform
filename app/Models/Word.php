<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
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

    protected $appends = [
        'word_source',
    ];

    protected function wordSource(): Attribute
    {
        return new Attribute(
            get: fn () => __('label.'.$this->source),
        );
    }

    public function scopeRender(Builder $query, ?int $size = null): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return $query
            ->orderBy('word')
            ->paginate($size ?? 20);
    }
}
