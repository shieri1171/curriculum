<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use App\Models\Item;

class Edititem extends FormRequest
{

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
            'images' => 'array|min:1|max:10',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'presentation' => 'max:300',
            'state' => 'required',
        ];

    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $newImages = $this->file('images');
            $newCount = is_array($newImages) ? count($newImages) : ($newImages ? 1 : 0);

            $itemId = $this->route('item');
            $item = Item::with('itemImages')->find($itemId);

            if (($newCount + $existingCount) == 0) {
                $validator->errors()->add('images', '画像は1枚以上登録してください。');
            }

            if (($newCount + $existingCount) > 10) {
                $validator->errors()->add('images', '画像登録は10枚までです。');
            }
        });
    }
}