<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Ticket extends Model
{
    use HasFactory;

    protected $table = 'tickets';

    protected $fillable = [
        'titre',
        'description',
        'statut',
        'priorite',
        'date_creation',
        'date_mise_a_jour',
        'id_employe',
        'id_technicien',
    ];

    protected $dates = ['date_creation', 'date_mise_a_jour'];

    // Relations
    public function employe()
    {
        return $this->belongsTo(User::class, 'id_employe');
    }

    public function technicien()
    {
        return $this->belongsTo(User::class, 'id_technicien');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'ticket_id');
    }

    // Scopes
    public function scopeOpen($query)
    {
        return $query->where('statut', 'Ouvert');
    }

    public function scopeInProgress($query)
    {
        return $query->where('statut', 'En cours');
    }

    public function scopeResolved($query)
    {
        return $query->where('statut', 'Résolu');
    }

    public function scopeClosed($query)
    {
        return $query->where('statut', 'Fermé');
    }

    // Accessor : temps de résolution en minutes
    public function getResolutionTimeAttribute()
    {
        if ($this->statut === 'Résolu' && $this->date_creation && $this->date_mise_a_jour) {
            return Carbon::parse($this->date_creation)->diffInMinutes($this->date_mise_a_jour);
        }

        return null;
    }
}
