@extends('layouts.app')

@section('content')
<div class="container mt-5 text-center">
    <h1 class="mb-4">🎟️ Bienvenue sur la plateforme de gestion des tickets</h1>
    <p class="lead mb-5">Gérez facilement vos demandes techniques, suivez leur avancement et restez informé.</p>

    @if (Auth::check())
        <!-- Utilisateur connecté -->
        <div class="d-grid gap-3 d-sm-flex justify-content-center">
            <a href="{{ route('dashboard.index') }}" class="btn btn-primary btn-lg">
                <i class="fas fa-tachometer-alt me-1"></i> Accéder au tableau de bord
            </a>
            <a href="{{ route('tickets.index') }}" class="btn btn-outline-secondary btn-lg">
                <i class="fas fa-ticket-alt me-1"></i> Voir les tickets
            </a>
        </div>
    @else
        <!-- Invité -->
        <div class="d-grid gap-3 d-sm-flex justify-content-center">
            <a href="{{ route('login') }}" class="btn btn-primary btn-lg">
                <i class="fas fa-sign-in-alt me-1"></i> Se connecter
            </a>
            <a href="{{ route('register') }}" class="btn btn-outline-secondary btn-lg">
                <i class="fas fa-user-plus me-1"></i> S'inscrire
            </a>
        </div>
    @endif
</div>
@endsection
