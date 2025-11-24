<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Categories::latest()->get();
        return view('categories', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ]);

        Categories::create($request->only(['name', 'description']));
        return redirect()->route('categories')->with('success', 'Category created successfully');
    }

    public function edit(Categories $category)
    {
        $categories = Categories::latest()->get();

        return view('categories', [
            'categories' => $categories,
            'editingCategory' => $category,
        ]);
    }

    public function update(Request $request, Categories $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ]);

        $category->update($validated);

        return redirect()->route('categories')->with('success', 'Category updated successfully');
    }

    public function destroy(Categories $category)
    {
        $category->delete();

        return redirect()->route('categories')->with('success', 'Category deleted successfully');
    }
}
