<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'price',
        'description',
    ];

    public function name(): Attribute
    {
        return Attribute::make(
            get: fn($value) => str($value)->upper(),
            set: fn($value) => str($value)->upper(),
        );
    }
}
