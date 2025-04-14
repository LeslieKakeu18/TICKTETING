<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Afficher la liste des utilisateurs
    public function index()
    {
        if (Auth::user()->role !== 'Admin') {
            return redirect()->route('dashboard')->with('error', 'Accès réservé à l\'administrateur.');
        }

        $users = User::paginate(10);
        return view('users.index', compact('users'));
    }

    // Afficher le formulaire de création
    public function create()
    {
        if (Auth::user()->role !== 'Admin') {
            return redirect()->route('dashboard')->with('error', 'Accès réservé à l\'administrateur.');
        }

        return view('users.create');
    }

    // Enregistrer un nouvel utilisateur
    public function store(Request $request)
    {
        if (Auth::user()->role !== 'Admin') {
            return redirect()->route('dashboard')->with('error', 'Accès réservé à l\'administrateur.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:Employé,Technicien,Admin',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
        ]);

        return redirect()->route('users.index')->with('success', 'Utilisateur créé avec succès.');
    }

    // Afficher le formulaire d'édition
    public function edit($id)
    {
        if (Auth::user()->role !== 'Admin') {
            return redirect()->route('dashboard')->with('error', 'Accès réservé à l\'administrateur.');
        }

        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }

    // Mettre à jour un utilisateur
    public function update(Request $request, $id)
    {
        if (Auth::user()->role !== 'Admin') {
            return redirect()->route('dashboard')->with('error', 'Accès réservé à l\'administrateur.');
        }

        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:Employé,Technicien,Admin',
        ]);

        if ($request->filled('password')) {
            $request->validate([
                'password' => 'required|string|min:8|confirmed',
            ]);
            $user->password = Hash::make($request->password);
        }

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->role = $validated['role'];
        $user->save();

        return redirect()->route('users.index')->with('success', 'Utilisateur mis à jour avec succès.');
    }

    // Supprimer un utilisateur
    public function destroy($id)
    {
        if (Auth::user()->role !== 'Admin') {
            return redirect()->route('dashboard')->with('error', 'Accès réservé à l\'administrateur.');
        }

        $user = User::findOrFail($id);

        if ($user->role === 'Admin' || Auth::id() === $user->id) {
            return redirect()->route('users.index')->with('error', 'Suppression non autorisée.');
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'Utilisateur supprimé.');
    }
}
