<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Createprofile extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'username' => 'required|max:40',
            'profile' => 'nullable|max:300',
            'name' => 'nullable|max:20',
            'tel' => 'nullable|digits:11',
            'postcode' => 'nullable|digits:7',
        ];
    }
}
