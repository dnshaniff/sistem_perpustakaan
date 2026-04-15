@extends('layouts.app')

@section('title', 'Loans')

@section('page_title', 'Loans')

@section('content')

<div class="card">
    <div class="card-header">
        <form method="GET">
            <div class="row">
                <div class="col-md-4">
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Search nim, name, or book">
                </div>

                <div class="col-md-2">
                    <button class="btn btn-primary">
                        Search
                    </button>
                </div>

                <div class="col-md-6 text-right">
                    <a href="{{ route('loans.create') }}" class="btn btn-success">
                        Add Loan
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
                    <th>NIM</th>
                    <th>Name</th>
                    <th>Book</th>
                    <th>Loan Date</th>
                    <th>Return Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($loans as $loan)
                <tr>
                    <td>
                        {{ $loop->iteration + ($loans->currentPage() - 1) * $loans->perPage() }}
                    </td>
                    <td>
                        {{ $loan->user->student->nim }}
                    </td>
                    <td>
                        {{ $loan->user->student->name }}
                    </td>
                    <td>
                        {{ $loan->book->title }}
                    </td>
                    <td>
                        {{ $loan->loan_date->format('d F Y') }}
                    </td>
                    <td>
                        {{ $loan->return_date->format('d F Y') }}
                    </td>
                    <td>
                        <a href="{{ route('loans.edit', $loan->id) }}" class="btn btn-warning btn-sm">
                            Edit
                        </a>
                        <form method="POST" action="{{ route('loans.destroy', $loan->id) }}" style="display:inline;">
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
            {{ $loans->links() }}
        </div>
    </div>
</div>
@endsection
