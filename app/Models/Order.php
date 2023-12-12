<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Str;

class Order extends Model
{
    use HasFactory;


    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->order_reference = 'WRD' . Str::random(7);
        });
    }

    protected $guarded = ['id'];

    protected $casts = [
        'shipping_address' => 'array'
    ];
}
