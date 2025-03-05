<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Models\Material;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class EquipmentController extends Controller
{
    public function create(): Response
    {
        $equipments = Equipment::all();
        return Inertia::render('Equipments/Equipments', ['equipments' => $equipments]);
    }

    public function add_equipment(Request $request): Response
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'description' => 'max:255',
        ]);
        Equipment::query()->create($validated);
        $equipments = Equipment::all();
        return Inertia::render('Equipments/Equipments', ['equipments' => $equipments, 'add_success' => true]);
    }

    public function delete_equipment(Request $request): Response
    {
        $validated = $request->validate([
            'id' => 'required',
        ]);
        Equipment::query()->where('id', '=', $validated['id'])->delete();
        $equipments = Equipment::all();
        return Inertia::render('Equipments/Equipments', ['equipments' => $equipments]);
    }
    public function update_equipment(Request $request): Response
    {
        $validated = $request->validate([
            'id' => 'required',
            'name' => 'required|max:255',
            'description' => 'max:255',
        ]);
        Equipment::query()->where('id', '=', $validated['id'])->update($validated);
        $equipments = Equipment::all();
        return Inertia::render('Equipments/Equipments', ['equipments' => $equipments]);
    }
}
