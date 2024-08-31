<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Answer extends Pivot
{
    use HasFactory;

    protected $fillable = [
        'result',
        'answer',
        'question_id',
        'child_session_id'
    ];

    protected $table = 'answers' ;

    //* Relations */
    //****** belongsTo Relations ******/

    public function question()
    {
        return $this->belongsTo(Question::class);
    }


    public function childSession()
    {
        return $this->belongsTo(ChildSession::class,'child_session_id');
    }

    //****** hasMany Relations ******/

    //****** Many to Many Relations ******/
}
