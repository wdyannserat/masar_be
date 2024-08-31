<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AnswerRequest extends FormRequest
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
        if ($this->routeIs('answers_store') || $this->routeIs('questions_store')) {
            return [
                'order'         => 'required|integer',
                'answer'        => 'required|string|max:255',
                'question_id'   => 'nullable|string|max:255',
            ];
        } else  if ($this->routeIs('child_answer_question')) {
            return [
                'child_answer'      => 'required|string|max:500'
            ];
        } else  if ($this->routeIs('answers_update')) {
            return [
                'order'         => 'nullable|integer',
                'answer'        => 'nullable|string|max:255',
                'question_id'   => 'nullable|string|max:255',
            ];
        } else  if ($this->routeIs('answers_show')) {
            return [
                'id'            => 'required|integer|exists:answers,id',
            ];
        }

        return [];
    }
}
