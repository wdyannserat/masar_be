<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FacilitatorRequest extends FormRequest
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
        if ($this->routeIs('facilitators_store')) {
            return [
                'first_name'                    => 'required|max:255',
                'last_name'                     => 'required|max:255',
                'email'                         => 'required|string|max:255||unique:users,email',
                'address'                       => 'required|string|max:255',
                'phone_number'                  => 'required|string|max:10||unique:users,phone_number',
                'birth_date'                    => 'required|date',
                'volunteering_start_date'       => 'required|date',
                'volunteering_end_date'         => 'nullable|date',
                'gender'                        => 'required|in:male,female',
                'is_active'                     => 'required|boolean',
                'notes'                         => 'nullable|string|max:255',
                'files'                         => 'nullable|array',
                'files.*.file'                  => 'nullable|file',
            ];
        } else if ($this->routeIs('facilitators_update')) {
            return [
                'first_name'                    => 'nullable|max:255',
                'last_name'                     => 'nullable|max:255',
                'email'                         => 'nullable|string|max:255',
                'address'                       => 'nullable|string|max:255',
                'phone_number'                  => 'nullable|string|max:10',
                'birth_date'                    => 'nullable|date',
                'volunteering_start_date'       => 'nullable|date',
                'volunteering_end_date'         => 'nullable|date',
                'gender'                        => 'nullable|in:male,female',
                'notes'                         => 'nullable|string|max:255',
                'is_active'                     => 'nullable|boolean',
            ];
        } else if ($this->route('facilitators_show') || $this->route('facilitators_delete')) {
            return [
                'id'                            => 'required|integer|exists:users,id'
            ];
        } else if ($this->routeIs('facilitator_manage_challenge_request')) {
            return [
                'child_id'                      => 'required|integer|exists:children,id',
                'challenge_id'                  => 'required|integer|exists:challenges,id',
                'status'                        => 'required|in:Accepted,Rejected',
                'description'                   => 'nullable|required_if:status,Rejected'
            ];
        }

        return [];
    }
}
