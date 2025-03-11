<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BestSellerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'author' => 'nullable|string',
            'isbn' => 'nullable|array',
            'isbn.*' => 'string',
            'title' => 'nullable|string',
            'offset' => 'nullable|integer|min:0',
        ];
    }
}
