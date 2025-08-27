@extends('layouts.default')
@push('title', 'Badge Unlocked: ' . $userBadge->badge->name)

@push('meta')
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="{{ $userBadge->user->name }} earned the '{{ $userBadge->badge->name }}' badge!">
    <meta property="og:description" content="{{ $userBadge->badge->description }}">
    <meta property="og:image" content="{{ asset($userBadge->badge->image_path) }}">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="{{ $userBadge->user->name }} earned the '{{ $userBadge->badge->name }}' badge!">
    <meta property="twitter:description" content="{{ $userBadge->badge->description }}">
    <meta property="twitter:image" content="{{ asset($userBadge->badge->image_path) }}">
@endpush

@section('content')
<section class="breadcum-area page-content-pb-100 bg-white">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 text-center">
                <h1 class="g-title">Badge Unlocked!</h1>
                <div class="card mt-5">
                    <div class="card-body">
                        <img src="{{ asset($userBadge->badge->image_path) }}" alt="{{ $userBadge->badge->name }}" class="img-fluid mb-4" style="max-height: 250px;">
                        <h2 class="g-title">{{ $userBadge->badge->name }}</h2>
                        <p class="lead">This badge was awarded to</p>
                        <h3 class="my-3">{{ $userBadge->user->name }}</h3>
                        <p>on <strong>{{ $userBadge->awarded_at->format('F j, Y') }}</strong> for successfully completing the requirement: "{{ $userBadge->badge->description }}"</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
