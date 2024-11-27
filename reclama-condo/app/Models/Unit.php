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
        'tenant_id'
    ];

    public function block()
    {
        return $this->belongsTo(Block::class, 'block_id');
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class, 'tenant_id');
    }

    public function complaints()
    {
        return $this->hasMany(Complaint::class, 'unit_id');
    }
}
