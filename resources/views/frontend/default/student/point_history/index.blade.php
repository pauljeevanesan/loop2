@extends('layouts.default')
@push('title', get_phrase('Points History'))
@push('meta')@endpush
@push('css')@endpush
@section('content')
    <!------------ Points History area start  ------------>
    <section class="course-content">
        <div class="profile-banner-area"></div>
        <div class="container profile-banner-area-container">
            <div class="row">
                @include('frontend.default.student.left_sidebar')
                <div class="col-lg-9">
                    <h4 class="g-title mb-5">{{ get_phrase('Points History') }}</h4>
                    <div class="my-panel">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Reason</th>
                                        <th>Points</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($transactions as $key => $transaction)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $transaction->reason }}</td>
                                            <td>
                                                @if ($transaction->points > 0)
                                                    <span class="text-success">+{{ $transaction->points }}</span>
                                                @else
                                                    <span class="text-danger">{{ $transaction->points }}</span>
                                                @endif
                                            </td>
                                            <td>{{ $transaction->created_at->format('d M, Y') }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center">{{ get_phrase('No transactions found.') }}</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-end">
                            {{ $transactions->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!------------ Points History area end  ------------>
@endsection
