<?php

namespace App\Http\Livewire;

use App\Models\Quiz;
use App\Models\Question;
use App\Models\QuizResult;
use App\Http\Controllers\CertificateController;
use App\Services\GamificationService;
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
        $quizResult = QuizResult::create([
            'user_id' => Auth::id(),
            'quiz_id' => $this->quiz->id,
            'score' => $this->score,
            'total_questions' => $this->questions->count(),
            'percentage' => ($this->score / $this->questions->count()) * 100,
        ]);

        // Award points for passing the quiz
        // We can add a "pass percentage" check here later if needed.
        $gamificationService = new GamificationService();
        $gamificationService->awardPoints(Auth::user(), 'pass_quiz', $quizResult);

        $this->quizFinished = true;

        // --- Certificate Generation Logic ---
        $course = $this->quiz->course;
        $lastSection = $course->sections()->orderBy('sort', 'desc')->first();

        // Check if this is the quiz for the last section of the course
        if ($lastSection && $this->quiz->section_id == $lastSection->id) {
            // Check if user has already been awarded a certificate for this course
            $existingCertificate = \App\Models\Certificate::where('user_id', Auth::id())->where('course_id', $course->id)->exists();

            if (!$existingCertificate) {
                // For now, we award it regardless of score. This can be changed later.
                $certificateController = new CertificateController();
                $certificate = $certificateController->generate(Auth::user(), $course);

                // We'll need a page to show the new certificate.
                // For now, the result page will have to do.
                // In the next step, we can create a dedicated page.
            }
        }
    }

    public function render()
    {
        return view('livewire.quiz-player', [
            'currentQuestion' => $this->questions[$this->currentQuestionIndex]
        ])->layout('layouts.default'); // Using the main app layout
    }
}
