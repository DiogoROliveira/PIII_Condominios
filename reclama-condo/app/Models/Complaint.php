<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'complaint_type_id',
        'status',
    ];

    // Relacionamento com o modelo User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relacionamento com o modelo ComplaintType (assumindo que já foi criado)
    public function complaintType()
    {
        return $this->belongsTo(ComplaintType::class);
    }
}
