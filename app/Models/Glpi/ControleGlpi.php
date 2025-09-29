<?php

namespace App\Models\Glpi;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class ControleGlpi extends Model
{
    protected $table = 'controle_ti';
    protected $connection = 'mariaglpi';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'id_ticket',
        'name',
        'date_creation',
        'date_mod',
        'note',
        'proj',
        'jira',
        'area',
        'status',
        'priority_order',
        'priority_number',
    ];

    protected function casts(): array
    {
        return [
            'id' => 'integer',
            'id_ticket' => 'integer',
            'date_creation' => 'datetime',
            'date_mod' => 'datetime',
            'status' => 'integer',
            'priority_order' => 'integer',
            'priority_number' => 'decimal:14,6',
        ];
    }

    public function priorityNumber(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value === null ? null : number_format((float) $value, 6, '.', ''),
        );
    }
}
