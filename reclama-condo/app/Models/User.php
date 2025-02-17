<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Role;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    protected $table = 'users';

    // Many-to-One (User <-> Role)
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function isAdmin()
    {
        return $this->role && $this->role->name === 'admin';
    }

    public function getRoleName()
    {
        return $this->role ? $this->role->name : null;
    }

    public function condominiums()
    {
        return $this->hasMany(Condominium::class, 'admin_id');
    }

    public function setEmailForNotification($email)
    {
        $this->email = $email;
        return $this;
    }

    public function tenants()
    {
        return $this->hasMany(Tenant::class, 'user_id');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'role_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
