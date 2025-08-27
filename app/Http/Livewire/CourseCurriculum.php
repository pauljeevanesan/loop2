<?php

namespace App\Http\Livewire;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\QuizResult;
use App\Models\Section;
use App\Services\AzureOpenAIService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class CourseCurriculum extends Component
{
    public Course $course;
    public $sections;

    public function mount(Course $course)
    {
        $this->course = $course;
        $this->sections = Section::where('course_id', $this->course->id)->orderBy('sort')->get();
    }

    public function generateChapterContent($sectionId)
    {
        $section = Section::find($sectionId);
        if (!$section || $section->lessons()->count() > 0) {
            // Don't generate if content already exists or section not found
            return;
        }

        // --- Adaptive Logic ---
        $previousQuizScore = null;
        // Find the previous section in the course
        $previousSection = Section::where('course_id', $this->course->id)
            ->where('sort', '<', $section->sort)
            ->orderBy('sort', 'desc')
            ->first();

        if ($previousSection) {
            // Find the quiz for the previous section
            $previousQuiz = Quiz::where('section_id', $previousSection->id)->first();
            if ($previousQuiz) {
                // Find the user's latest result for that quiz
                $latestResult = QuizResult::where('quiz_id', $previousQuiz->id)
                    ->where('user_id', Auth::id())
                    ->latest()
                    ->first();
                if ($latestResult) {
                    $previousQuizScore = $latestResult->percentage;
                }
            }
        }

        // --- Call AI Service (Mocked) ---
        $aiService = new AzureOpenAIService();
        $generatedContent = $aiService->getChapterContent($this->course->title, $section->title, $previousQuizScore);

        // --- Create Lessons from AI Response ---
        if (isset($generatedContent['lessons']) && is_array($generatedContent['lessons'])) {
            foreach ($generatedContent['lessons'] as $lessonData) {
                Lesson::create([
                    'title' => $lessonData['title'],
                    'description' => $lessonData['content'],
                    'lesson_type' => $lessonData['type'],
                    'lesson_src' => $lessonData['lesson_src'],
                    'course_id' => $this->course->id,
                    'section_id' => $sectionId,
                    'user_id' => $this->course->user_id,
                ]);
            }
        }

        // Refresh the sections and their lessons
        $this->sections = Section::where('course_id', $this->course->id)->orderBy('sort')->get();
    }


    public function render()
    {
        return view('livewire.course-curriculum');
    }

    public function generateQuiz($sectionId)
    {
        $section = Section::with('lessons')->find($sectionId);

        // Check if a quiz for this section already exists
        if (Quiz::where('section_id', $sectionId)->exists()) {
            // Redirect to the existing quiz
            $quiz = Quiz::where('section_id', $sectionId)->first();
            return redirect()->route('quiz.take', ['id' => $quiz->id]); // Assuming a route name 'quiz.take'
        }

        // --- Call AI Service to generate quiz ---
        $aiService = new AzureOpenAIService();
        $chapterContent = $section->lessons->pluck('description')->implode("\n\n");
        $quizData = $aiService->getQuizContent($chapterContent);

        // --- Create Quiz and Questions from AI Response ---
        $quiz = Quiz::create([
            'course_id' => $this->course->id,
            'section_id' => $sectionId,
            'duration' => $quizData['duration_minutes'],
            'title' => $quizData['title'],
        ]);

        foreach ($quizData['questions'] as $questionData) {
            Question::create([
                'quiz_id' => $quiz->id,
                'title' => $questionData['title'],
                'options' => json_encode($questionData['options']),
                'correct_answer_index' => $questionData['correct_answer_index'],
            ]);
        }

        // Redirect to the new quiz
        return redirect()->route('quiz.take', ['id' => $quiz->id]);
    }
}
