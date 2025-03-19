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
        foreach ($validated['materials'] as $key => $material) {
            if($material['id'] == null){
                $project->create_materials()->attach($material['material_id'], ['count' => $material['count']]);
                unset($validated['materials'][$key]);
            }
            else{
                $material_for_project = MaterialForProject::query()->where('id','=', $material['id'])->first();
                $material_for_project->delete();
                $project->create_materials()->attach($material['material_id'], ['count' => $material['count']]);
            }
        }
        foreach ($validated['equipments'] as $key => $equipment) {
            if($equipment['id'] == null){
                $project->create_equipments()->attach($equipment['equipment_id'], ['count' => $equipment['count']]);
                unset($validated['equipments'][$key]);
            }
            else{
                $equipment_for_project = EquipmentForProject::query()->where('id','=', $equipment['id'])->first();
                $equipment_for_project->delete();
                $project->create_equipments()->attach($equipment['equipment_id'], ['count' => $equipment['count']]);
            }
        }
        foreach ($validated['construction_crews'] as $key => $construction_crew) {
            if($construction_crew['id'] == null){
                $project->create_construction_crews()->attach($construction_crew['construction_crew_id']);
                unset($validated['construction_crews'][$key]);
            }
            else{
                $construction_crew_for_project = ConstructionCrewForProject::query()->where('id','=', $construction_crew['id'])->first();
                $construction_crew_for_project->delete();
                $project->create_construction_crews()->attach($construction_crew['construction_crew_id']);
            }
        }


        $compareById = function ($a, $b) {
            return $a['id'] <=> $b['id'];
        };

        $unique_in_materials1 = array_udiff($validated['materials'], $materials_for_project->toArray(), $compareById);
        $unique_in_materials2 = array_udiff($materials_for_project->toArray(), $validated['materials'], $compareById);
        $unique_materials = array_merge($unique_in_materials1, $unique_in_materials2);

        foreach ($unique_materials as $unique_material) {
            $material = MaterialForProject::query()->where('id','=', $unique_material['id'])->first();
            $material->delete();
        }

        $unique_in_equipments1 = array_udiff($validated['equipments'], $equipments_for_project->toArray(), $compareById);
        $unique_in_equipments2 = array_udiff($equipments_for_project->toArray(), $validated['equipments'], $compareById);
        $unique_equipments = array_merge($unique_in_equipments1, $unique_in_equipments2);

        foreach ($unique_equipments as $unique_equipment) {
            $equipment = EquipmentForProject::query()->where('id','=', $unique_equipment['id'])->first();
            $equipment->delete();
        }

        $unique_in_construction_crews1 = array_udiff($validated['construction_crews'], $construction_crews_for_project->toArray(), $compareById);
        $unique_in_construction_crews2 = array_udiff($construction_crews_for_project->toArray(), $validated['construction_crews'], $compareById);
        $unique_construction_crews = array_merge($unique_in_construction_crews1, $unique_in_construction_crews2);

        foreach ($unique_construction_crews as $unique_construction_crew) {
            $construction_crew = ConstructionCrewForProject::query()->where('id','=', $unique_construction_crew['id'])->first();
            $construction_crew->delete();
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
