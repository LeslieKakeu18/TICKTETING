<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    // Afficher le formulaire de connexion
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Connexion de l'utilisateur
    public function login(Request $request)
    {
        // Valider les données
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        // Tentative de connexion
        if (Auth::attempt($validated)) {
            $request->session()->regenerate();
            $user = Auth::user();

            Log::info('Connexion réussie', ['user_id' => $user->id, 'role' => $user->role]);

            return $this->redirectToDashboard($user->role);
        }

        return back()->withErrors(['email' => 'Identifiants incorrects.'])->withInput();
    }

    // Afficher le formulaire d'inscription
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // Traiter l'inscription
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'role' => 'required|in:Admin,Technicien,Employé',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
        ]);

        Auth::login($user); // Connecte automatiquement l'utilisateur

        return $this->redirectToDashboard($user->role);
    }

    // Déconnexion de l'utilisateur
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Déconnexion réussie.');
    }

    // Redirection selon le rôle
    private function redirectToDashboard($role)
{
    return match ($role) {
        'Admin' => redirect()->route('dashboard.admin'),
        'Technicien' => redirect()->route('dashboard.technician'),
        'Employé' => redirect()->route('dashboard.user'),
        default => redirect()->route('login')->withErrors(['error' => 'Rôle utilisateur non reconnu.']),
    };
}

}
