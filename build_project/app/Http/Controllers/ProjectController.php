<?php

namespace App\Http\Controllers;

use App\Models\ConstructionCrew;
use App\Models\Equipment;
use App\Models\Material;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ProjectController extends Controller
{
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
}
