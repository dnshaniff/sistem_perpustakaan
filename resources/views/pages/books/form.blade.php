@extends('layouts.app')

@section('title', isset($book) ? 'Edit Book' : 'Add Book')

@section('page_title', isset($book) ? 'Edit Book' : 'Add Book')

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

        <form method="POST" action="{{ isset($book) ? route('books.update', $book->id) : route('books.store') }}">
            @csrf
            @if(isset($book))
                @method('PUT')
            @endif

            <div class="form-group">
                <label>Title</label>
                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $book->title ?? '') }}" required>

                @error('title')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-group">
                <label>Author</label>
                <input type="text" name="author" class="form-control @error('author') is-invalid @enderror" value="{{ old('author', $book->author ?? '') }}" required>

                @error('author')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-group">
                <label>Publisher</label>
                <input type="text" name="publisher" class="form-control @error('publisher') is-invalid @enderror" value="{{ old('publisher', $book->publisher ?? '') }}" required>

                @error('publisher')
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
