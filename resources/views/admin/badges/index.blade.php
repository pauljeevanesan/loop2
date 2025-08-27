@extends('layouts.admin')

@section('title', $page_title)

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">{{ $page_title }}</h4>
                    <a href="{{ route('badges.create') }}" class="btn btn-primary">Create New Badge</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Rule</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($badges as $badge)
                                    <tr>
                                        <td>
                                            <img src="{{ asset($badge->image_path) }}" alt="{{ $badge->name }}" width="50">
                                        </td>
                                        <td>{{ $badge->name }}</td>
                                        <td>{{ $badge->description }}</td>
                                        <td>{{ $badge->rule_type }} ({{ $badge->rule_value }})</td>
                                        <td>
                                            <a href="{{ route('badges.edit', $badge) }}" class="btn btn-sm btn-info">Edit</a>
                                            <form action="{{ route('badges.destroy', $badge) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">No badges created yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
