<?php

namespace App\Http\Resources;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'category' => new CategoryResource(resource: $this->category), // Include category resource
            'category_id' =>  $this->category_id,
            'number_of_pages'=>$this->number_of_pages,
            'price' => $this->price,
            'code' => $this->code,
            'image' => $this->image,

            'created_at' => $this->created_at->format(' j F, Y'), // Example format: October 19, 2024
            'updated_at' => $this->updated_at,


        ];
    }
}
