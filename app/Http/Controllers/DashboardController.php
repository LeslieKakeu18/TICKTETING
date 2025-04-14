<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    // Redirection vers le dashboard selon le rôle
    public function index()
    {
        $user = Auth::user();

        return match ($user->role) {
            'Admin' => redirect()->route('dashboard.admin'),
            'Technicien' => redirect()->route('dashboard.technician'),
            'Employé' => redirect()->route('dashboard.user'),
            default => redirect()->route('login')->withErrors(['error' => 'Rôle utilisateur non reconnu.']),
        };
    }

    // Dashboard Administrateur
    public function adminDashboard()
    {
        if (Auth::user()->role !== 'Admin') {
            return redirect()->route('dashboard')->with('error', 'Accès réservé aux administrateurs.');
        }

        $openTickets = Ticket::where('statut', 'Ouvert')->count();
        $resolvedTickets = Ticket::where('statut', 'Résolu')->count();
        $criticalTickets = Ticket::where('priorite', 'Critique')->count();
        $averageResolutionTime = Ticket::where('statut', 'Résolu')->avg('temps_resolution') ?? 0;

         // 👇 On ajoute ici la liste réelle des tickets ouverts (pour le formulaire)
    $openTicketsList = Ticket::where('statut', 'Ouvert')->get();

    // 👇 Et on peut aussi passer la liste des techniciens (si nécessaire pour la sélection)
    $technicians = \App\Models\User::where('role', 'Technicien')->get();

    return view('dashboard.admin', compact(
        'openTickets',
        'resolvedTickets',
        'criticalTickets',
        'averageResolutionTime',
        'openTicketsList',
        'technicians'
    ));
    }

    // Dashboard Technicien
    public function technicianDashboard()
{
    $user = auth()->user();

    $openTickets = Ticket::where('id_technicien', $user->id)
                         ->where('statut', 'Ouvert')
                         ->get();

    $assignedTickets = $openTickets->count();
    $resolvedByTechnician = Ticket::where('id_technicien', $user->id)
                                  ->where('statut', 'Résolu')
                                  ->count();

    return view('dashboard.technician', compact(
        'openTickets',
        'assignedTickets',
        'resolvedByTechnician'
    ));
}


    // Dashboard Employé
    public function userDashboard()
    {
        if (Auth::user()->role !== 'Employé') {
            return redirect()->route('dashboard')->with('error', 'Accès réservé aux employés.');
        }

        $user = Auth::user();
        $userTickets = Ticket::where('id_employe', $user->id)->get();
        $notifications = $user->notifications ?? collect();
        $noTicketsMessage = $userTickets->isEmpty() ? 'Vous n\'avez aucun ticket.' : null;

        return view('dashboard.user', compact('userTickets', 'notifications', 'noTicketsMessage'));
    }
}
