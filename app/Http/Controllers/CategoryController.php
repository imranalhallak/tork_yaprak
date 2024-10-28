<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoryController extends Controller

{
      // Display a listing of the categories (Inertia response).
      public function index(Request $request)
      {
          $categoriesQuery = Category::search($request);

          $allCategories =CategoryResource::collection( $categoriesQuery->paginate(10));
          return Inertia::render('Categories/Index', [ // Render the Inertia Vue component
              'categories' => $allCategories
          ]);
      }

    public function test(Request $request)
    {
        $categoriesQuery = Category::search($request);

        $allCategories =CategoryResource::collection( $categoriesQuery->get())->paginate(10);
        return Inertia::render('Test/Test', [ // Render the Inertia Vue component
            'categories' => $allCategories

        ]);
    }

    // Display the create form for a category.
    public function create()
    {

        return Inertia::render('Categories/Create',[
        ]);
    }

    // Store a newly created category in storage.
    public function store(StoreCategoryRequest $request)
    {
        if ($request->hasFile('image')) {
            // Store the image in 'public/images' and get the relative path
            $validated['image'] = $request->file('image')->store('category_images', 'public');
        }
        $data = $request->validated();


        $request->file('image')->move('category_images', $validated['image']);

        $category = Category::create($data); // Create a new category
        $category->image = $validated['image'];
        $category->save();


        // return $category;
        return redirect()->route('categories.index'); // Redirect to the index page after creation
    }

    // Display the specified category.
    public function show($id)
    {
        $category = Category::findOrFail($id); // Find the category by ID
        return Inertia::render('Categories/Show', [
            'category' => $category
        ]);
    }

    // Display the edit form for a category.
    public function edit($id)
    {

        $category = Category::where('id', $id)->first(); // Will return the first match
        // return $category;
        return Inertia::render('Categories/Edit', [
            'category' => $category,

        ]);
    }

    // Update the specified category in storage.
    public function update(UpdateCategoryRequest $request, $id)
    {
        $category = Category::findOrFail($id);
        // Validate the incoming request

        if ($request->hasFile('image')) {
            $request->validate([
                'image' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048', ]

            );
            // Store the image in 'public/images' and get the relative path
            $validated['image'] = $request->file('image')->store('category_images', 'public');
        }


        $category->update($request->validated());
        if ($request->hasFile('image')) {
        $request->file('image')->move('category_images', $validated['image']);
        $category->image = $validated['image'];
        $category->save();
        }

        // Redirect back to a view or send a success message
        return redirect()->route('categories.index')->with('success', 'Category updated successfully!');
    }

    // Remove the specified category from storage.
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete(); // Delete the category
        return redirect()->route('categories.index'); // Redirect to the index page after deletion
    }
}
