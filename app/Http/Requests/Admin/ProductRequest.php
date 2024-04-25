<?php

namespace App\Http\Requests\Admin;

use App\Traits\ApiValidationTrait;
use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    use ApiValidationTrait;
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
            //
            'name' => 'required|string',
            'price' => 'required|string',
            'brand_id' => 'required|string',
            'images' => 'required',
            'short_description' => 'required|string',
            'description' => 'required|string',
            'sku_code' => 'required',
            'weight' => 'required'

        ];
    }
}
