<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'start_date',
        'end_date',
        'status',
        'notes'
    ];
    //* Relations */
    //****** belongsTo Relations ******/


    //****** hasMany Relations ******/

    public function groups()
    {
        return $this->hasMany(Group::class);
    }

    public function programSession()
    {
        return $this->hasMany(ProgramSession::class);
    }

    public function missionProgram()
    {
        return $this->hasMany(MissionProgram::class);
    }


    //****** Many to Many Relations ******/
    public function sessions()
    {
        return $this->belongsToMany(Session::class)->using(ProgramSession::class)->withPivot(
            'id',
            'session_id',
            'program_id'
        );
    }

    public function missions()
    {
        return $this->belongsToMany(Mission::class)->using(MissionProgram::class);
    }


    //***************************************** */
    public function scopeIsRunning($query)
    {
        return $query->where('status', 'Running');
    }

    public static function getCurrentRunningProgram()
    {
        return Program::isRunning()->first();
    }
}
