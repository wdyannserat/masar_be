<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MonitorTripRequest extends FormRequest
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
        return [
            'type' => '',
            'reason_of_switch' => '',
            'expected_facilitator_id' => '',
            'actual_facilitator_id' => '',
            'trip_id' => ''
        ];
    }
}
