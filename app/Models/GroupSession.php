<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class GroupSession extends Pivot
{
    use HasFactory;

    protected $table = 'group_session';

    protected $fillable = [
        'description',
        'program_session_id',
        'group_schedule_id',
        'status'
    ];
    //* Relations */
    //****** belongsTo Relations ******/

    public function groupSchedule()
    {
        return $this->belongsTo(GroupSchedule::class, 'group_schedule_id');
    }

    public function programSession()
    {
        return $this->belongsTo(ProgramSession::class, 'program_session_id');
    }

    //****** hasMany Relations ******/

    //****** Many to Many Relations ******/
}
