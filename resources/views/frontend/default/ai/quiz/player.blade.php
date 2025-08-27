@extends('layouts.default')
@push('title', get_phrase('AI Quiz Player'))

@section('content')
    @livewire('quiz-player', ['id' => $quiz->id])
@endsection
