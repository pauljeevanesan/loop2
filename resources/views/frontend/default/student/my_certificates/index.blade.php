@extends('layouts.default')
@push('title', get_phrase('My Certificates'))
@push('meta')@endpush
@push('css')@endpush
@section('content')
    <!------------ My Certificates area start  ------------>
    <section class="course-content">
        <div class="profile-banner-area"></div>
        <div class="container profile-banner-area-container">
            <div class="row">
                @include('frontend.default.student.left_sidebar')
                <div class="col-lg-9">
                    <h4 class="g-title mb-5">{{ get_phrase('My Certificates') }}</h4>
                    <div class="my-panel">
                        @if ($certificates->count() > 0)
                            <div class="row">
                                @foreach ($certificates as $certificate)
                                    <div class="col-md-6">
                                        <div class="card mb-4">
                                            <img src="{{ asset($certificate->path) }}" class="card-img-top" alt="Certificate for {{ $certificate->course->title }}">
                                            <div class="card-body">
                                                <h5 class="card-title">{{ $certificate->course->title }}</h5>
                                                <p class="card-text">Awarded on: {{ $certificate->created_at->format('F j, Y') }}</p>
                                                <a href="{{ asset($certificate->path) }}" class="btn btn-primary" download>Download</a>
                                                <a href="{{ route('certificate.verify', ['identifier' => $certificate->identifier]) }}" class="btn btn-secondary" target="_blank">Verify</a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center">
                                <p>{{ get_phrase('You have not earned any certificates yet.') }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!------------ My Certificates area end  ------------>
@endsection
