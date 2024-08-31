<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupSchedule extends Model
{
    use HasFactory;

    protected $table = 'group_schedules';

    protected $fillable = [
        'arrival_time',
        'departure_time',
        'day_number',
        'date',
        'group_id'
    ];
    //* Relations */
    //*********************************/
    //****** belongsTo Relations ******/
    public function group()
    {
        return $this->belongsTo(Group::class);
    }


    //****** hasMany Relations ******/

    public function groupSessions()
    {
        return $this->hasMany(GroupSession::class, 'group_schedule_id', 'id');
    }

    public function childSessionChecklists()
    {
        return $this->hasMany(SessionChecklist::class, 'group_schedule_id', 'id');
    }


    //****** Many to Many Relations ******/

    public function programSessions()
    {
        return $this->belongsToMany(ProgramSession::class, 'group_session', 'group_schedule_id', 'program_session_id', 'id', 'id')
            ->using(GroupSession::class)
            ->withPivot(
                'id',
                'description'
            );
    }

    public function childrenCheckList()
    {
        return $this->belongsToMany(Child::class, 'child_session_checklists', 'group_schedule_id', 'child_id')
            ->using(SessionChecklist::class)
            ->withPivot(
                'id',
                'is_checked',
                'description',
                'created_at'
            );
    }
}
