<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Createitem extends FormRequest
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
            'itemname' => 'required|max:40',
            'price' => 'required|integer|min:300|max:999999',
            'images' => 'nullable|array|max:10',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'presentation' => 'max:300',
            'state' => 'required',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $newImages = $this->file('images');
            $newCount = is_array($newImages) ? count($newImages) : 0;

            $sessionImages = session('images', []);
            $sessionCount = count($sessionImages);

            if ($newCount + $sessionCount == 0) {
                $validator->errors()->add('images', '画像は1枚以上登録してください。');
            }
        });
    }

}
