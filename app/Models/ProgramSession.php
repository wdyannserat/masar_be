<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ProgramSession extends Pivot
{
    use HasFactory;

    protected $fillable = [
        'session_id',
        'program_id'
    ];

    //* Relations */
    //****** belongsTo Relations ******/
    public function session()
    {
        return $this->belongsTo(Session::class);
    }

    public function program()
    {
        return $this->belongsTo(Program::class);
    }
    //****** hasMany Relations ******/

    public function groupSessions()
    {
        return $this->hasMany(GroupSession::class, 'program_session_id', 'id');
    }


    //****** Many to Many Relations ******/

    public function groupSchedules()
    {
        return $this->belongsToMany(GroupSchedule::class, 'group_session', 'program_session_id', 'group_schedule_id', 'id', 'id')
            ->using(GroupSession::class)
            ->withPivot(
                'description',
            );
    }

    public function evaluatedChildren()
    {
        return $this->belongsToMany(Child::class, 'session_rates', 'program_session_id', 'child_id','id', 'id')->withPivot(
            'rate',
            'child_id',
            'program_session_id'
        );
    }

    //*Helper functions
    public static function getCurrentProgramSession($sessionId)
    {
        $program = Program::isRunning()->first();

        $programSession = ProgramSession::where([
            'program_id' => $program->id,
            'session_id' => $sessionId
        ])->first();

        return $programSession;
    }
}
