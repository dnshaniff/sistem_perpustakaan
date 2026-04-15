@extends('layouts.app')

@section('title', 'Students')

@section('page_title', 'Students')

@section('content')

<div class="card">
    <div class="card-header">
        <form method="GET">
            <div class="row">
                <div class="col-md-4">
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Search nim or name">
                </div>

                <div class="col-md-2">
                    <button class="btn btn-primary">
                        Search
                    </button>
                </div>

                <div class="col-md-6 text-right">
                    <a href="{{ route('students.create') }}" class="btn btn-success">
                        Add Student
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
                    <th>NIK</th>
                    <th>Name</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($students as $student)
                <tr>
                    <td>
                        {{ $loop->iteration + ($students->currentPage() - 1) * $students->perPage() }}
                    </td>
                    <td>
                        {{ $student->nim }}
                    </td>
                    <td>
                        {{ $student->name }}
                    </td>
                    <td>
                        <span class="badge {{ $student->is_active ? 'badge-success' : 'badge-danger' }}" data-id="{{ $student->id }}">
                            {{ $student->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td>
                        @if (!$student->user)
                            <a href="{{ route('users.create', ['student' => $student->id]) }}" class="btn btn-success btn-sm">
                                Create User
                            </a>
                        @endif
                        <a href="{{ route('students.edit', $student->id) }}" class="btn btn-warning btn-sm">
                            Edit
                        </a>
                        <form method="POST" action="{{ route('students.destroy', $student->id) }}" style="display:inline;">
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
            {{ $students->links() }}
        </div>
    </div>
</div>
@endsection
