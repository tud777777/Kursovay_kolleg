<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    protected $fillable = [
        'name',
        'description',
        'address',
        'end_date',
        'owner_id',
    ];

    public function take_materials(): HasMany
    {
        return $this->hasMany(MaterialForProject::class, 'project_id', 'id');
    }
    public function take_equipments(): HasMany
    {
        return $this->hasMany(EquipmentForProject::class, 'project_id', 'id');
    }
    public function take_construction_crews(): HasMany
    {
        return $this->hasMany(ConstructionCrewForProject::class, 'project_id', 'id');
    }
}
