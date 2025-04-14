@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm rounded">
                <div class="card-header text-center font-weight-bold">
                    {{ __('Inscription') }}
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}" novalidate>
                        @csrf

                        <!-- Nom -->
                        <div class="form-group">
                            <label for="name">{{ __('Nom complet') }}</label>
                            <input id="name" type="text"
                                   class="form-control @error('name') is-invalid @enderror"
                                   name="name" value="{{ old('name') }}" required autofocus>

                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="form-group">
                            <label for="email">{{ __('Adresse e-mail') }}</label>
                            <input id="email" type="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   name="email" value="{{ old('email') }}" required>

                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Mot de passe -->
                        <div class="form-group">
                            <label for="password">{{ __('Mot de passe') }}</label>
                            <input id="password" type="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   name="password" required>

                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Confirmation mot de passe -->
                        <div class="form-group">
                            <label for="password_confirmation">{{ __('Confirmer le mot de passe') }}</label>
                            <input id="password_confirmation" type="password"
                                   class="form-control"
                                   name="password_confirmation" required>
                        </div>

                        <!-- Rôle -->
                        <div class="form-group">
                            <label for="role">{{ __('Rôle') }}</label>
                            <select id="role" name="role"
                            class="form-control @error('role') is-invalid @enderror"
                            required>
                                <option value="Admin">Administrateur</option>
                                <option value="Technicien">Technicien</option>
                                <option value="Employé">Employé</option>
                            </select>
                    

                            @error('role')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Soumettre -->
                        <div class="form-group d-flex justify-content-center mt-4">
                            <button type="submit" class="btn btn-primary">
                                {{ __('S\'inscrire') }}
                            </button>
                        </div>
                    </form>

                    <!-- Lien vers connexion -->
                    <div class="mt-4 text-center">
                        <p class="mb-0">
                            {{ __('Déjà un compte ?') }}
                            <a href="{{ route('login') }}">{{ __('Se connecter') }}</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
