<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AddUpdateQuestion extends FormRequest
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
            'question' => 'required',
            'a' => 'required|max:255',
            'b' => 'required|max:255',
            'c' => 'required|max:255',
            'd' => 'required|max:255',
            'answer' => ['required', Rule::in(['a', 'b', 'c', 'd'])],
            'answer_explanation' => 'nullable'
        ];
    }
}
