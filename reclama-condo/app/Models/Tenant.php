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
        'lease_start_date',
        'lease_end_date',
        'status',
        'notes',
    ];

    protected $with = ['user', 'units.block.condominium'];

    public function units()
    {
        return $this->hasMany(Unit::class, 'tenant_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function monthly_payments()
    {
        return $this->hasMany(MonthlyPayment::class, 'tenant_id');
    }
}
