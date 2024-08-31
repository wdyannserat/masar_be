<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

class ChallengeRequest extends FormRequest
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
        if ($this->routeIs('missions_store') || $this->routeIs('challenges_store')) {
            return [
                'name'                  => 'required|string|max:255',
                'challenge_photo'       => 'required|image|mimes:png,jpg,jpeg,svg',
                'points'                => 'required',
                'is_timed'              => 'required|boolean',
                'duration_in_days'      => 'required_if:is_times,true|integer',
                'duration_in_hours'     => 'required_if:is_times,true|numeric|between:0,999.99',
                'status'                => 'required|string|in:Active,InActive',
                'mission_id'            => 'required|integer|exists:missions,id'
            ];
        } else if ($this->routeIs('document_challenge')) {
            return [
                'files'                 => 'required|array',
                'files.*.file'          => 'required',//|file|mimes:mp4,mov,ogg,qt,jpg,png,jpeg,|max:20000',
                'files.*.description'   => 'nullable|string',
            ];
        }
        return [];
    }
}
