<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::query()->with('stock:book_id,quantity');

        if ($request->search) {
            $search = $request->search;
            $query->where('title', 'like', '%' . $search . '%')
                ->orWhere('author', 'like', '%' . $search . '%')
                ->orWhere('publisher', 'like', '%' . $search . '%');
        }

        $books = $query->latest()->paginate(10);

        return view('pages.books.index', compact('books'));
    }

    public function create()
    {
        return view('pages.books.form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|min:4',
            'author' => 'required|min:4',
            'publisher' => 'required|min:4'
        ]);

        Book::create($validated);

        return redirect()->route('books.index')->with('success', 'Book created successfully');
    }

    public function edit(Book $book)
    {
        return view('pages.books.form', compact('book'));
    }

    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'title' => 'required|min:4',
            'author' => 'required|min:4',
            'publisher' => 'required|min:4'
        ]);

        $book->update($validated);

        return redirect()->route('books.index')->with('success', 'Book updated successfully');
    }

    public function destroy(Book $book)
    {
        $book->delete();

        return redirect()->route('books.index')->with('success', 'Book deleted successfully');
    }
}
