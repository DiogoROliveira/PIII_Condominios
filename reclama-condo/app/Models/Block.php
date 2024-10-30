<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Block extends Model
{
    use HasFactory;

    protected $table = 'blocks';

    protected $fillable = [
        'block',
        'condominium_id',
        'number_of_units',
    ];

    public function condominium()
    {
        return $this->belongsTo(Condominium::class, 'condominium_id');
    }

    public function units()
    {
        return $this->hasMany(Unit::class, 'block_id');
    }
}
