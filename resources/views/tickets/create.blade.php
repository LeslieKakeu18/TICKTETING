@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4 text-center">📝 Créer un nouveau ticket</h1>

    <!-- Message de succès -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('tickets.store') }}" method="POST" novalidate>
                @csrf

                <!-- Titre -->
                <div class="form-group mb-3">
                    <label for="titre" class="form-label">Titre du ticket</label>
                    <input type="text" name="titre" id="titre"
                           class="form-control @error('titre') is-invalid @enderror"
                           value="{{ old('titre') }}" required minlength="5" maxlength="255"
                           placeholder="Ex: Problème de connexion réseau">

                    @error('titre')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Description -->
                <div class="form-group mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" id="description"
                              class="form-control @error('description') is-invalid @enderror"
                              rows="4" required minlength="10"
                              placeholder="Décrivez le problème rencontré...">{{ old('description') }}</textarea>

                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Priorité -->
                <div class="form-group mb-3">
                    <label for="priorite" class="form-label">Priorité</label>
                    <select name="priorite" id="priorite"
                            class="form-control @error('priorite') is-invalid @enderror"
                            required>
                        <option value="">-- Sélectionnez une priorité --</option>
                        <option value="Faible" {{ old('priorite') == 'Faible' ? 'selected' : '' }}>Faible</option>
                        <option value="Moyenne" {{ old('priorite') == 'Moyenne' ? 'selected' : '' }}>Moyenne</option>
                        <option value="Élevée" {{ old('priorite') == 'Élevée' ? 'selected' : '' }}>Élevée</option>
                        <option value="Critique" {{ old('priorite') == 'Critique' ? 'selected' : '' }}>Critique</option>
                    </select>

                    @error('priorite')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Bouton -->
                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-plus-circle me-1"></i> Créer le ticket
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
