@extends('layouts.app')

@section('title', 'Users')

@section('page_title', 'Users')

@section('content')

<div class="card">
    <div class="card-header">
        <form method="GET">
            <div class="row">
                <div class="col-md-4">
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Search name or email">
                </div>

                <div class="col-md-2">
                    <button class="btn btn-primary">
                        Search
                    </button>
                </div>
            </div>
        </form>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>
                        {{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}
                    </td>
                    <td>
                        {{ $user->role === 'administrator' ? 'Administrator' : $user->student?->name ?? 'N/A' }}
                    </td>
                    <td>
                        {{ $user->email }}
                    </td>
                    <td>
                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning btn-sm">
                            Edit
                        </a>
                        <form method="POST" action="{{ route('users.destroy', $user->id) }}" style="display:inline;">
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
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection
