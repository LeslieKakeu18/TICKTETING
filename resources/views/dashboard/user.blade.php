@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4 text-center">🙋‍♂️ Tableau de bord - Employé</h1>

    {{-- Création de ticket --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-success text-white">
            <h4 class="mb-0">📩 Soumettre un nouveau ticket</h4>
        </div>
        <div class="card-body">
            <a href="{{ route('tickets.create') }}" class="btn btn-success">Créer un ticket</a>
        </div>
    </div>

    {{-- Liste des tickets --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-info text-white">
            <h4 class="mb-0">🎟️ Mes tickets</h4>
        </div>
        <div class="card-body p-0">
            @if ($userTickets->isEmpty())
                <div class="p-4">
                    <p class="alert alert-info mb-0">
                        {{ $noTicketsMessage ?? 'Vous n\'avez pas encore soumis de ticket.' }}
                        <a href="{{ route('tickets.create') }}">Soumettez-en un ici</a>.
                    </p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th>Titre</th>
                                <th>Statut</th>
                                <th>Dernière mise à jour</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($userTickets as $ticket)
                                <tr>
                                    <td>
                                        <a href="{{ route('tickets.show', $ticket->id) }}">{{ $ticket->titre }}</a>
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
                                    <td>{{ $ticket->updated_at->format('d/m/Y H:i') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    {{-- Notifications --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-secondary text-white">
            <h4 class="mb-0">🔔 Notifications</h4>
        </div>
        <div class="card-body">
            @if ($notifications->isEmpty())
                <p class="alert alert-secondary mb-0">Vous n'avez aucune notification.</p>
            @else
                <ul class="list-group">
                    @foreach ($notifications as $notification)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>
                                {{ $notification->data['message'] ?? 'Mise à jour sur un ticket.' }}
                            </span>
                            <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</div>
@endsection
