@extends('layouts.app')

@section('title', 'Books')

@section('page_title', 'Books')

@section('content')

<div class="card">
    <div class="card-header">
        <form method="GET">
            <div class="row">
                <div class="col-md-4">
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Search title, author, or publisher">
                </div>

                <div class="col-md-2">
                    <button class="btn btn-primary">
                        Search
                    </button>
                </div>

                <div class="col-md-6 text-right">
                    <a href="{{ route('books.create') }}" class="btn btn-success">
                        Add Book
                    </a>
                </div>
            </div>
        </form>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Publisher</th>
                    <th>Qty</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($books as $book)
                <tr>
                    <td>
                        {{ $loop->iteration + ($books->currentPage() - 1) * $books->perPage() }}
                    </td>
                    <td>
                        {{ $book->title }}
                    </td>
                    <td>
                        {{ $book->author }}
                    </td>
                    <td>
                        {{ $book->publisher }}
                    </td>
                    <td>
                        {{ $book->stock?->quantity ?? 0 }}
                    </td>
                    <td>
                        <a href="{{ route('books.edit', $book->id) }}" class="btn btn-warning btn-sm">
                            Edit
                        </a>
                        <a href="{{ route('books.stock.form', $book->id) }}" class="btn btn-warning btn-sm">
                            Edit Stock
                        </a>
                        <form method="POST" action="{{ route('books.destroy', $book->id) }}" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('Delete data?')" class="btn btn-danger btn-sm">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-3">
            {{ $books->links() }}
        </div>
    </div>
</div>
@endsection
