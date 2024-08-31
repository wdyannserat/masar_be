<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuggestedAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
        'question_id',
        'status',
        'text'
    ];

    protected $table = 'suggested_answers';


    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
