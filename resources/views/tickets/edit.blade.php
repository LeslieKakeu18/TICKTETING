@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4 text-center">✏️ Modifier le ticket : <span class="text-primary">{{ $ticket->titre }}</span></h1>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('tickets.update', $ticket->id) }}" method="POST" novalidate>
                @csrf
                @method('PUT')

                <!-- Titre -->
                <div class="mb-3">
                    <label for="titre" class="form-label">Titre</label>
                    <input type="text"
                           name="titre"
                           id="titre"
                           class="form-control @error('titre') is-invalid @enderror"
                           value="{{ old('titre', $ticket->titre) }}"
                           required minlength="5" maxlength="255">

                    @error('titre')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Description -->
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description"
                              id="description"
                              rows="4"
                              class="form-control @error('description') is-invalid @enderror"
                              required minlength="10">{{ old('description', $ticket->description) }}</textarea>

                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Priorité -->
                <div class="mb-3">
                    <label for="priorite" class="form-label">Priorité</label>
                    <select name="priorite"
                            id="priorite"
                            class="form-control @error('priorite') is-invalid @enderror"
                            required>
                        <option value="Faible" {{ old('priorite', $ticket->priorite) == 'Faible' ? 'selected' : '' }}>Faible</option>
                        <option value="Moyenne" {{ old('priorite', $ticket->priorite) == 'Moyenne' ? 'selected' : '' }}>Moyenne</option>
                        <option value="Élevée" {{ old('priorite', $ticket->priorite) == 'Élevée' ? 'selected' : '' }}>Élevée</option>
                        <option value="Critique" {{ old('priorite', $ticket->priorite) == 'Critique' ? 'selected' : '' }}>Critique</option>
                    </select>

                    @error('priorite')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Statut -->
                <div class="mb-3">
                    <label for="statut" class="form-label">Statut</label>
                    <select name="statut"
                            id="statut"
                            class="form-control @error('statut') is-invalid @enderror"
                            required>
                        <option value="Ouvert" {{ old('statut', $ticket->statut) == 'Ouvert' ? 'selected' : '' }}>Ouvert</option>
                        <option value="En cours" {{ old('statut', $ticket->statut) == 'En cours' ? 'selected' : '' }}>En cours</option>
                        <option value="Résolu" {{ old('statut', $ticket->statut) == 'Résolu' ? 'selected' : '' }}>Résolu</option>
                        <option value="Fermé" {{ old('statut', $ticket->statut) == 'Fermé' ? 'selected' : '' }}>Fermé</option>
                    </select>

                    @error('statut')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Bouton -->
                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Mettre à jour le ticket
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
