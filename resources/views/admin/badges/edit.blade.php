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
                    <form action="{{ route('badges.update', $badge) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="name" class="form-label">Badge Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ $badge->name }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3" required>{{ $badge->description }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Badge Image</label>
                            <div class="mb-2">
                                <img src="{{ asset($badge->image_path) }}" alt="{{ $badge->name }}" width="100">
                            </div>
                            <input class="form-control" type="file" id="image" name="image" accept="image/png, image/jpeg, image/svg+xml">
                            <small class="form-text text-muted">Upload a new image to replace the existing one.</small>
                        </div>
                        <div class="mb-3">
                            <label for="rule_type" class="form-label">Rule Type</label>
                            <select class="form-select" id="rule_type" name="rule_type" required>
                                <option value="complete_lessons" @if($badge->rule_type == 'complete_lessons') selected @endif>Complete X Lessons</option>
                                <option value="perfect_quiz_score" @if($badge->rule_type == 'perfect_quiz_score') selected @endif>Achieve 100% on a Quiz</option>
                                {{-- Add other rule types here as they are implemented --}}
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="rule_value" class="form-label">Rule Value</label>
                            <input type="number" class="form-control" id="rule_value" name="rule_value" value="{{ $badge->rule_value }}" required placeholder="e.g., 10 for lessons, or 1 for perfect score">
                            <small class="form-text text-muted">For 'Complete X Lessons', this is the number of lessons. For 'Perfect Quiz Score', this value can be set to 1 (as in, 1 perfect score).</small>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Badge</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
