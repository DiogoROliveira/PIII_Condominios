<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $table = 'roles';

    protected $fillable = [
        'name',
    ];

    // Many-to-Many (User <-> Role)
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_roles');
    }

    // Many-to-Many (Permission <-> Role)
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_permissions');
    }
}
