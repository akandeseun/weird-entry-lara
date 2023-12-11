<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Cart extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = ['items' => 'array'];


    public function products(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
