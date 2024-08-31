<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GroupScheduleRequest extends FormRequest
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
        if ($this->routeIs('group_schedules_store')) {
            return [
                'arrival_times'                    => 'required|array',
                'arrival_times.*.arrival_time'     => 'required|date_format:H:i',
                'arrival_times.*.departure_time'   => 'required|date_format:H:i',
                'arrival_times.*.day_number'       => 'required|in:1,2,3,4,5,6,7',
                'arrival_times.*.date'             => 'required|date'
            ];
        } else if ($this->routeIs('assign_sessions_to_group_schedule')) {
            return [
                'sessionsIds'                      => 'required|array',
                'sessionsIds.*id'                  => 'required|integer|exists:sessions,id',
                'sessionsIds.*description'         => 'nullable|string|max:255',
            ];
        }
        return [];
    }
}
