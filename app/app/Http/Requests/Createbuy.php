<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Createbuy extends FormRequest
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
            'name' => 'required|max:20',
            'tel' => 'required|digits:11',
            'postcode' => 'required|digits:7',
            'address' => 'required',
        ];
    }
}
