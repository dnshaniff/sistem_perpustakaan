@extends('layouts.app')

@section('title', 'Dashboard')

@section('page_title', 'Dashboard')

@section('content')

<div class="card">
    <div class="card-body">
        Welcome to the library management system!
    </div>
</div>

@if (isset($loans) && $loans->count() > 0)
    <div class="card">
        <div class="card-header">
            <form method="GET">
                <div class="row">
                    <div class="col-md-4">
                        <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Search nik, name, title">
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
            @php
                function sortDirection($field) {
                    if (request('sort') === $field) {
                        return request('direction') === 'asc' ? 'desc' : 'asc';
                    }
                    return 'asc';
                }

                function sortIcon($field) {
                    if (request('sort') === $field) {
                        return request('direction') === 'asc' ? '↑' : '↓';
                    }
                    return '';
                }
            @endphp
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'nim', 'direction' => sortDirection('nim')]) }}">
                                NIM {!! sortIcon('nim') !!}
                            </a>
                        </th>
                        <th>
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'name', 'direction' => sortDirection('name')]) }}">
                                Name {!! sortIcon('name') !!}
                            </a>
                        </th>
                        <th>
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'book_id', 'direction' => sortDirection('book_id')]) }}">
                                Book ID {!! sortIcon('book_id') !!}
                            </a>
                        </th>
                        <th>
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'title', 'direction' => sortDirection('title')]) }}">
                                Book Name {!! sortIcon('title') !!}
                            </a>
                        </th>
                        <th>
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'loan_date', 'direction' => sortDirection('loan_date')]) }}">
                                Loan Date {!! sortIcon('loan_date') !!}
                            </a>
                        </th>
                        <th>
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'return_date', 'direction' => sortDirection('return_date')]) }}">
                                Return Date {!! sortIcon('return_date') !!}
                            </a>
                        </th>
                        <th>
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'duration', 'direction' => sortDirection('duration')]) }}">
                                Duration (days) {!! sortIcon('duration') !!}
                            </a>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($loans as $loan)
                        <tr>
                            <td>
                                {{ $loan->user?->student?->nim ?? '-' }}
                            </td>
                            <td>
                                {{ $loan->user?->student?->name ?? '-' }}
                            </td>
                            <td>
                                {{ $loan->book_id }}
                            </td>
                            <td>
                                {{ $loan->book?->title }}
                            </td>
                            <td>
                                {{ $loan->loan_date->format('d F Y') }}
                            </td>
                            <td>
                                {{ $loan->return_date->format('d F Y') }}
                            </td>
                            <td>
                                {{ $loan->duration }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@else
    <div class="card">
        <div class="card-body">
            No loan records found.
        </div>
    </div>
@endif

@endsection
