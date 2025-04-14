@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4 text-center">🛠️ Tableau de bord - Technicien</h1>

    {{-- Liste des tickets --}}
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">📋 Tickets qui vous sont assignés</h4>
        </div>
        <div class="card-body p-0">
            @if ($openTickets->isEmpty())
                <div class="p-4 text-center">Aucun ticket ouvert pour le moment.</div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th>Titre</th>
                                <th>Description</th>
                                <th>Priorité</th>
                                <th>Statut</th>
                                <th>Action effectuée</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($openTickets as $ticket)
                                <tr>
                                    <td>{{ $ticket->titre }}</td>
                                    <td>{{ Str::limit($ticket->description, 50) }}</td>
                                    <td>
                                        <span class="badge
                                            @if($ticket->priorite === 'Critique') bg-danger
                                            @elseif($ticket->priorite === 'Élevée') bg-warning text-dark
                                            @elseif($ticket->priorite === 'Moyenne') bg-info
                                            @else bg-secondary @endif">
                                            {{ $ticket->priorite }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge
                                            @if($ticket->statut === 'Ouvert') bg-primary
                                            @elseif($ticket->statut === 'En cours') bg-warning text-dark
                                            @elseif($ticket->statut === 'Résolu') bg-success
                                            @else bg-dark @endif">
                                            {{ $ticket->statut }}
                                        </span>
                                    </td>
                                    <td>
                                        <form action="{{ route('tickets.update', $ticket->id) }}" method="POST" class="d-flex flex-column gap-2">
                                            @csrf
                                            @method('PUT')
                                            <textarea name="action_taken" class="form-control" rows="2" placeholder="Décrire l'action effectuée..." required></textarea>
                                            <button type="submit" class="btn btn-sm btn-warning">Mettre à jour</button>
                                        </form>
                                    </td>
                                    <td class="text-center">
                                        <form id="close-ticket-form-{{ $ticket->id }}" action="{{ route('tickets.close', $ticket->id) }}" method="POST" style="display:none;">
                                            @csrf
                                            @method('PUT')
                                        </form>
                                        <button class="btn btn-sm btn-success mt-2"
                                            onclick="event.preventDefault(); document.getElementById('close-ticket-form-{{ $ticket->id }}').submit();">
                                            Fermer
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
