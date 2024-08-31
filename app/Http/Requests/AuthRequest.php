<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class AuthRequest extends FormRequest
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
        if ($this->routeIs('user_login')) {
            return [
                'username_or_phone_number'  => 'required|max:255',
                'password'                  => 'required|min:8|max:255',
            ];
        } else if ($this->routeIs('update_child_profile')) {
            return [
                'first_name'                => 'nullable|string|max:255',
                'last_name'                 => 'nullable|string|max:255',
                'photo'                     => 'nullable|file'
            ];
        } else if ($this->routeIs('child_login')) {
            return [
                'username'                  => 'required|max:255|exists:children,username',
                'password'                  => 'required|min:8|max:255',
            ];
        } else if ($this->routeIs('update_parent_password')) {
            return [
                'old_password'              => 'required|min:8|max:255',
                'new_password'              => 'required|min:8|max:255|confirmed',
            ];
        } else if ($this->routeIs('update_account_status')) {
            return [
                'account_id'                => 'required|integer',
                'account_type'              => 'required|string|in:User,Child',
                'is_active'                 => 'required|boolean'
            ];
        }

        return [];
    }
}
