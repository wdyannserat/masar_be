<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AgeTypeRequest extends FormRequest
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
        if ($this->routeIs('age_types_store')) {
            return [
                'age_type'              => 'required|string|max:255',
                'ages'                  => 'nullable|array',
                'ages.*'                => 'nullable|integer',
                'min_age'               => 'nullable|integer|min:2|max:50',
                'max_age'               => 'nullable|integer|min:2|max:50',
                'notes'                 => 'nullable|string|max:255'

            ];
        } else if ($this->routeIs('age_types_update')) {
            return [
                'age_type'              => 'nullable|string|max:255',
                'ages'                  => 'nullable|array',
                'ages.*'                => 'nullable|integer',
                'min_age'               => 'nullable|integer|min:2|max:50',
                'max_age'               => 'nullable|integer|min:2|max:50',
                'notes'                 => 'nullable|string|max:255'

            ];
        } else if ($this->routeIs('age_types_show')) {
            return [
                'id'                    => 'required|integer|exists:age_types,id'
            ];
        } else if ($this->routeIs('age_types_delete')) {
            return [
                'id'                    => 'required|integer|exists:age_types,id'
            ];
        }
        return [];
    }
}
