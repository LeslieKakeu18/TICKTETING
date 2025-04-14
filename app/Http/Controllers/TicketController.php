<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\TicketUpdated;


class TicketController extends Controller
{
    // Afficher la liste des tickets selon le rôle
    public function index()
    {
        $user = Auth::user();

        $tickets = match ($user->role) {
            'Admin' => Ticket::all(),
            'Technicien' => Ticket::where('id_technicien', $user->id)->get(),
            'Employé' => Ticket::where('id_employe', $user->id)->get(),
            default => collect(),
        };

        return view('tickets.index', compact('tickets'));
    }

    // Formulaire de création (Employés uniquement)
    public function create()
    {
        if (!in_array(Auth::user()->role, ['Employé', 'Admin'])) {
            return redirect()->route('dashboard')->with('error', 'Vous n\'êtes pas autorisé à créer un ticket.');
        }
        

        return view('tickets.create');
    }

    // Enregistrer un nouveau ticket
    public function store(Request $request)
    {
        if (!in_array(Auth::user()->role, ['Employé', 'Admin'])) {
            return redirect()->route('dashboard')->with('error', 'Vous n\'êtes pas autorisé à créer un ticket.');
        }
        

        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'priorite' => 'required|in:Faible,Moyenne,Élevée,Critique',
        ]);

        Ticket::create([
            'titre' => $validated['titre'],
            'description' => $validated['description'],
            'priorite' => $validated['priorite'],
            'statut' => 'Ouvert',
            'id_employe' => Auth::id(),
        ]);

        return redirect()->route('tickets.index')->with('success', 'Ticket créé avec succès.');
    }

    // Afficher un ticket spécifique
    public function show($id)
    {
        $ticket = Ticket::findOrFail($id);
        $user = Auth::user();

        if (
            $user->role === 'Admin' ||
            $user->id === $ticket->id_employe ||
            $user->id === $ticket->id_technicien
        ) {
            return view('tickets.show', compact('ticket'));
        }

        return redirect()->route('tickets.index')->with('error', 'Accès interdit à ce ticket.');
    }

    // Formulaire d’édition (admin ou technicien assigné)
    public function edit($id)
    {
        $ticket = Ticket::findOrFail($id);
        $user = Auth::user();

        if (
            $user->role === 'Admin' ||
            $user->id === $ticket->id_technicien
        ) {
            return view('tickets.edit', compact('ticket'));
        }

        return redirect()->route('tickets.index')->with('error', 'Accès interdit à l’édition de ce ticket.');
    }

    // Mettre à jour un ticket (admin ou technicien)
    public function update(Request $request, $id)
    {
        $ticket = Ticket::findOrFail($id);
        $user = Auth::user();

        if (!in_array($user->role, ['Admin', 'Technicien']) || $user->id !== $ticket->id_technicien && $user->role !== 'Admin') {
            return redirect()->route('tickets.index')->with('error', 'Modification interdite.');
        }

        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'priorite' => 'required|in:Faible,Moyenne,Élevée,Critique',
            'statut' => 'required|in:Ouvert,En cours,Résolu,Fermé',
        ]);

        $ticket->update($validated);
        $employe = $ticket->employe;
        if ($employe) {
                $employe->notify(new TicketUpdated($ticket));
                    }


        return redirect()->route('tickets.index')->with('success', 'Ticket mis à jour.');
    }

    // Fermer un ticket (admin ou technicien)
    public function close($id)
    {
        $ticket = Ticket::findOrFail($id);
        $user = Auth::user();

        if (!in_array($user->role, ['Admin', 'Technicien']) || $user->id !== $ticket->id_technicien && $user->role !== 'Admin') {
            return redirect()->route('tickets.index')->with('error', 'Fermeture interdite.');
        }

        $ticket->update(['statut' => 'Fermé']);
        return redirect()->route('tickets.index')->with('success', 'Ticket fermé.');
    }

    // Supprimer un ticket (admin ou employé ayant créé)
    public function destroy($id)
    {
        $ticket = Ticket::findOrFail($id);
        $user = Auth::user();

        if ($user->role !== 'Admin' && $user->id !== $ticket->id_employe) {
            return redirect()->route('tickets.index')->with('error', 'Suppression non autorisée.');
        }

        $ticket->delete();
        return redirect()->route('tickets.index')->with('success', 'Ticket supprimé.');
    }

    public function assignTechnician(Request $request)
{
    $validated = $request->validate([
        'ticket_id' => 'required|exists:tickets,id',
        'technician_id' => 'required|exists:users,id',
    ]);

    $ticket = \App\Models\Ticket::find($validated['ticket_id']);
    $ticket->id_technicien = $validated['technician_id'];
    $ticket->save();

    return redirect()->route('dashboard.admin')->with('success', 'Technicien assigné au ticket avec succès.');
}

}
