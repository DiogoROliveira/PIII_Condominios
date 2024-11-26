<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'unit_id',
        'title',
        'description',
        'complaint_type_id',
        'status',
        'response',
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    public function complaintType()
    {
        return $this->belongsTo(ComplaintType::class, 'complaint_type_id');
    }

    public function attachments()
    {
        return $this->hasMany(Attachment::class, 'complaint_id');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }
}
