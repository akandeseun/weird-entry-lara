<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Str;

class Order extends Model
{
    use HasFactory, HasUlids;


    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->order_reference = 'WRD-' . strtoupper(Str::random(6));
        });
    }

    protected $guarded = ['id'];

    protected $casts = [
        'shipping_address' => 'array'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function cart(): BelongsTo
    {
        return $this->belongsTo(Cart::class);
    }
}
