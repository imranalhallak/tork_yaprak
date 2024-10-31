<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller
{
    // Display a listing of the products.
    public function index(Request $request)
    {
        $categoryId = $request->query('category_id');

        $productsQuery = Product::with('category')
            ->when($categoryId, function ($query) use ($categoryId) {
                $query->whereHas('category', fn($q) => $q->where('id', $categoryId));
            });

        // Paginate the filtered products and apply the resource transformation
        $products = ProductResource::collection($productsQuery->paginate(10));

        return Inertia::render('Products/Index', [
            'products' => $products,
            'filters' => ['category_id' => $categoryId],
        ]);
    }

    // Store a newly created product in storage.
    public function create()
    {
        $categories = Category::all();

        return Inertia::render('Products/Create', [
            'categories' => $categories,
        ]);
    }

    public function store(StoreProductRequest $request)
    {


        // Handle the images
        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                // Store the image and get its path
                $imagePath = $image->store('product_images', 'public'); // Specify your directory
                $image->move('product_images', $imagePath);

                $imagePaths[] = $imagePath; // Add the path to the array
            }
        }

        // Store product data in the database
        Product::create([
            'category_id' => $request->category_id,
            'notebook_size' => $request->notebook_size,
            'cover_type' => $request->cover_type,
            'paper_weight' => $request->paper_weight,
            'number_of_pages' => $request->number_of_pages,
            'notebook_ruling' => $request->notebook_ruling,
            'type_of_spiral' => $request->type_of_spiral,
            'code' => $request->code,
            'images' => json_encode($imagePaths), // Convert array to JSON
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('products.index')->with('success', 'Product created successfully!');
    }


    // Display the specified product.
    public function show(int $id)
    {
        $product = Product::findOrFail($id);
        return response()->json($product);
    }

    public function edit(int $id)
    {
        $categories = Category::all();
        $product = Product::findOrFail($id);

        return Inertia::render('Products/Edit', [
            'product' => $product,
            'categories' => $categories,
        ]);
    }

    // Update the specified product in storage.
    public function update(UpdateProductRequest $request, int $id)
    {
        $product = Product::findOrFail($id);

        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                // Store the image in the 'public/product_images' directory
                $imagePath = $image->store('product_images', 'public');
                $image->move('product_images', $imagePath);
                $imagePaths[] = $imagePath; // Add the path to the array
            }
        }

        // Update the product's attributes
        $product->update([
            'category_id' => $request->category_id,
            'notebook_size' => $request->notebook_size,
            'cover_type' => $request->cover_type,
            'paper_weight' => $request->paper_weight,
            'number_of_pages' => $request->number_of_pages,
            'notebook_ruling' => $request->notebook_ruling,
            'type_of_spiral' => $request->type_of_spiral,
            'code' => $request->code,
            'images' => json_encode($imagePaths), // Convert array to JSON
            'updated_at' => now(),
        ]);

        return redirect()->route('products.index')->with('success', 'Product updated successfully!');
    }


    // Remove the specified product from storage.
    public function destroy(int $id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('products.index');
    }

    // Helper method to handle image uploads
    private function handleImageUploads($images)
    {
        $paths = [];
        if ($images) {
            foreach ($images as $file) {
                $paths[] = $file->store('product_images', 'public');
            }
        }
        return $paths;
    }
}
