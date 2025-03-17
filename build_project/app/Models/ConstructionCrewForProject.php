<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ConstructionCrewForProject extends Model
{
    protected $table = 'construction_crews_for_project';
    public $timestamps = false;
    protected $fillable = [
        'project_id',
        'construction_crew_id',
    ];

    public function construction_crew()
    {
        return $this->belongsTo(ConstructionCrew::class, 'construction_crew_id');
    }
}
