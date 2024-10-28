<?php

namespace App\Http\Controllers;

use App\Http\Resources\PublicProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PublicProductController extends Controller
{
    public function show( $category, $product)
    {
        $product = Product::with('category')->findOrFail($product);
        // Return the data using Inertia
        return Inertia::render('Public/Products/Show', [
            'product' =>  $product,
        ]);
    }
}
