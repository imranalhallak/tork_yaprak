<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

use Illuminate\Database\Eloquent\Builder;

class Product extends Model
{
    use HasFactory;

    // Fillable properties for mass assignment
    protected $fillable = [
        'category_id', // Foreign key to the menu
        'price',
        'code',
        'image',
        'code',
        'type_of_spiral',
        'notebook_size',
        'cover_type',
        'paper_weight',
        'number_of_pages',
        'notebook_ruling',
    ];

    // Define the relationship with Menu
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function scopeSearch(Builder $query, Request $request)
    {
        return $query->where(function ($query) use ($request) {
            return $query->when($request->search, function ($query) use ($request) {
                return $query->where(function ($query) use ($request) {
                    $query->where('arabic_name', 'like', '%' . $request->search . '%')
                        ->orWhere('english_name', 'like', '%' . $request->search . '%')
                        ->orWhere('turkish_name', 'like', '%' . $request->search . '%')
                        ->orWhere('turkish_description', 'like', '%' . $request->search . '%')
                        ->orWhere('english_description', 'like', '%' . $request->search . '%')
                        ->orWhere('arabic_description', 'like', '%' . $request->search . '%')
                        ->orWhere('code', 'like', '%' . $request->search . '%')
                        ;
                });
            });
        });
    }
}
