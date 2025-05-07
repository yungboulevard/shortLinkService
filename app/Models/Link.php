<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

class Link extends Model
{
    protected $fillable = [
        'slug', 
        'url',
        'expires_at'
    ];

    protected static function booted()
    {
        static::addGlobalScope('expired', function (Builder $builder) {
            $builder->where(function (Builder $query) {
                $query->whereNull('expires_at')
                      ->orWhere('expires_at', '>', Carbon::now());
            });
        });
    }
}
