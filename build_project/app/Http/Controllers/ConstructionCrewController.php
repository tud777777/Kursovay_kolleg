<?php

namespace App\Http\Controllers;


use App\Models\ConstructionCrew;
use App\Models\Equipment;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ConstructionCrewController extends Controller
{
    public function create(): Response
    {
        $construction_crews = ConstructionCrew::all();
        return Inertia::render('ConstructionCrews/ConstructionCrews', ['construction_crews' => $construction_crews]);
    }
    public function add_construction_crew(Request $request): Response
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'description' => 'max:255',
        ]);
        ConstructionCrew::query()->create($validated);
        $construction_crews = ConstructionCrew::all();
        return Inertia::render('ConstructionCrews/ConstructionCrews', ['construction_crews' => $construction_crews, 'add_success' => true]);
    }

    public function delete_construction_crew(Request $request): Response
    {
        $validated = $request->validate([
            'id' => 'required',
        ]);
        ConstructionCrew::query()->where('id', '=', $validated['id'])->delete();
        $construction_crews = ConstructionCrew::all();
        return Inertia::render('ConstructionCrews/ConstructionCrews', ['construction_crews' => $construction_crews]);
    }
    public function update_construction_crew(Request $request): Response
    {
        $validated = $request->validate([
            'id' => 'required',
            'name' => 'required|max:255',
            'description' => 'max:255',
        ]);
        ConstructionCrew::query()->where('id', '=', $validated['id'])->update($validated);
        $construction_crews = ConstructionCrew::all();
        return Inertia::render('ConstructionCrews/ConstructionCrews', ['construction_crews' => $construction_crews]);
    }
}
