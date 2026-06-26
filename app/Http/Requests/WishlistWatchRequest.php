<?php

namespace App\Http\Requests;

use App\Enums\MovementEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class WishlistWatchRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'model' => ['required', 'string', 'max:255'],
            'picture' => ['nullable', 'url', 'max:2048'],
            'brand_id' => ['required', 'integer', 'exists:brands,id'],
            'price' => ['required', 'integer', 'min:0'],
            'movement' => ['required', 'string', Rule::in(MovementEnum::values())],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
