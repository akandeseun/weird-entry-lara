<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Wishlist extends Model
{
    use HasFactory, HasUlids;

    protected $guarded = ['id'];

    public function products(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
