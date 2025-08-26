<?php

namespace App\Http\Livewire;

use App\Models\Quiz;
use App\Models\Question;
use App\Models\QuizResult;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class QuizPlayer extends Component
{
    public Quiz $quiz;
    public $questions;
    public $answers = [];
    public $currentQuestionIndex = 0;
    public $quizFinished = false;
    public $score = 0;

    public function mount(Quiz $id)
    {
        $this->quiz = $id;
        $this->questions = $this->quiz->questions;
        // Initialize answers array
        foreach ($this->questions as $question) {
            $this->answers[$question->id] = null;
        }
    }

    public function selectAnswer($questionId, $optionIndex)
    {
        $this->answers[$questionId] = $optionIndex;
    }

    public function nextQuestion()
    {
        if ($this->currentQuestionIndex < $this->questions->count() - 1) {
            $this->currentQuestionIndex++;
        }
    }

    public function previousQuestion()
    {
        if ($this->currentQuestionIndex > 0) {
            $this->currentQuestionIndex--;
        }
    }

    public function submitQuiz()
    {
        $this->score = 0;
        foreach ($this->questions as $question) {
            if (isset($this->answers[$question->id]) && $this->answers[$question->id] == $question->correct_answer_index) {
                $this->score++;
            }
        }

        // Save the quiz result
        QuizResult::create([
            'user_id' => Auth::id(),
            'quiz_id' => $this->quiz->id,
            'score' => $this->score,
            'total_questions' => $this->questions->count(),
            'percentage' => ($this->score / $this->questions->count()) * 100,
        ]);

        $this->quizFinished = true;
    }

    public function render()
    {
        return view('livewire.quiz-player', [
            'currentQuestion' => $this->questions[$this->currentQuestionIndex]
        ])->layout('layouts.default'); // Using the main app layout
    }
}
