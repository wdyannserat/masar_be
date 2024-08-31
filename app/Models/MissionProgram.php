<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class MissionProgram extends Pivot
{
    use HasFactory;

    protected $fillable = [
        'mission_id',
        'program_id'
    ];


    //* Relations */
    //****** belongsTo Relations ******/
    public function mission()
    {
        return $this->belongsTo(Mission::class);
    }

    public function program()
    {
        return $this->belongsTo(Program::class);
    }
    //****** hasMany Relations ******/

    public function childMission()
    {
        return $this->hasMany(ChildMission::class);
    }

    //****** Many to Many Relations ******/

    public function children()
    {
        return $this->belongsToMany(Child::class, 'child_mission', 'mission_program_id', 'child_id', 'id', 'id')
            ->using(ChildMission::class)
            ->withPivot(
                'progress',
                'status',
                'mission_id',
                'child_id'
            );
    }
}