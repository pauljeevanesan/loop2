@extends('layouts.admin')

@section('title', $page_title)

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ $page_title }}</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('badges.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Badge Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Badge Image</label>
                            <input class="form-control" type="file" id="image" name="image" required accept="image/png, image/jpeg, image/svg+xml">
                        </div>
                        <div class="mb-3">
                            <label for="rule_type" class="form-label">Rule Type</label>
                            <select class="form-select" id="rule_type" name="rule_type" required>
                                <option value="complete_lessons">Complete X Lessons</option>
                                <option value="perfect_quiz_score">Achieve 100% on a Quiz</option>
                                {{-- Add other rule types here as they are implemented --}}
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="rule_value" class="form-label">Rule Value</label>
                            <input type="number" class="form-control" id="rule_value" name="rule_value" required placeholder="e.g., 10 for lessons, or 1 for perfect score">
                            <small class="form-text text-muted">For 'Complete X Lessons', this is the number of lessons. For 'Perfect Quiz Score', this value can be set to 1 (as in, 1 perfect score).</small>
                        </div>
                        <button type="submit" class="btn btn-primary">Create Badge</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
