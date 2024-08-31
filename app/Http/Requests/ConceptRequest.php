<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConceptRequest extends FormRequest
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
        if ($this->routeIs('concepts_store')) {
            return [
                'name'              => 'required|string|max:255',
                'description'       => 'required|string|max:255',
            ];
        } else if ($this->routeIs('concepts_update')) {
            return [
                'name'              => 'nullable|string|max:255',
                'description'       => 'nullable|string|max:255',
            ];
        } else if ($this->routeIs('concepts_show')) {
            return [
                'id'                => 'required|integer|exists:concepts,id',
            ];
        }
        return [];
    }
}
