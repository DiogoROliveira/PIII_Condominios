<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Condominium extends Model
{

    use HasFactory;

    protected $table = 'condominiums';

    protected $fillable = [
        'name',
        'address',
        'city',
        'state',
        'postal_code',
        'phone',
        'email',
        'admin_id',
        'number_of_blocks',
    ];

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function blocks()
    {
        return $this->hasMany(Block::class, 'condominium_id');
    }
}
