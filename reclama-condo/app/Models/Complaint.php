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


    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function complaintType()
    {
        return $this->belongsTo(ComplaintType::class);
    }

    public function attachments()
    {
        return $this->hasMany(Attachment::class);
    }
}
