<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller
{
    // Display a listing of the products.
    public function index(Request $request)
    {
        $categoryId = $request->query('category_id'); // Optional category ID filter

        $allProducts = Product::with('category')
            ->when($categoryId, function ($query, $categoryId) {
                $query->whereHas('category', function ($q) use ($categoryId) {
                    $q->where('id', $categoryId); // Filter by category if provided
                });
            });

        // Paginate the filtered products and apply the resource transformation
        $products = ProductResource::collection($allProducts->paginate(10));

        return Inertia::render('Products/Index', [
            'products' => $products,
            'filters' => [
                'category_id' => $categoryId,
            ],
        ]);
    }


    // Store a newly created product in storage.
    public function create()
    {

        $categories = Category::all();
        return Inertia::render(component: 'Products/Create',
        props: [
            'categories'=>$categories
        ]

    );
    }
    public function store(StoreProductRequest $request) {
    if ($request->hasFile('image')) {
        // Store the image in 'public/images' and get the relative path
        $validated['image'] = $request->file('image')->store('product_images', 'public');
    }
        // Create a new product
        $product = Product::create($request->validated());
        $request->file('image')->move('product_images', $validated['image']);
        $product->image = $validated['image'];
        $product->save();
        return redirect()->route('products.index'); // Redirect to the index page after creation
    }

    // Display the specified product.
    public function show(int $id): JsonResponse
    {
        $product = Product::findOrFail($id);
        return response()->json($product);
    }
    public function edit($id)
    {
        $categories = Category::all();

        $product = Product::where('id', $id)->first(); // Will return the first match
        // return $category;
        return Inertia::render('Products/Edit', [
            'product' => $product,
            'categories' => $categories,

        ]);
    }
    // Update the specified product in storage.
    public function update(UpdateProductRequest $request, int $id)
    {
        $product = Product::findOrFail($id);
        // Validate the incoming request

        if ($request->hasFile('image')) {
            $request->validate([
                'image' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048', ]

            );
            // Store the image in 'public/images' and get the relative path
            $validated['image'] = $request->file('image')->store('product_images', 'public');
        }


        $product->update($request->validated());
        if ($request->hasFile('image')) {
        $request->file('image')->move('product_images', $validated['image']);
        $product->image = $validated['image'];
        $product->save();
        }

        // Redirect back to a view or send a success message
        return redirect()->route('products.index')->with('success', 'Products updated successfully!');
    }

    // Remove the specified product from storage.
    public function destroy(int $id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('products.index');
    }
}
