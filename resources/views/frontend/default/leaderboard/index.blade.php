@extends('layouts.default')
@push('title', get_phrase('Leaderboard'))

@section('content')
<section class="breadcum-area page-content-pb-100 bg-white">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="text-center">
                    <h1 class="g-title">Top Learners Leaderboard</h1>
                    <p class="g-text">See who is leading the pack in the StudAI Loop community!</p>
                </div>

                <div class="card mt-5">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">Rank</th>
                                        <th scope="col">Learner</th>
                                        <th scope="col">Points</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($users as $key => $user)
                                        <tr>
                                            <th scope="row">#{{ $key + 1 }}</th>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img src="{{ get_image($user->photo) }}" class="rounded-circle me-2" width="30" height="30">
                                                    <span>{{ $user->name }}</span>
                                                </div>
                                            </td>
                                            <td><strong>{{ $user->points }}</strong></td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center">The leaderboard is empty. Start learning to get on the board!</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
