<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUser extends FormRequest
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
            'name' => 'required|string',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($this->user)],
            'mobile' => ['nullable', 'regex:/^(09|\+639|9)\d{9}$/'],
            'address' => 'nullable'
        ];
    }
}
