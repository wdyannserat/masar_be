<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ChildMission extends Pivot
{
    use HasFactory;

    protected $fillable = [
        'progress',
        'status',
        'mission_program_id',
        'child_id'
    ];
    //* Relations */
    //****** belongsTo Relations ******/


    public function missionProgram()
    {
        return $this->belongsTo(MissionProgram::class);
    }

    public function child()
    {
        return $this->belongsTo(Child::class);
    }

    //****** hasMany Relations ******/

    //****** Many to Many Relations ******/
}
