<?php

namespace App\Models\Store;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Book extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'author',
        'pages',
        'price',
        'description',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'id' => 'integer',
            'pages' => 'integer',
            'price' => 'decimal:2',
        ];
    }

    public function name(): Attribute
    {
        return Attribute::make(
            get: fn(string $value) => Str::title($value)
        );
    }

    public function author(): Attribute
    {
        return Attribute::make(
            get: fn(string $value) => Str::title($value)
        );
    }
}
