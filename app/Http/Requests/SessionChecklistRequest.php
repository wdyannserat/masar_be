<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SessionChecklistRequest extends FormRequest
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
        if ($this->routeIs('session_checklist_store')) {
            return [
                'group_schedule_id'                 => 'required|integer|exists:group_schedules,id',
                'children'                          => 'required|array',
                'children.*.id'                     => 'required|integer|exists:children,id',
                'children.*.attendance'             => 'required|boolean',
                'children.*.description'            => 'nullable|string|max:255',
            ];
        }

        return [];
    }
}
