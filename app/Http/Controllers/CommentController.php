<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Enregistre un nouveau commentaire lié à un ticket.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $ticketId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, $ticketId)
    {
        // Validation des données entrées
        $validated = $request->validate([
            'comment' => 'required|string|max:1000',
        ]);

        // Vérification de l'existence du ticket
        $ticket = Ticket::findOrFail($ticketId);

        // Création du commentaire
        Comment::create([
            'ticket_id' => $ticket->id,
            'user_id' => auth()->id(),
            'comment' => $validated['comment'],
        ]);

        return redirect()
            ->route('tickets.show', $ticket->id)
            ->with('success', 'Commentaire ajouté.');
    }
}
