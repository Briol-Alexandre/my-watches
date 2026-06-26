<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WishlistWatch extends Model
{
    protected $fillable = [
        'model',
        'picture',
        'brand_id',
        'price',
        'movement',
    ];

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function toWatchAttributes(): array
    {
        return [
            'model' => $this->model,
            'picture' => $this->picture,
            'brand_id' => $this->brand_id,
            'price' => $this->price,
            'movement' => $this->movement,
        ];
    }
}
