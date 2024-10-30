<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Adjust this if you want to implement authorization logic
    }

    public function rules()
    {
        return [
            'category_id' => 'required|exists:categories,id', // Ensure the menu exists
            'notebook_size'=> 'nullable|string',
            'cover_type'=> 'nullable|string',
            'paper_weight'=> 'nullable|string',
            'number_of_pages'=> 'nullable|numeric',
            'notebook_ruling'=> 'nullable|string',
            'type_of_spiral'=> 'nullable|string',
            'code' => [
                'required',
                'string',
                Rule::unique('products')->where(function ($query) {
                    $query->where('category_id', $this->category_id); // Use $this to access the request input
                })->ignore($this->route('id')), // Exclude the current product ID if it exists
            ],
        ];
    }
}
