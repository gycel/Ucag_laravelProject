<?php

namespace App\Http\Controllers;

use App\Models\Books;
use App\Models\Categories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function index()
    {
        $books = Books::latest()->get();
        $categories = Categories::latest()->get();
        return view('dashboard', compact('books', 'categories'));
    }

    public function store(Request $request) 
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Handle file upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('books', 'public');
            $validated['image'] = $imagePath;
        }

        Books::create($validated);
        return redirect()->route('dashboard')->with('success', 'Book successfully archived!');
    }

    public function edit(Books $book)
    {
        $books = Books::latest()->get();
        $categories = Categories::latest()->get();

        return view('dashboard', [
            'books' => $books,
            'categories' => $categories,
            'editingBook' => $book,
        ]);
    }

    public function update(Request $request, Books $book)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($book->image) {
                Storage::disk('public')->delete($book->image);
            }
            $validated['image'] = $request->file('image')->store('books', 'public');
        } else {
            unset($validated['image']);
        }

        $book->update($validated);

        return redirect()->route('dashboard')->with('success', 'Book updated successfully!');
    }

    public function destroy(Books $book)
    {
        if ($book->image) {
            Storage::disk('public')->delete($book->image);
        }

        $book->delete();
        return redirect()->route('dashboard')->with('success', 'Book deleted successfully!');
    }
}
