<?php

namespace App\Rules;

use App\Models\User;
use Illuminate\Contracts\Validation\InvokableRule;
use Illuminate\Contracts\Validation\Rule;

class FacilitatorExistsRule implements InvokableRule
{
    /**
     * Run the validation rule.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  \Closure  $fail
     * @return void
     */
    public function __invoke($attribute, $value, $fail)
    {
        $facilitator = User::where([
            'id' => $value,
            'role' => 'Facilitator'
        ])->first();

        if(!isset($facilitator)){
            $fail(__('messages.FacilitatorDosntExists',['value' => $value]));
        }
    }
}