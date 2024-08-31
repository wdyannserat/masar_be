<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\Console\Completion\Suggestion;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'question',
        'description',
        'correct_answer',
        'session_id'
    ];

    //* Relations */
    //****** belongsTo Relations ******/

    public function session()
    {
        return $this->belongsTo(Session::class);
    }

    //****** hasMany Relations ******/

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function suggestedAnswers()
    {
        return $this->hasMany(SuggestedAnswer::class);
    }
}
