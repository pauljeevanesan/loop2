@extends('layouts.default')
@push('title', get_phrase('My Badges'))
@push('meta')@endpush
@push('css')@endpush
@section('content')
    <!------------ My Badges area start  ------------>
    <section class="course-content">
        <div class="profile-banner-area"></div>
        <div class="container profile-banner-area-container">
            <div class="row">
                @include('frontend.default.student.left_sidebar')
                <div class="col-lg-9">
                    <h4 class="g-title mb-5">{{ get_phrase('My Badges') }}</h4>
                    <div class="my-panel">
                        @if ($badges->count() > 0)
                            <div class="row">
                                @foreach ($badges as $badge)
                                    <div class="col-md-4 text-center">
                                        <div class="card mb-4">
                                            <img src="{{ asset($badge->image_path) }}" class="card-img-top p-4" alt="{{ $badge->name }}" style="max-height: 200px; object-fit: contain;">
                                            <div class="card-body">
                                                <h5 class="card-title">{{ $badge->name }}</h5>
                                                <p class="card-text">{{ $badge->description }}</p>
                                                <small class="text-muted">Awarded on: {{ $badge->pivot->awarded_at->format('F j, Y') }}</small>
                                                <a href="{{ route('badge.share', ['id' => $badge->pivot->id]) }}" class="btn btn-sm btn-outline-primary mt-2" target="_blank">Share</a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center">
                                <p>{{ get_phrase('You have not earned any badges yet.') }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!------------ My Badges area end  ------------>
@endsection
