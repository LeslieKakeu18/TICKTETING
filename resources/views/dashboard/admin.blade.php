@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4 text-center">🎛️ Tableau de bord - Administrateur</h1>

    {{-- Statistiques --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">📊 Statistiques globales</h4>
        </div>
        <div class="card-body">
            <p><strong>Tickets ouverts :</strong> {{ $openTickets }}</p>
            <p><strong>Tickets résolus :</strong> {{ $resolvedTickets }}</p>
            <p><strong>Tickets critiques :</strong> {{ $criticalTickets }}</p>
            <p><strong>Temps moyen de résolution :</strong> {{ $averageResolutionTime }} heures</p>
        </div>
    </div>

    {{-- Gestion des utilisateurs --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">👥 Ajouter un nouvel utilisateur</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('users.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="name">Nom complet</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                </div>

                <div class="form-group">
                    <label for="email">Adresse e-mail</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                </div>

                <div class="form-group">
                    <label for="role">Rôle</label>
                    <select class="form-control" id="role" name="role" required>
                        <option value="" disabled selected>-- Sélectionner un rôle --</option>
                        <option value="technicien" {{ old('role') == 'technicien' ? 'selected' : '' }}>Technicien</option>
                        <option value="employé" {{ old('role') == 'employé' ? 'selected' : '' }}>Employé</option>
                    </select>
                </div>

                <div class="form-group mt-3">
                    <label for="password">Mot de passe</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>

                <div class="form-group mt-3">
                    <label for="password_confirmation">Confirmation du mot de passe</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                </div>

                <button type="submit" class="btn btn-success mt-4">Ajouter l'utilisateur</button>
            </form>
        </div>
    </div>

    {{-- Attribution technicien --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">🛠️ Attribuer un technicien à un ticket</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('tickets.assignTechnician') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="ticket_id">Sélectionner un ticket</label>
                    <select class="form-control" id="ticket_id" name="ticket_id" required>
                        @forelse ($openTicketsList as $ticket)
                            <option value="{{ $ticket->id }}">{{ $ticket->titre }}</option>
                        @empty
                            <option disabled>Aucun ticket ouvert disponible</option>
                        @endforelse
                    </select>
                </div>

                <div class="form-group mt-3">
                    <label for="technician_id">Sélectionner un technicien</label>
                    <select class="form-control" id="technician_id" name="technician_id" required>
                        @forelse ($technicians as $technician)
                            <option value="{{ $technician->id }}">{{ $technician->name }}</option>
                        @empty
                            <option disabled>Aucun technicien disponible</option>
                        @endforelse
                    </select>
                </div>

                <button type="submit" class="btn btn-primary mt-4">Attribuer</button>
            </form>
        </div>
    </div>
</div>
@endsection
