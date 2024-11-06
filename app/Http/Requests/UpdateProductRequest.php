<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Implement authorization logic as needed
    }

    public function rules(): array
    {
        $productId = $this->route('id');

        return [
            'category_id' => ['required', 'exists:categories,id'],
            'notebook_size' => ['nullable', 'string'],
            'cover_type' => ['nullable', 'string'],
            'paper_weight' => ['nullable', 'string'],
            'number_of_pages' => ['nullable', 'numeric'],
            'notebook_ruling' => ['nullable', 'string'],
            'type_of_spiral' => ['nullable', 'string'],
            'code' => [
                'required',
                'string',
                Rule::unique('products')
                    ->where('category_id', $this->category_id)
                    ->ignore($productId),
            ],
        ];
    }
}
