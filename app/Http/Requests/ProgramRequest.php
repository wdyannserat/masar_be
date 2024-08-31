<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ProgramRequest extends FormRequest
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
        if ($this->routeIs('programs_store')) {
            $keys = [
                'name'                  => 'required|string',
                'address'               => 'required|string',
                'start_date'            => 'required|date',
                'end_date'              => 'required|date',
                'notes'                 => 'nullable|string|max:255'
            ];
            if (Auth::guard('users')->user()->role == 'Manager') {
                $keys['status']     =    'required|in:Pending,Accepted,Rejected,Running,Finished';
            }
            return $keys;
        } else if ($this->routeIs('programs_update')) {
            return [
                'name'                  => 'nullable|string',
                'address'               => 'nullable|string',
                'start_date'            => 'nullable|date',
                'end_date'              => 'nullable|date',
                'notes'                 => 'nullable|string|max:255',
                'status'                => 'nullable|in:Pending,Accepted,Rejected,Running,Finished',
            ];
        } else if ($this->routeIs('programs_show') || $this->routeIs('programs_delete')) {
            return [
                'id'                    => 'required|integer'
            ];
        } else if ($this->routeIs('programs_assign_missions')) {
            return [
                'missionsIds'           => 'required|array',
                'missionsIds.*'         => 'required|integer|exists:missions,id',
            ];
        } else if ($this->routeIs('programs_assign_sessions')) {
            return [
                'sessionsIds'           => 'required|array',
                'sessionsIds.*'         => 'required|integer|exists:sessions,id',
            ];
        }
    }
}
