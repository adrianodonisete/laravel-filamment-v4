<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    protected $fillable = [
        'id',
        'name',
        'price',
        'description',
        'category_id',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'id' => 'integer',
        ];
    }

    public function name(): Attribute
    {
        return Attribute::make(
            get: fn($value) => str($value)->upper(),
            set: fn($value) => str($value)->upper(),
        );
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
