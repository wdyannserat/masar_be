<?php

namespace App\Http\Requests;

use App\Rules\ChildNotExistInGroup;
use App\Rules\FacilitatorExistsRule;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class GroupRequest extends FormRequest
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
        if ($this->routeIs('groups_store')) {
            return [
                'name'                      => 'required|string|max:255',
                'children_count'            => 'required|integer|min:4',
                'age_type_id'               => 'required|integer|exists:age_types,id',
                'program_id'                => 'required|integer|exists:programs,id',
                'notes'                     => 'nullable|string|max:255'
            ];
        } else if ($this->routeIs('groups_update')) {
            return [
                'name'                      => 'nullable|string|max:255',
                'children_count'            => 'nullable|integer|min:4|max:1000',
                'age_type_id'               => 'nullable|integer|exists:age_types,id',
                'program_id'                => 'nullable|integer|exists:programs,id',
                'notes'                     => 'nullable|string|max:255'
            ];
        } else if ($this->routeIs('groups_assign_facilitators')) {
            return [
                'facilitatorsIds'           => 'required|array',
                'facilitatorsIds.*'         => [
                    'required',
                    'integer',
                    new FacilitatorExistsRule
                ]
            ];
        } else if ($this->routeIs('groups_assign_children')) {
            return [
                'children'                  => 'required|array',
                'children.*.id'             => ['required','integer','exists:children,id',new ChildNotExistInGroup],
                'children.*.description'    => 'nullable|string|max:255',
                'children.*.status'         => 'required|string|in:Active,InActive',
            ];
        }
    }
}
