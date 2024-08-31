<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ChildSession extends Pivot
{
    use HasFactory;

    protected $fillable = [
        'child_id',
        'session_id',
        'status',
        'description'
    ];

    protected $table = 'child_session';


    public function session()
    {
        return $this->belongsTo(Session::class);
    }


    public function child()
    {
        return $this->belongsTo(Child::class);
    }



    public function answer()
    {
        return $this->hasMany(Answer::class, 'child_session_id');
    }


    public function questions()
    {
        return $this->belongsToMany(Question::class, 'child_session_id', 'question_id')
            ->using(Answer::class)
            ->withPivot(
                'answer',
                'result'
            );
    }
}
