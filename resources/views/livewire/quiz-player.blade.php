<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h2 class="g-title">{{ $quiz->title }}</h2>
                </div>
                <div class="card-body">
                    @if ($quizFinished)
                        {{-- Quiz Finished State --}}
                        <div class="text-center">
                            <h3 class="g-title">Quiz Completed!</h3>
                            <p class="lead">Your Score: <strong>{{ $score }}</strong> out of <strong>{{ $questions->count() }}</strong></p>
                            <p class="text-muted">You have scored {{ number_format(($score / $questions->count()) * 100, 2) }}%</p>
                            <hr>
                            <a href="{{ route('course.details', ['slug' => $quiz->course->slug]) }}" class="btn btn-primary mt-3">
                                Back to Course
                            </a>
                        </div>
                    @else
                        {{-- Quiz In Progress State --}}
                        <div>
                            {{-- Question Title --}}
                            <p class="lead mb-4">Question {{ $currentQuestionIndex + 1 }} of {{ $questions->count() }}</p>
                            <h4 class="g-title mb-4">{{ $currentQuestion->title }}</h4>

                            {{-- Options --}}
                            <div class="list-group">
                                @foreach (json_decode($currentQuestion->options) as $index => $option)
                                    <button
                                        type="button"
                                        class="list-group-item list-group-item-action @if(isset($answers[$currentQuestion->id]) && $answers[$currentQuestion->id] == $index) active @endif"
                                        wire:click="selectAnswer({{ $currentQuestion->id }}, {{ $index }})"
                                    >
                                        {{ $option }}
                                    </button>
                                @endforeach
                            </div>

                            {{-- Navigation --}}
                            <div class="d-flex justify-content-between mt-4">
                                @if ($currentQuestionIndex > 0)
                                    <button class="btn btn-secondary" wire:click="previousQuestion">Previous</button>
                                @else
                                    <span></span> {{-- To keep the "Next" button on the right --}}
                                @endif

                                @if ($currentQuestionIndex < $questions->count() - 1)
                                    <button class="btn btn-primary" wire:click="nextQuestion">Next</button>
                                @else
                                    <button class="btn btn-success" wire:click="submitQuiz">Submit Quiz</button>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
