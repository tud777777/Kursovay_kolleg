<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    protected $fillable = [
        'name',
        'description',
        'image',
        'end_date',
        'owner_id',
    ];


    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }
    public function create_materials()
    {
        return $this->belongsToMany(Material::class, 'materials_for_project', 'project_id', 'material_id');
    }
    public function create_equipments()
    {
        return $this->belongsToMany(Equipment::class, 'equipments_for_project', 'project_id', 'equipment_id');
    }
    public function create_construction_crews()
    {
        return $this->belongsToMany(Equipment::class, 'construction_crews_for_project', 'project_id', 'construction_crew_id');
    }
}
