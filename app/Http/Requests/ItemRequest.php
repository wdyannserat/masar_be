<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ItemRequest extends FormRequest
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
            'status' => 'required|in:Active,In_Active',
            'quantity' => 'required|integer|min:1|max:100',
            'name' => 'required|string|min:3|max:255',
            'point_price' => 'required',
            'category' => 'required|string|min:3|max:255',
            'attachment_id' => 'required|integer|exists:attachments,id'
        ];
    }
}
