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
            'number_of_pages'=> 'nullable|string',
            'notebook_ruling'=> 'nullable|string',
            'code' => [
                'required',
                'string',
                Rule::unique('products')->where(function ($query) {
                    return $query->where('category_id', $this->category_id); // Use $this to access the request input
                }). $this->route('id'),
            ],
        ];
    }
}
