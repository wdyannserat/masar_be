<?php

namespace App\Rules;

use App\Models\ChildGroup;
use Illuminate\Contracts\Validation\InvokableRule;
use Illuminate\Contracts\Validation\Rule;

class ChildNotExistInGroup implements InvokableRule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function __invoke($attribute, $value, $fail)
    {
        $facilitator = ChildGroup::where([
            'child_id' => $value,
            'status' => 'Active'
        ])->first();

        if(isset($facilitator)){
            $fail(__('messages.ChildAlreadyExistInGroup',['value' => $value]));
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The validation error message.';
    }
}
