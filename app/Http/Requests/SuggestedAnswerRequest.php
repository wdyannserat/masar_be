<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SuggestedAnswerRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        if ($this->routeIs('suggested_answers_store') || $this->routeIs('questions_store')) {
            return [
                'text'          => 'required|string|max:255',
                'status'        => 'nullable|integer',
                'question_id'   => 'nullable|string|max:255',
            ];
        } else  if ($this->routeIs('suggested_answers_update')) {
            return [
                'status'        => 'nullable|integer',
                'text'          => 'nullable|string|max:255',
                'question_id'   => 'nullable|string|max:255',
            ];
        } else  if ($this->routeIs('suggested_answers_show')) {
            return [
                'id'            => 'required|integer|exists:suggested_answers,id',
            ];
        }

        return [];
    }
}
