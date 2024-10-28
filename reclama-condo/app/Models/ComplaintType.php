<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComplaintType extends Model
{
    use HasFactory;

    protected $fillable = ['name']; // Adicione os campos que você deseja preencher em massa

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
