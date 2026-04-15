@extends('layouts.app')

@section('title', 'Edit Stock')

@section('page_title', 'Edit Stock')

@section('content')

<div class="card">
    <div class="card-header">
        <h5>
            Stock for:
            {{ $book->title }}
        </h5>
    </div>
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

        <form method="POST" action="{{ route('books.stock.store', $book->id) }}">
            @csrf

            <div class="form-group">
                <label>Quantity</label>
                <input type="number" name="quantity" class="form-control @error('quantity') is-invalid @enderror" value="{{ old('quantity', $book->stock->quantity ?? '') }}" required>

                @error('quantity')
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
