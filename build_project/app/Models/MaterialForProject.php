<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class MaterialForProject extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'project_id',
        'material_id',
        'count',
    ];

    public function take_project(): HasOne
    {
        return $this->hasOne(Project::class, 'id', 'project_id');
    }
    public function take_material(): HasOne
    {
        return $this->hasOne(Material::class, 'id', 'material_id');
    }
}
