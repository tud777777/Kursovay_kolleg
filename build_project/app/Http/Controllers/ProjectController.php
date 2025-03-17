<?php

namespace App\Http\Controllers;

use App\Models\ConstructionCrew;
use App\Models\ConstructionCrewForProject;
use App\Models\Equipment;
use App\Models\EquipmentForProject;
use App\Models\Material;
use App\Models\MaterialForProject;
use App\Models\Project;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ProjectController extends Controller
{
    public function create(){
        $projects = Project::with('owner')->get();
        return Inertia::render('Projects/Dashboard', ['projects' => $projects]);
    }
    public function create_project(): Response
    {
        $materials = Material::all();
        $equipments = Equipment::all();
        $construction_crews = ConstructionCrew::all();
        return Inertia::render('Projects/CreateProject', [
            'materials' => $materials,
            'equipments' => $equipments,
            'construction_crews' => $construction_crews
        ]);
    }

    public function add_project(Request $request){
        $validated = $request->validate([
            'materials' => '',
            'equipments' => '',
            'construction_crews' => '',
            'name' => 'required|max:255',
            'description' => 'required|max:255',
            'end_date' => 'required|date',
        ]);
        $user = auth()->user();
        $project = $user->project_cr()->create(['name' => $validated['name'], 'description' => $validated['description'], 'end_date' => $validated['end_date']]);
        foreach ($validated['materials'] as $material) {
            $project->create_materials()->attach($material['id'], ['count' => $material['count']]);
        }
        foreach ($validated['equipments'] as $equipment) {
            $project->create_equipments()->attach($equipment['id'], ['count' => $equipment['count']]);
        }
        foreach ($validated['construction_crews'] as $construction_crew) {
            $project->create_construction_crews()->attach($construction_crew['id']);
        }
        $projects = Project::with('owner')->get();
        return Inertia::render('Projects/Dashboard', ['projects' => $projects]);
    }

    public function delete_project(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required',
        ]);
        $project = Project::query()->where('id','=', $validated['id'])->first();
        $project->delete();
        $projects = Project::with('owner')->get();
        return Inertia::render('Projects/Dashboard', ['projects' => $projects]);
    }
    public function show_edit_project(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required',
        ]);
        $project = Project::query()->where('id','=', $validated['id'])->first();
        $materials_for_project = MaterialForProject::query()->where('project_id','=', $validated['id'])->get();
        $equipments_for_project = EquipmentForProject::query()->where('project_id','=', $validated['id'])->get();
        $construction_crews_for_project = ConstructionCrewForProject::query()->where('project_id','=', $validated['id'])->get();
        $materials = Material::all();
        $equipments = Equipment::all();
        $construction_crews = ConstructionCrew::all();
        return Inertia::render('Projects/EditProject', [
            'project' => $project,
            'materials_for_project' => $materials_for_project,
            'equipments_for_project' => $equipments_for_project,
            'construction_crews_for_project' => $construction_crews_for_project,
            'equipments' => $equipments,
            'construction_crews' => $construction_crews,
            'materials' => $materials
        ]);
    }
    public function edit_project(Request $request)
    {
        $validated = $request->validate([
            'projectId' => 'required',
            'materials' => '',
            'equipments' => '',
            'construction_crews' => '',
            'name' => 'required|max:255',
            'description' => 'required|max:255',
            'end_date' => 'required|date',
        ]);
        Project::query()->where('id','=', $validated['projectId'])->update([$validated['name'], $validated['description'], $validated['end_date']]);
        $project = Project::query()->where('id','=', $validated['projectId'])->first();
        $materials_for_project = MaterialForProject::query()->where('project_id','=', $validated['id'])->get();
        $equipments_for_project = EquipmentForProject::query()->where('project_id','=', $validated['id'])->get();
        $construction_crews_for_project = ConstructionCrewForProject::query()->where('project_id','=', $validated['id'])->get();
        foreach ($materials_for_project as $material_for_project) {
            foreach ($validated['materials'] as $material) {
                if ($material['id'] != $material_for_project['id']) {
                    $project->create_materials()->attach($material['id'], ['count' => $material['count']]);
                }
            }

        }
    }
    public function show_project(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required',
        ]);
        $project = Project::with('owner')->where('id','=', $validated['id'])->first();
        $materials = MaterialForProject::with('material')->where('project_id','=', $validated['id'])->get();
        $equipments = EquipmentForProject::with('equipment')->where('project_id','=', $validated['id'])->get();
        $construction_crews = ConstructionCrewForProject::with('construction_crew')->where('project_id','=', $validated['id'])->get();
        return Inertia::render('Projects/ShowProject', ['project' => $project, 'equipments' => $equipments, 'construction_crews' => $construction_crews, 'materials' => $materials]);
    }
}
