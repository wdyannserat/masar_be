<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;

class QuestionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if ($this->routeIs('questions_store')) {
            return [
                'type'              => 'required|string|in:select_one,text,select_multi',
                'question'          => 'required|string|max:255',
                'correct_answer'    => 'nullable|string|max:255',
                'answers'           => [
                    'required',
                    'array',
                    function ($attribute, $value, $fail) {
                        $answerRequest = new SuggestedAnswerRequest();
                        foreach ($value as $key => $answer) {
                            $validator = Validator::make($answer, collect($answerRequest->rules())->except('question_id')->toArray());
                            if ($validator->fails()) {
                                $fail("Answer $key failed validation: " . implode(', ', $validator->errors()->all()));
                            }
                        }
                    }
                ]
            ];
        } else  if ($this->routeIs('questions_update')) {
            return [
                'type'              => 'nullable|string|in:select_one,text,select_multi',
                'question'          => 'nullable|string|max:255',
                'correct_answer'    => 'nullable|string|max:255',
                'session_id'        => 'nullable|integer|exists:sessions,id'
            ];
        } else  if ($this->routeIs('questions_show')) {
            return [
                'id'                => 'required|integer|exists:questions,id',
            ];
        }
        else if($this->routeIs('child_answer_on_question')){
            return [
                'answer'            => 'required|string|max:255',
            ];
        }

        return [];
    }
}
