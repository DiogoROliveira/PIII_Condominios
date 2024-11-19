<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;

    protected $table = 'units';

    protected $fillable = [
        'block_id',
        'unit_number',
        'status',
        'base_rent',
    ];

    public function block()
    {
        return $this->belongsTo(Block::class, 'block_id');
    }

    public function tenant()
    {
        return $this->hasOne(Tenant::class, 'unit_id');
    }
}
