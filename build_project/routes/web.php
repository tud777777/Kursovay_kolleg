<?php

use App\Http\Controllers\MaterialController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    $user = auth()->user();
    if ($user){
        return redirect(route('dashboard', absolute: false));
    }
    return Inertia::render('Welcome', [
        'canLogin' => true,
        'canRegister' => true,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard', [
        'canLogin' => false,
        'canRegister' => false,
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/materials', [MaterialController::class, 'create'])->name('materials.index');
});

require __DIR__.'/auth.php';
