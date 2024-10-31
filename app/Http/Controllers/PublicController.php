<?php

namespace App\Http\Controllers;

use App\Http\Resources\PublicCategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PublicController extends Controller
{
    public function show()
    {
        // Load the branch, with categories and their products
        $categories = Category::all();

        // Return the data using Inertia
        return Inertia::render('Welcome', [
            '$categories' => new PublicCategoryResource($categories)
        ]);
    }
    public function about()
    {
        return Inertia::render('About'); // Assuming the Vue component is named About.vue
    }
}
