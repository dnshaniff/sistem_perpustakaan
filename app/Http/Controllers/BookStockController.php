<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookStock;
use Illuminate\Http\Request;

class BookStockController extends Controller
{
    public function form(Book $book)
    {
        return view('pages.bookStocks.form', compact('book'));
    }

    public function store(Request $request, Book $book)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:0',
        ]);

        BookStock::updateOrCreate(
            ['book_id' => $book->id],
            ['quantity' => $validated['quantity']]
        );

        return redirect()->route('books.index')->with('success', 'Stock updated successfully');
    }
}
