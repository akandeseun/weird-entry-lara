<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Cart extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = ['items' => 'array'];

    public function order(): HasOne
    {
        return $this->hasOne(Order::class);
    }
}
