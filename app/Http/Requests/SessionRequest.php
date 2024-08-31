<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
use PDO;

class SessionRequest extends FormRequest
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
        if ($this->routeIs('sessions_store')) {
            return [
                'name'                          => 'required|string|max:255',
                'category'                      => 'required|string|max:255',
            ];
        } else if ($this->routeIs('sessions_update')) {
            return [
                'name'                  => 'nullable|string|max:255',
                'category'              => 'nullable|string|max:255'
            ];
        } else if ($this->routeIs('sessions_show') || $this->routeIs('sessions_delete')) {
            return [
                'id'                    => 'required|integer|exists:sessions,id',
            ];
        } else if ($this->routeIs('close_session')) {
            return [
                // 'group_id'             => 'required|integer|exists:groups,id',
                // 'date'                 => 'nullable|date',
                // 'arrival_time'         => 'nullable|date_format:H:i:s',
                // 'departure_time'       => 'nullable|date_format:H:i:s',
                'group_schedule_id'       => 'required|exists:group_schedules,id'
            ];
        }
        else if($this->routeIs('child_sessions')) {
            return [
                'child_id'             => 'required|integer|exists:children,id'
            ];
        }
        return [];
    }
}
