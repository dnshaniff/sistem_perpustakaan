@extends('layouts.app')

@section('title', isset($loan) ? 'Edit Loan' : 'Add Loan')

@section('page_title', isset($loan) ? 'Edit Loan' : 'Add Loan')

@section('content')

<div class="card">
    <div class="card-body">

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ isset($loan) ? route('loans.update', $loan->id) : route('loans.store') }}">
            @csrf
            @if(isset($loan))
                @method('PUT')
            @endif

            <div class="form-group">
                <label>Student</label>
                <select name="user_id" class="form-control @error('user_id') is-invalid @enderror" required>
                    <option value="">Select Student</option>

                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ old('user_id', $loan->user_id ?? '') == $user->id ? 'selected' : '' }}>
                            {{ "{$user->student->nim}: {$user->student->name}" }}
                        </option>
                    @endforeach
                </select>

                @error('user_id')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label>Book</label>
                <select name="book_id" class="form-control @error('book_id') is-invalid @enderror" required>
                    <option value="">Select Book</option>

                    @foreach($books as $book)
                        <option value="{{ $book->id }}" {{ old('book_id', $loan->book_id ?? '') == $book->id ? 'selected' : '' }}>
                            {{ $book->title }} (Stock: {{ $book->stock->quantity ?? 0 }})
                        </option>
                    @endforeach
                </select>

                @error('book_id')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label>Loan Date</label>
                <input type="date" name="loan_date" class="form-control @error('loan_date') is-invalid @enderror" value="{{ old('loan_date', isset($loan->loan_date) ? $loan->loan_date->format('Y-m-d') : now()->format('Y-m-d')) }}" required>

                @error('loan_date')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label>Return Date</label>
                <input type="date" name="return_date" class="form-control @error('return_date') is-invalid @enderror" value="{{ old('return_date', isset($loan->return_date) ? $loan->return_date->format('Y-m-d') : now()->addDays(14)->format('Y-m-d')) }}" required>
                <small class="text-muted">
                    Maximum loan duration is 14 days
                </small>

                @error('return_date')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <button class="btn btn-primary">Save</button>
        </form>
    </div>
</div>

@endsection
