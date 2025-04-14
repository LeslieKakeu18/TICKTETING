<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CommentController;

/*
|--------------------------------------------------------------------------
| Routes publiques (auth & welcome)
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    if (auth()->check()) {
        $user = auth()->user();

        return match ($user->role) {
            'admin' => redirect()->route('dashboard.admin'),
            'technician' => redirect()->route('dashboard.technician'),
            'Employé' => redirect()->route('dashboard.user'),
            default => redirect()->route('login')->with('error', 'Rôle utilisateur non reconnu.'),
        };
    }

    return view('welcome');
});

// Auth classique
Route::prefix('auth')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});


/*
|--------------------------------------------------------------------------
| Routes protégées par l'authentification Laravel (session)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/admin', [DashboardController::class, 'adminDashboard'])->name('dashboard.admin');
    Route::get('/dashboard/technician', [DashboardController::class, 'technicianDashboard'])->name('dashboard.technician');
    Route::get('/dashboard/user', [DashboardController::class, 'userDashboard'])->name('dashboard.user');
    Route::resource('tickets', TicketController::class);
    Route::put('tickets/{id}/close', [TicketController::class, 'close'])->name('tickets.close');
    Route::resource('users', UserController::class);
    Route::post('tickets/{ticket}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::post('/tickets/assign-technician', [TicketController::class, 'assignTechnician'])->name('tickets.assignTechnician');

});

