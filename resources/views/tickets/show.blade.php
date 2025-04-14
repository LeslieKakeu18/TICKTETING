@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4 text-center">🎫 {{ $ticket->titre }}</h1>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h5 class="card-title text-muted">📝 Description</h5>
            <p>{{ $ticket->description }}</p>

            <p><strong>📌 Priorité :</strong>
                <span class="badge 
                    @if($ticket->priorite === 'Critique') bg-danger
                    @elseif($ticket->priorite === 'Élevée') bg-warning text-dark
                    @elseif($ticket->priorite === 'Moyenne') bg-info
                    @else bg-secondary @endif">
                    {{ $ticket->priorite }}
                </span>
            </p>

            <p><strong>⚙️ Statut :</strong>
                <span class="badge 
                    @if($ticket->statut === 'Ouvert') bg-primary
                    @elseif($ticket->statut === 'En cours') bg-warning text-dark
                    @elseif($ticket->statut === 'Résolu') bg-success
                    @else bg-dark @endif">
                    {{ $ticket->statut }}
                </span>
            </p>

            <p><strong>📅 Créé le :</strong> {{ \Carbon\Carbon::parse($ticket->date_creation)->format('d/m/Y') }}</p>

            @if ($ticket->date_mise_a_jour)
                <p><strong>🔄 Mis à jour le :</strong> {{ \Carbon\Carbon::parse($ticket->date_mise_a_jour)->format('d/m/Y') }}</p>
            @endif

            <p><strong>👤 Employé :</strong> {{ $ticket->employe->name }}</p>

            @if ($ticket->technicien)
                <p><strong>🔧 Technicien :</strong> {{ $ticket->technicien->name }}</p>
            @else
                <p class="text-muted"><em>Aucun technicien assigné</em></p>
            @endif
        </div>
    </div>

    {{-- Commentaires --}}
    <div class="mb-4">
        <h4>💬 Commentaires</h4>

        @forelse ($ticket->comments as $comment)
            <div class="card mb-2 shadow-sm">
                <div class="card-body">
                    <p class="mb-1"><strong>{{ $comment->user->name }}</strong></p>
                    <p class="mb-0">{{ $comment->comment }}</p>
                </div>
            </div>
        @empty
            <p class="text-muted">Aucun commentaire pour ce ticket.</p>
        @endforelse
    </div>

    {{-- Formulaire ajout commentaire --}}
    @if (Auth::user()->role == 'Technicien' || Auth::user()->role == 'Admin')
        <div class="card mb-4 shadow-sm">
            <div class="card-body">
                <form action="{{ route('comments.store', $ticket->id) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="comment" class="form-label">Ajouter un commentaire</label>
                        <textarea name="comment" class="form-control @error('comment') is-invalid @enderror"
                                  rows="3" placeholder="Rédiger un commentaire..." required></textarea>

                        @error('comment')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mt-3 text-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-comment-dots me-1"></i> Ajouter
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    {{-- Actions admin/tech/employé --}}
    <div class="d-flex justify-content-between flex-wrap gap-2">
        @if (Auth::user()->role == 'Admin' || Auth::id() == $ticket->id_employe || Auth::id() == $ticket->id_technicien)
            <a href="{{ route('tickets.edit', $ticket->id) }}" class="btn btn-warning">
                <i class="fas fa-edit me-1"></i> Modifier le ticket
            </a>
        @endif

        @if (Auth::user()->role == 'Admin' || Auth::id() == $ticket->id_technicien)
            <form action="{{ route('tickets.close', $ticket->id) }}" method="POST">
                @csrf
                @method('PUT')
                <button type="submit" class="btn btn-danger">
                    <i class="fas fa-times-circle me-1"></i> Fermer ce ticket
                </button>
            </form>
        @endif
    </div>
</div>
@endsection
