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
    /**
     * Display a listing of the categories.
     */
    public function index(Request $request)
    {
        $categoriesQuery = Category::search($request);
        $allCategories = CategoryResource::collection($categoriesQuery->paginate(10));

        return Inertia::render('Categories/Index', [
            'categories' => $allCategories,
        ]);
    }
    public function test(Request $request)
    {
        $categoriesQuery = Category::search($request);
        $allCategories = CategoryResource::collection($categoriesQuery->paginate(10));

        return Inertia::render('Test/Test', [
            'categories' => $allCategories,
        ]);
    }

    /**
     * Show the form for creating a new category.
     */
    public function create()
    {
        return Inertia::render('Categories/Create');
    }

    /**
     * Store a newly created category in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        $data = $request->validated();

        // Handle SVG file upload
        if ($request->hasFile('svg')) {
            $data['svg'] = $request->file('svg')->store('svgs', 'public');
            $request['svg']->move('svgs', $data['svg']);
        }

        // Create the category
        Category::create($data);

        return redirect()->route('categories.index')->with('success', 'Category created successfully!');
    }

    /**
     * Display the specified category.
     */
    public function show(Category $category)
    {
        return Inertia::render('Categories/Show', [
            'category' => $category,
        ]);
    }

    /**
     * Show the form for editing the specified category.
     */
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return Inertia::render('Categories/Edit', [
            'category' => $category,
        ]);
    }

    /**
     * Update the specified category in storage.
     */
    public function update(UpdateCategoryRequest $request,  $id)
    {
     $category=   Category::findOrFail($id);
        $data = $request->validated();
        // Handle SVG file upload if provided
        if ($request->hasFile('svg')) {
            $data['svg'] = $request->file('svg')->store('svgs', 'public');
            $svgFile =$data['svg'] ;
            $myFile =    $request['svg']->move('svgs', $svgFile);
        }
        $category->update($data);
        $category->svg =$myFile ;
        $category->save();
        return redirect()->route('categories.index')->with('success', 'Category updated successfully!');
    }

    /**
     * Remove the specified category from storage.
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Category deleted successfully!');
    }
}
