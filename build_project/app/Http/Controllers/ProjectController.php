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
        Project::query()->where('id','=', $validated['projectId'])->update(['name' => $validated['name'], 'description' => $validated['description'],'end_date' => $validated['end_date']]);
        $project = Project::query()->where('id','=', $validated['projectId'])->first();
        $materials_for_project = MaterialForProject::query()->where('project_id','=', $validated['projectId'])->get();
        $equipments_for_project = EquipmentForProject::query()->where('project_id','=', $validated['projectId'])->get();
        $construction_crews_for_project = ConstructionCrewForProject::query()->where('project_id','=', $validated['projectId'])->get();
        $materials_unique = [];
        $diff1 = array_diff($validated['materials'], $materials_for_project);
        $diff2 = array_diff($materials_for_project, $validated['materials']);
        $materials_unique = array_merge($diff1, $diff2);
        foreach ($materials_unique as $material_unique) {
            $material = MaterialForProject::query()->where('id','=', $material_unique->id)->first();
            if(empty($material)){
                $project->create_materials()->attach($material_unique['id'], ['count' => $material_unique['count']]);
            }
            else{
                $material->delete();
            }
        }
        $equipments_unique = array_unique($validated['equipments'], $equipments_for_project);
        foreach ($equipments_unique as $equipment_unique) {
            $equipment = MaterialForProject::query()->where('id','=', $equipment_unique->id)->first();
            if(empty($equipment)){
                $project->create_equipments()->attach($equipment_unique['id'], ['count' => $equipment_unique['count']]);
            }
            else{
                $equipment->delete();
            }
        }
        $construction_crews_unique = array_unique($validated['construction_crews'], $construction_crews_for_project);
        foreach ($construction_crews_unique as $construction_crew_unique) {
            $construction_crew = MaterialForProject::query()->where('id','=', $construction_crew_unique->id)->first();
            if(empty($construction_crew)){
                $project->create_equipments()->attach($construction_crew_unique['id'], ['count' => $construction_crew_unique['count']]);
            }
            else{
                $construction_crew->delete();
            }
        }
        $project = Project::with('owner')->where('id','=', $validated['projectId'])->first();
        $materials = MaterialForProject::with('material')->where('project_id','=', $validated['projectId'])->get();
        $equipments = EquipmentForProject::with('equipment')->where('project_id','=', $validated['projectId'])->get();
        $construction_crews = ConstructionCrewForProject::with('construction_crew')->where('project_id','=', $validated['projectId'])->get();
        return Inertia::render('Projects/ShowProject', ['project' => $project, 'equipments' => $equipments, 'construction_crews' => $construction_crews, 'materials' => $materials]);
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
