<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ConstructionCrewForProject extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'project_id',
        'construction_crew_id',
    ];

    public function take_project(): HasOne
    {
        return $this->hasOne(Project::class, 'id', 'project_id');
    }
    public function take_construction_crew(): HasOne
    {
        return $this->hasOne(ConstructionCrew::class, 'id', 'construction_crew_id');
    }
}
