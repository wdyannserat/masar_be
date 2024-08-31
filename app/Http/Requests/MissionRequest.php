<?php

namespace App\Http\Requests;

use App\Models\ChallengeChild;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class MissionRequest extends FormRequest
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
        if ($this->routeIs('missions_store')) {
            return [
                'name'                          => 'required|string|max:255',
                'category'                      => 'required|string|max:255',
                'description'                   => 'required|string|max:255',
                'total_points'                  => 'required|integer',
                'is_active'                     => 'required|boolean',
                'photo'                         => 'required|file',
                'badge_image'                   => 'required|image',
                'badge_name'                    => 'required|string|max:255',
                'challenges'                    => [
                    'required',
                    'array',
                    function ($attribute, $value, $fail) {
                        $challengeRequest = new ChallengeRequest();
                        foreach ($value as $key => $challenge) {
                            $validator = Validator::make($challenge, collect($challengeRequest->rules())->except('mission_id')->toArray());
                            if ($validator->fails()) {
                                $fail("Challenge $key failed validation: " . implode(', ', $validator->errors()->all()));
                            }
                        }
                    }
                ]
            ];
        }

        else if($this->routeIs('missions_show')){
            return [
                'id'                             => 'required|integer|exists:missions,id'
            ];
        }
    }
}
