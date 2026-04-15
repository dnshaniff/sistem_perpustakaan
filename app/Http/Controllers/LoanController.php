<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LoanController extends Controller
{
    public function index(Request $request)
    {
        $query = Loan::query()->with(['user:id', 'user.student:id,user_id,nim,name', 'book:id,title']);

        if ($request->search) {
            $search = $request->search;
            $query()->whereHas('user.student', function ($q) use ($search) {
                $q->where('nim', 'like', '%' . $search . '%')
                    ->orWhere('name', 'like', '%' . $search . '%');
            })->orWhereHas('book', function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%');
            });
        }

        $loans = $query->latest()->paginate(10);

        return view('pages.loans.index', compact('loans'));
    }

    public function create()
    {
        $users = User::query()->where('users.role', 'user')
            ->join('students', 'students.user_id', '=', 'users.id')
            ->with('student:user_id,nim,name')
            ->select('users.id')
            ->orderBy('students.nim')
            ->get();

        $books = Book::query()->with('stock:book_id,quantity')
            ->select('id', 'title')
            ->orderBy('title')
            ->get();

        return view('pages.loans.form', compact('users', 'books'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'book_id' => 'required|exists:books,id',
            'loan_date' => 'required|date',
            'return_date' => 'required|date|after_or_equal:loan_date',
        ]);

        try {
            DB::transaction(function () use ($validated) {
                $book = Book::where('id', $validated['book_id'])->lockForUpdate()->first();

                if (!$book->stock || $book->stock->quantity <= 0) {
                    throw new Exception('Book stock is not available');
                }

                $user = User::with('student')->findOrFail($validated['user_id']);

                if (!$user->student || !$user->student->is_active) {
                    throw new Exception('Student is not active');
                }

                $days = Carbon::parse($validated['loan_date'])->diffInDays(
                    Carbon::parse($validated['return_date'])
                );

                if ($days > 14) {
                    throw new Exception('Loan duration cannot exceed 14 days');
                }

                Loan::create($validated);

                $book->stock->decrement('quantity');
            });

            return redirect()->route('loans.index')->with('success', 'Loan created successfully');
        } catch (Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function edit(Loan $loan)
    {
        $users = User::query()->where('users.role', 'user')
            ->join('students', 'students.user_id', '=', 'users.id')
            ->with('student:user_id,nim,name')
            ->select('users.id')
            ->orderBy('students.nim')
            ->get();

        $books = Book::query()->with('stock:book_id,quantity')
            ->select('id', 'title')
            ->orderBy('title')
            ->get();

        return view('pages.loans.form', compact('loan', 'users', 'books'));
    }

    public function update(Request $request, Loan $loan)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'book_id' => 'required|exists:books,id',
            'loan_date' => 'required|date',
            'return_date' => 'required|date|after_or_equal:loan_date',
        ]);

        try {
            DB::transaction(function () use ($validated, $loan) {
                $user = User::with('student')->findOrFail($validated['user_id']);
                if (!$user->student || !$user->student->is_active) {
                    throw new Exception('Student is not active'
                    );
                }

                $days = Carbon::parse($validated['loan_date'])->diffInDays(
                    Carbon::parse($validated['return_date'])
                );

                if ($days > 14) {
                    throw new Exception('Loan duration cannot exceed 14 days');
                }

                if ($loan->book_id != $validated['book_id']) {
                    $oldBook = Book::where('id', $loan->book_id)->lockForUpdate()->first();

                    if ($oldBook->stock) {
                        $oldBook->stock->increment('quantity');
                    }

                    $newBook = Book::where('id', $validated['book_id'])->lockForUpdate()->first();

                    if (!$newBook->stock || $newBook->stock->quantity <= 0) {
                        throw new Exception('Book stock is not available');
                    }

                    $newBook->stock->decrement('quantity');
                }

                $loan->update($validated);
            });

            return redirect()->route('loans.index')->with('success', 'Loan updated successfully');
        } catch (Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function destroy(Loan $loan)
    {
        try {
            DB::transaction(function () use ($loan) {
                $book = Book::where('id', $loan->book_id)->lockForUpdate()->first();

                if ($book && $book->stock) {
                    $book->stock->increment('quantity');
                }

                $loan->delete();
            });

            return redirect()->route('loans.index')->with('success', 'Loan deleted successfully');
        } catch (Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }
}
