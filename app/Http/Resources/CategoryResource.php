<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            'arabic_name' => $this->arabic_name,
            'turkish_name' => $this->turkish_name,
            'english_name' => $this->english_name,
            'image'=> $this->image,
            'created_at'=>$this->created_at->toFormattedDateString(),


        ];
    }
}
