@extends('layouts.default')
@push('title', 'Certificate of Completion')

@push('meta')
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="Certificate of Completion: {{ $certificate->course->title }}">
    <meta property="og:description" content="{{ $certificate->user->name }} has successfully completed the course '{{ $certificate->course->title }}' on {{ $certificate->created_at->format('F j, Y') }}.">
    <meta property="og:image" content="{{ asset($certificate->path) }}">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="Certificate of Completion: {{ $certificate->course->title }}">
    <meta property="twitter:description" content="{{ $certificate->user->name }} has successfully completed the course '{{ $certificate->course->title }}' on {{ $certificate->created_at->format('F j, Y') }}.">
    <meta property="twitter:image" content="{{ asset($certificate->path) }}">
@endpush

@section('content')
<section class="breadcum-area page-content-pb-100 bg-white">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="text-center">
                    <h1 class="g-title">Certificate Verification</h1>
                    <p class="g-text">This certificate is authentic and was issued by StudAI Loop.</p>
                </div>

                <div class="card mt-5">
                    <div class="card-body text-center">
                        <h2 class="g-title">{{ $certificate->course->title }}</h2>
                        <p class="lead">This is to certify that</p>
                        <h3 class="my-3">{{ $certificate->user->name }}</h3>
                        <p>has successfully completed the course on <strong>{{ $certificate->created_at->format('F j, Y') }}</strong>.</p>
                        <hr>
                        <p><strong>Performance Score:</strong> {{ $performanceScore }}%</p>
                        <p class="text-muted">Identifier: {{ $certificate->identifier }}</p>
                    </div>
                </div>

                <div class="text-center mt-4">
                     <img src="{{ asset($certificate->path) }}" alt="Certificate Image" class="img-fluid shadow-lg">
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
