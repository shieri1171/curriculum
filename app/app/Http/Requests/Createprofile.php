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
            'profile' => 'max:300',
            'name' => 'max:20',
            'tel' => 'digits:11',
            'postcode' => 'digits:7',
        ];
    }
}
