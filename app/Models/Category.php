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
        'name',

        'svg'
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
                    $query->where('name', 'like', '%' . $request->search . '%')
                        ;
                });
            });
        });
    }
}
