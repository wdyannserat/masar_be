<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChildRequest extends FormRequest
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
        if ($this->routeIs('children_store')) {
            return [
                'first_name'                    => 'required|max:255',
                'last_name'                     => 'required|max:255',
                'gender'                        => 'required|in:female,male',
                'school_name'                   => 'required|string|max:255',
                'address'                       => 'required|string|max:255',
                'parent_full_name'              => 'required|string|max:255',
                'parent_phone_number'           => 'required|string|max:10|unique:users,phone_number',
                'parent_email'                  => 'nullable|string|email|unique:users,email,except,id',
                'birth_date'                    => 'required|date',
                'notes'                         => 'nullable|string|max:500',
                'files'                         => 'nullable|array',
                'files.*.file'                  => 'nullable|file',
                'files.*.description'           => 'nullable|string|max:255',
                'position_id'                   => 'nullable|integer|exists:positions,id',
                'trip_id'                       => 'nullable|integer|exists:trips,id',
            ];
        } else if ($this->routeIs('children_update')) {
            return [
                'first_name'                    => 'nullable|max:255',
                'last_name'                     => 'nullable|max:255',
                'gender'                        => 'nullable|in:female,male',
                'school_name'                   => 'nullable|string|max:255',
                'address'                       => 'nullable|string|max:255',
                'parent_full_name'              => 'nullable|string|max:255',
                'parent_phone_number'           => 'nullable|string|max:10|unique:users,phone_number,except,id',
                'parent_email'                  => 'nullable|string|email|unique:users,email,except,id',
                'birth_date'                    => 'nullable|date',
                'notes'                         => 'nullable|string|max:500',
                'files'                         => 'nullable|array',
                'files.*.file'                  => 'nullable|file',
                'files.*.description'           => 'nullable|string|max:255',
                'position_id'                   => 'nullable|integer|exists:positions,id',
                'trip_id'                       => 'nullable|integer|exists:trips,id',
            ];
        } else if ($this->routeIs('children_show') || $this->routeIs('children_delete') || $this->routeIs('child_sessions_missions_badges')) {
            return [
                'id'                            => 'required|integer|exists:children,id'
            ];
        }
    }
}
