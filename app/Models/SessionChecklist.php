<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class SessionChecklist extends Pivot
{
    use HasFactory;

    protected $table = 'session_checklists';

    protected $fillable = [
        'attendance',
        'description',
        'child_id',
        'group_schedule_id'
    ];
    ///* Relations *//

    ///****** belongsTo Relations ******/

    public function groupSchedule()
    {
        return $this->belongsTo(GroupSchedule::class, 'group_schedule_id');
    }

    public function child()
    {
        return $this->belongsTo(Child::class, 'child_id');
    }

    ///****** hasMany Relations ******/

    ///****** Many to Many Relations ******/
}
