<?php

namespace App\Services;

use App\Models\Answer;
use App\Models\ChildQuestion;
use App\Models\SuggestedAnswer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class SuggestedAnswerService extends BaseService
{
    public function getAll($questionId)
    {
        return  SuggestedAnswer::where([
            'question_id' => $questionId,
        ])->get();
    }


    public function store($questionId, $validatedData)
    {
        DB::beginTransaction();
        $validatedData['question_id'] = $questionId;
        $answer = SuggestedAnswer::create($validatedData);
        DB::commit();
        return $answer;
    }


    public function update($validatedData, $id)
    {
        DB::beginTransaction();

        $answer = $this->find($id);

        $answer->update($validatedData);

        DB::commit();
        return $answer;
    }


    public function destroy($id)
    {
        $answer = $this->find($id);

        DB::beginTransaction();


        $answer->delete();
        DB::commit();

        return true;
    }


    public static function find($id)
    {
        return parent::findByIdOrFail(SuggestedAnswer::class, 'SuggestedAnswer', $id);
    }
}
