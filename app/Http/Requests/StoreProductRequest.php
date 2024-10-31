<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class
StoreProductRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Adjust this if you want to implement authorization logic
    }



    public function rules()
    {
        return [
            'category_id' => 'required|exists:categories,id', // Ensure the category exists
            'notebook_size' => 'nullable|string',
            'cover_type' => 'nullable|string',
            'paper_weight' => 'nullable|string',
            'number_of_pages' => 'nullable|numeric',
            'notebook_ruling' => 'nullable|string',
            'type_of_spiral' => 'nullable|string',

            'code' => [
                'required',
                'string',
                Rule::unique('products')->where(function ($query) {
                    return $query->where('category_id', $this->category_id); // Use $this to access the request input
                }),
            ],

            'images' => 'required|array', // Ensure it's an array
        ];
    }

public function messages()
{
    return [
        'images.required' => 'Please upload at least one image.',
        'images.array' => 'Invalid image upload format.',
        'images.*.image' => 'Each file must be an image.',
        'images.*.mimes' => 'Only JPG, JPEG, PNG, GIF, and SVG formats are allowed.',
        'images.*.max' => 'Each image must not exceed 2MB in size.',
    ];
}
}
