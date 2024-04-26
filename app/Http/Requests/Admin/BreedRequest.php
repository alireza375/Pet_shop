<?php

namespace App\Http\Requests\Admin;

use App\Traits\ApiValidationTrait;
use Illuminate\Foundation\Http\FormRequest;

class BreedRequest extends FormRequest
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
            // 'name' => 'required|string',
            // 'origin' => 'required|string',
            // 'year_recognized' => 'required|integer',
            // 'description' => 'required|string',
            // 'traits' => 'required|array',
            // 'specifications' => 'required|array',
            // 'image' => 'nullable|string',
        ];
    }
}
