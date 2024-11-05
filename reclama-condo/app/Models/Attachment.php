<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attachment extends Model
{
    use HasFactory;

    protected $table = 'attachments';

    protected $fillable = ['path'];

    public function complaint()
    {
        return $this->belongsTo(Complaint::class);
    }
}
