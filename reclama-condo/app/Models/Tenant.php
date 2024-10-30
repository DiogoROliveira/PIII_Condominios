<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tenant extends Model
{
    use HasFactory;

    public $table = 'tenants';

    protected $fillable = [
        'user_id',
        'unit_id',
        'lease_start_date',
        'lease_end_date',
        'status',
        'notes',
    ];

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
