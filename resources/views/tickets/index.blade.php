@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4 text-center">🎟️ Liste des tickets</h1>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
        </div>
    @endif

    <div class="mb-4 text-end">
        <a href="{{ route('tickets.create') }}" class="btn btn-success">
            <i class="fas fa-plus-circle me-1"></i> Créer un ticket
        </a>
    </div>

    <div class="table-responsive shadow-sm">
        <table class="table table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Titre</th>
                    <th>Priorité</th>
                    <th>Statut</th>
                    <th>Date de création</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($tickets as $ticket)
                    <tr>
                        <td>{{ $ticket->titre }}</td>

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

                        <td>{{ \Carbon\Carbon::parse($ticket->date_creation)->format('d/m/Y') }}</td>

                        <td class="text-center">
                            <div class="btn-group" role="group">
                                <a href="{{ route('tickets.show', $ticket->id) }}" class="btn btn-sm btn-outline-info" title="Voir">
                                    <i class="fas fa-eye"></i>
                                </a>

                                @if(Auth::user()->role == 'Admin' || Auth::id() == $ticket->id_employe || Auth::id() == $ticket->id_technicien)
                                    <a href="{{ route('tickets.edit', $ticket->id) }}" class="btn btn-sm btn-outline-warning" title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                @endif

                                @if(Auth::user()->role == 'Admin' || Auth::id() == $ticket->id_technicien)
                                    <form action="{{ route('tickets.close', $ticket->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Fermer">
                                            <i class="fas fa-times-circle"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">Aucun ticket à afficher.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
