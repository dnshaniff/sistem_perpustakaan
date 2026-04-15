<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $query = Loan::query()
            ->join('users', 'users.id', '=', 'loans.user_id')
            ->join('students', 'students.user_id', '=', 'users.id')
            ->join('books', 'books.id', '=', 'loans.book_id')
            ->selectRaw('loans.*, DATEDIFF(loans.return_date, loans.loan_date) as duration')
            ->with([
                'book:id,title',
                'user.student:id,user_id,nim,name'
            ])
            ->when(Auth::user()->role !== 'administrator', function ($q) {
                $q->where('loans.user_id', Auth::id());
            });

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('students.nim', 'like', "%{$search}%")
                    ->orWhere('students.name', 'like', "%{$search}%")
                    ->orWhere('books.title', 'like', "%{$search}%")
                    ->orWhere('loans.book_id', 'like', "%{$search}%");
            });
        }

        $sortable = [
            'nim' => 'students.nim',
            'name' => 'students.name',
            'book_id' => 'loans.book_id',
            'title' => 'books.title',
            'loan_date' => 'loans.loan_date',
            'return_date' => 'loans.return_date',
            'duration' => 'duration'
        ];

        $sort = $request->get('sort', 'loan_date');
        $direction = $request->get('direction', 'desc');

        if (!array_key_exists($sort, $sortable)) {
            $sort = 'loan_date';
        }

        $query->orderBy($sortable[$sort], $direction);

        $loans = $query->paginate(10)->withQueryString();

        return view('pages.dashboard', compact('loans'));
    }
}
