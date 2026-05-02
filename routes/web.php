<?php

use App\Http\Controllers\{URLController, ProfileController, InvitationController};
use Illuminate\Support\Facades\Route;

Route::get('/', [URLController::class, 'index'])->name('url.index');

Route::get('/s/{shortCode}', [URLController::class, 'redirect'])->name('url.redirect');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/urls/create', [URLController::class, 'create'])->name('url.create');
    Route::post('/urls', [URLController::class, 'store'])->name('url.store');

    Route::get('/invitations/create', [InvitationController::class, 'create'])->name('invitation.create');
    Route::post('/invitations', [InvitationController::class, 'store'])->name('invitation.store');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});

require __DIR__.'/auth.php';
