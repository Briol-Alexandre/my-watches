<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Brand extends Model
{
    protected $fillable = [
        'name',
    ];

    public function watches(): HasMany
    {
        return $this->hasMany(Watch::class);
    }

    public function wishlistWatches(): HasMany
    {
        return $this->hasMany(WishlistWatch::class);
    }
}
