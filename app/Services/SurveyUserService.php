<?php

namespace App\Services;

use App\Models\SurveyUser;
use Illuminate\Support\Facades\DB;


class SurveyUserService extends BaseService
{
    public function getAll()
    {
        return  SurveyUser::all();
    }


    public function store($validatedData)
    {
        DB::beginTransaction();

        $surveyUser = SurveyUser::create($validatedData);
        DB::commit();
        return $surveyUser;
    }

    public function show($id)
    {
        $surveyUser = $this->find($id);

        return $surveyUser;
    }


    public function update($validatedData, $id)
    {
        DB::beginTransaction();


        $surveyUser = $this->find($id);

        $surveyUser->update($validatedData);

        DB::commit();
        return $surveyUser;
    }


    public function destroy($id)
    {
        $surveyUser = $this->find($id);

        DB::beginTransaction();


        $surveyUser->delete();
        DB::commit();

        return true;
    }

    public function find($id)
    {
        return $this->findByIdOrFail(SurveyUser::class, 'SurveyUser', $id);
    }
}
