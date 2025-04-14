<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Hash;


class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Rôles constants
    const ROLE_ADMIN = 'admin';
    const ROLE_TECHNICIAN = 'technicien';
    const ROLE_EMPLOYEE = 'employé';

    // Champs mass-assignables
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    // Champs masqués dans les réponses JSON
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Relations
    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'id_employe');
    }

    public function assignedTickets()
    {
        return $this->hasMany(Ticket::class, 'id_technicien');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // Scopes
    public function scopeTechnician($query)
    {
        return $query->where('role', self::ROLE_TECHNICIAN);
    }

    public function scopeEmployee($query)
    {
        return $query->where('role', self::ROLE_EMPLOYEE);
    }

}
