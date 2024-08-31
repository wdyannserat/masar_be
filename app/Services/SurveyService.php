<?php

namespace App\Services;

use App\Models\Group;
use App\Models\Survey;
use App\Models\SurveyUser;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
class SurveyService extends BaseService
{
    public function getAll()
    {
        return  Survey::all();
    }


    public function store($validatedData)
    {
        DB::beginTransaction();

        $survey = Survey::create($validatedData);

        $groups = Group::where('age_type_id', $survey->age_type_id)->with('children')->get();

        foreach ($groups as $gr) {
            foreach ($gr->children as $child) {
                SurveyUser::create([
                    'parent_id' => $child->parent_id,
                    'survey_id' => $survey->id
                ]);
            }
        }

        DB::commit();
        return $survey;
    }
    public function getSurveysForParents()
    {
        return Auth::guard('users')->user()->surveys;
    }

    public function show($id)
    {
        $survey = $this->find($id);

        return $survey;
    }


    public function update($validatedData, $id)
    {
        DB::beginTransaction();


        $survey = $this->find($id);

        $survey->update($validatedData);

        DB::commit();
        return $survey;
    }


    public function destroy($id)
    {
        $survey = $this->find($id);

        DB::beginTransaction();


        $survey->delete();
        DB::commit();

        return true;
    }

    public function find($id)
    {
        return $this->findByIdOrFail(Survey::class, 'Survey', $id);
    }
}
