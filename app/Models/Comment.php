<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_id',
        'user_id',
        'comment',
    ];

    /**
     * Ticket auquel ce commentaire appartient
     */
    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    /**
     * Utilisateur (employé ou technicien) qui a écrit le commentaire
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
