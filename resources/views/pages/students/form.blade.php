@extends('layouts.app')

@section('title', isset($student) ? 'Edit Student' : 'Add Student')

@section('page_title', isset($student) ? 'Edit Student' : 'Add Student')

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

        <form method="POST" action="{{ isset($student) ? route('students.update', $student->id) : route('students.store') }}">
            @csrf
            @if(isset($student))
                @method('PUT')
            @endif

            <div class="form-group">
                <label>NIM</label>
                <input type="text" name="nim" class="form-control @error('nim') is-invalid @enderror" value="{{ old('nim', $student->nim ?? '') }}" required>

                @error('nim')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $student->name ?? '') }}" required>

                @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-group">
                <label>Status</label>
                <select name="is_active" class="form-control @error('is_active') is-invalid @enderror">
                    <option value="1" {{ old('is_active', $student->is_active ?? 1) == 1 ? 'selected' : '' }}>
                        Active
                    </option>
                    <option value="0" {{ old('is_active', $student->is_active ?? 1) == 0 ? 'selected' : '' }}>
                        Inactive
                    </option>
                </select>

                @error('is_active')
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
