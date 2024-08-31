<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    use HasFactory;

    protected $fillable = [
        'age_type_id',
        'url'
    ];
    //* Relations */
    //****** belongsTo Relations ******/

    public function ageType()
    {
        return $this->belongsTo(AgeType::class, 'age_type_id');
    }

    //****** hasMany Relations ******/

    public function surveyUser()
    {
        return $this->hasMany(SurveyUser::class);
    }

    //****** Many to Many Relations ******/


    public function parents()
    {
        return $this->belongsToMany(User::class, 'survey_id', 'parent_id')->using(SurveyUser::class)
            ->withPivot(
                'id',
                'status'
            );
    }
}
