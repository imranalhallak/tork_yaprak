<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Http\Resources\PublicCategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PublicCategoryController extends Controller
{
    public function show($category)
    {
        $category = Category::with('products')->findOrFail($category);

        // Return the data using Inertia
        return Inertia::render('Public/Categories/Show', [
            'category' => new PublicCategoryResource($category)
        ]);
    }
}
