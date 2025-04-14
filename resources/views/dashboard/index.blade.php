@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4 text-center">📊 Tableau de bord général</h1>

    <div class="row g-4">
        <!-- Tickets Ouverts -->
        <div class="col-md-6 col-lg-3">
            <div class="card text-white bg-primary shadow rounded">
                <div class="card-body text-center">
                    <h5 class="card-title">
                        <i class="fas fa-ticket-alt fa-lg"></i><br>
                        Tickets Ouverts
                    </h5>
                    <p class="display-5 mt-2">{{ number_format($openTickets) }}</p>
                </div>
            </div>
        </div>

        <!-- Tickets Résolus -->
        <div class="col-md-6 col-lg-3">
            <div class="card text-white bg-success shadow rounded">
                <div class="card-body text-center">
                    <h5 class="card-title">
                        <i class="fas fa-check-circle fa-lg"></i><br>
                        Tickets Résolus
                    </h5>
                    <p class="display-5 mt-2">{{ number_format($resolvedTickets) }}</p>
                </div>
            </div>
        </div>

        <!-- Tickets Critiques -->
        <div class="col-md-6 col-lg-3">
            <div class="card text-white bg-danger shadow rounded">
                <div class="card-body text-center">
                    <h5 class="card-title">
                        <i class="fas fa-exclamation-circle fa-lg"></i><br>
                        Tickets Critiques
                    </h5>
                    <p class="display-5 mt-2">{{ number_format($criticalTickets) }}</p>
                </div>
            </div>
        </div>

        <!-- Temps Moyen de Résolution -->
        <div class="col-md-6 col-lg-3">
            <div class="card text-white bg-dark shadow rounded">
                <div class="card-body text-center">
                    <h5 class="card-title">
                        <i class="fas fa-clock fa-lg"></i><br>
                        Temps moyen de résolution
                    </h5>
                    <p class="display-5 mt-2">
                        @if($averageResolutionTime)
                            {{ number_format($averageResolutionTime, 1) }} jours
                        @else
                            N/A
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
