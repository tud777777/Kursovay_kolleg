<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class EquipmentForProject extends Model
{
    protected $table = 'equipments_for_project';
    public $timestamps = false;
    protected $fillable = [
        'project_id',
        'equipment_id',
        'count',
    ];

    public function equipment()
    {
        return $this->belongsTo(Equipment::class, 'equipment_id');
    }
}
