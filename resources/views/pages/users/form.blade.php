@extends('layouts.app')

@section('title', isset($user) ? 'Edit User' : 'Add User')

@section('page_title', isset($user) ? 'Edit User' : 'Add User')

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

        <form method="POST" action="{{ isset($user) ? route('users.update', $user->id) : route('users.store') }}">
            @csrf
            @if(isset($user))
                @method('PUT')
            @endif

            <div class="form-group">
                @if (isset($student))
                    <input type="hidden" name="student_id" value="{{ $student->id }}">
                @endif
                <label>Email</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email ?? '') }}" required>

                @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" @if(!isset($user)) required @endif>

                @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

                @if(isset($user))
                    <small class="text-muted">
                        Leave blank if you don't want to change password
                    </small>
                @endif
            </div>
            <button class="btn btn-primary">Save</button>
        </form>
    </div>
</div>

@endsection
