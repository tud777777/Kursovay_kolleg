<?php

namespace App\Http\Controllers;

use App\Models\Material;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class MaterialController extends Controller
{
    public function create(): Response
    {
        $materials = Material::all();
        return Inertia::render('Materials/Materials', ['materials' => $materials]);
    }

    public function add_material(Request $request): Response
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'description' => 'max:255',
        ]);
        Material::query()->create($validated);
        $materials = Material::all();
        return Inertia::render('Materials/Materials', ['materials' => $materials, 'add_success' => true]);
    }

    public function delete_material(Request $request): Response
    {
        $validated = $request->validate([
            'id' => 'required',
        ]);
        Material::query()->where('id', '=', $validated['id'])->delete();
        $materials = Material::all();
        return Inertia::render('Materials/Materials', ['materials' => $materials]);
    }
    public function update_material(Request $request): Response
    {
        $validated = $request->validate([
            'id' => 'required',
            'name' => 'required|max:255',
            'description' => 'max:255',
        ]);
        Material::query()->where('id', '=', $validated['id'])->update($validated);
        $materials = Material::all();
        return Inertia::render('Materials/Materials', ['materials' => $materials]);
    }
}
