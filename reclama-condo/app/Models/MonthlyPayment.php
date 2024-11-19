<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonthlyPayment extends Model
{
    use HasFactory;

    protected $table = 'monthly_payments';

    protected $fillable = [
        'unit_id',
        'tenant_id',
        'due_date',
        'amount',
        'status',
        'paid_at'
    ];

    public function payments()
    {
        return $this->hasMany(Payment::class, 'monthly_payment_id');
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class, 'tenant_id');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }
}
