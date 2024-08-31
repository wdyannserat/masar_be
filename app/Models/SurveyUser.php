<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class SurveyUser extends Pivot
{
    use HasFactory;

    protected $fillable = [
        'parent_id',
        'survey_id',
        'status'
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'parent_id');
    }

    public function survey()
    {
        return $this->belongsTo(Survey::class);
    }
}
