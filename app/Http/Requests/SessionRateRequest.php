<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SessionRateRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        if ($this->routeIs('session_rates_store')) {
            return [
                'rate'                  => 'required|in:1,2,3,4,5'
            ];
        } else if ($this->routeIs('session_rates_update')) {
            return [
                'rate'                  => 'nullable|in:1,2,3,4,5'
            ];
        }
        return [];
    }
}
