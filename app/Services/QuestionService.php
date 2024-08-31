<?php

namespace App\Services;

use App\Models\Answer;
use App\Models\ChildQuestion;
use App\Models\ChildSession;
use App\Models\Question;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class QuestionService extends BaseService
{

    public function getAll($sessionId)
    {
        return  Question::where('session_id', $sessionId)->get();
    }


    public function store($validatedData, $sessionId)
    {
        $suggestedAnswerService =  new SuggestedAnswerService();
        DB::beginTransaction();

        $question = Question::create(
            array_merge(
                collect($validatedData)->except('answers')->toArray(),
                [
                    'session_id' => $sessionId
                ]
            )
        );

        foreach ($validatedData['answers'] as $answer) {
            $suggestedAnswerService->store($question->id,$answer);
        }


        DB::commit();
        return $question;
    }

    public function childAnswerOnQuestion($validatedData, Question $question)
    {
        DB::beginTransaction();
        /**
         * @var Child $child
         */
        $child = Auth::guard('children')->user();
        $session = $question->session;

        $childSession = ChildSession::where([
            'child_id' => $child->id,
            'session_id' => $session->id,
            'status' => 'not_completed'
        ])->first();

        if (!isset($childSession)) {
            throw new Exception(__('messages.ChildDosntHaveThisSession'), 404);
        }

        $validatedData['question_id'] = $question->id;
        $validatedData['child_session_id'] = $childSession->id;

        Answer::create($validatedData);

        DB::commit();
        return true;
    }

    public function show($id)
    {
        $question = $this->find($id);

        return $question->load('suggestedAnswers');
    }


    public function update($validatedData, $id)
    {
        DB::beginTransaction();

        $question = $this->find($id);

        $question->update($validatedData);

        DB::commit();
        return $question;
    }


    public function destroy($id)
    {
        $question = $this->find($id);

        DB::beginTransaction();
        $question->delete();
        DB::commit();

        return true;
    }



    public static function find($id)
    {
        return parent::findByIdOrFail(Question::class, 'Question', $id);
    }
}
