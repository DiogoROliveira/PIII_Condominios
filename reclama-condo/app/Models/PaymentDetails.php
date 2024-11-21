<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentDetails extends Model
{
    use HasFactory;

    protected $table = 'payment_details';

    protected $fillable = [
        'user_id',
        'method',
        'name',
        'card_number',
        'card_expiration',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
