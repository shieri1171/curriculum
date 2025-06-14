<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Createuser extends FormRequest
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
            'username' => 'required|max:40|unique:users,username',
            'email' => 'required|max:30|unique:users,email',
            'password' => 'required|min:8|max:20|confirmed',
        ];
    }
}
