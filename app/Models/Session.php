<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category',
        'notes'
    ];
    //* Relations */
    //****** belongsTo Relations ******/


    //****** hasMany Relations ******/

    public function concepts()
    {
        return $this->hasMany(Concept::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function programSession()
    {
        return $this->hasMany(ProgramSession::class);
    }

    public function groupSessions()
    {
        return $this->hasManyThrough(GroupSession::class, ProgramSession::class, 'session_id', 'program_session_id', 'id', 'id');
    }


    //****** Many to Many Relations ******/

    public function children()
    {
        return $this->belongsToMany(Child::class)->using(ChildSession::class)->withPivot(
            'id',
            'status',
            'description',
            'created_at'
        );
    }


    public function programs()
    {
        return $this->belongsToMany(Program::class)->using(ProgramSession::class)->withPivot(
            'id',
            'session_id',
            'program_id'
        );
    }
}
