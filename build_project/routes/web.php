<?php

use App\Http\Controllers\ConstructionCrewController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
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

Route::get('/dashboard',[ProjectController::class, 'create'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/projects/create', [ProjectController::class, 'create_project'])->name('project.index');
    Route::post('/projects/create', [ProjectController::class, 'add_project'])->name('project.create');
    Route::delete('/projects', [ProjectController::class, 'delete_project'])->name('project.delete');
    Route::get('/projects/current', [ProjectController::class, 'show_project'])->name('project.current');
    Route::get('/projects/edit', [ProjectController::class, 'show_edit_project'])->name('project.edit');
    Route::patch('/projects/edit', [ProjectController::class, 'edit_project'])->name('project.update');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/materials', [MaterialController::class, 'create'])->name('materials.index');
    Route::post('/materials', [MaterialController::class, 'add_material'])->name('materials.add');
    Route::delete('/materials', [MaterialController::class, 'delete_material'])->name('materials.delete');
    Route::patch('/materials', [MaterialController::class, 'update_material'])->name('materials.edit');

    Route::get('/equipments', [EquipmentController::class, 'create'])->name('equipments.index');
    Route::post('/equipments', [EquipmentController::class, 'add_equipment'])->name('equipments.add');
    Route::delete('/equipments', [EquipmentController::class, 'delete_equipment'])->name('equipments.delete');
    Route::patch('/equipments', [EquipmentController::class, 'update_equipment'])->name('equipments.edit');

    Route::get('/constructioncrews', [ConstructionCrewController::class, 'create'])->name('construction_crews.index');
    Route::post('/constructioncrews', [ConstructionCrewController::class, 'add_construction_crew'])->name('construction_crews.add');
    Route::delete('/constructioncrews', [ConstructionCrewController::class, 'delete_construction_crew'])->name('construction_crews.delete');
    Route::patch('/constructioncrews', [ConstructionCrewController::class, 'update_construction_crew'])->name('construction_crews.edit');
});

require __DIR__.'/auth.php';
