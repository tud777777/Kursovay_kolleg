<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class MaterialForProject extends Model
{
    protected $table = 'materials_for_project';
    public $timestamps = false;
    protected $fillable = [
        'project_id',
        'material_id',
        'count',
    ];
    public function material()
    {
        return $this->belongsTo(Material::class, 'material_id');
    }
}
