<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

use Illuminate\Database\Eloquent\Builder;
class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'arabic_name',
        'turkish_name',
        'english_name',
        'image',
        'price',
        'code',
    ];

    // Define the relationship with Product
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function scopeSearch(Builder $query, Request $request)
    {
        return $query->where(function ($query) use ($request) {
            return $query->when($request->search, function ($query) use ($request) {
                return $query->where(function ($query) use ($request) {
                    $query->where('arabic_name', 'like', '%' . $request->search . '%')
                        ->orWhere('english_name', 'like', '%' . $request->search . '%')
                        ->orWhere('turkish_name', 'like', '%' . $request->search . '%')
                        ;
                });
            });
        });
    }
}
