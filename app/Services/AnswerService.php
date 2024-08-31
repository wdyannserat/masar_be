<?php

namespace App\Services;

use App\Models\Answer;
use App\Models\ChildQuestion;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class AnswerService extends BaseService
{
    public function getAll()
    {
        return  Answer::all();
    }


    public function store($validatedData)
    {
        DB::beginTransaction();

        $answer = Answer::create($validatedData);
        DB::commit();
        return $answer;
    }

    public function show($id)
    {
        $answer = $this->find($id);

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

    public function answerQuestion($validatedData, $questionId)
    {
        QuestionService::find($questionId);

        DB::beginTransaction();
        // ChildQuestion::create([
        //     'child_id'      => Auth::guard('children')->id(),
        //     'question_id'   => $questionId,
        //     'answer'        => $validatedData['child_answer']
        // ]);
        DB::commit();
        return true;
    }

    public function getChildAnswer($questionId, $childId)
    {
        // $question = QuestionService::find($questionId);
        // $child = ChildService::find($childId);

        // $answers = ChildQuestion::where([
        //     'child_id' =>  $child->id,
        //     'question_id' => $question->id
        // ])->get();

        // return $answers;
    }

    public static function find($id)
    {
        return parent::findByIdOrFail(Answer::class, 'Answer', $id);
    }
}
