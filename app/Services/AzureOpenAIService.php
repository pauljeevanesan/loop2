<?php

namespace App\Services;

class AzureOpenAIService
{
    /**
     * Simulates a call to the OpenAI API to get a course plan.
     * In a real implementation, this would interact with the OpenAI client.
     *
     * @param array $conversationHistory
     * @return array
     */
    public function getCoursePlan(array $conversationHistory): array
    {
        // This is a mock response. It simulates the AI returning a structured learning plan.
        $lastMessage = strtolower(end($conversationHistory)['content']);

        // --- Mock Conversation Flow ---

        // 1. Check for time commitment to trigger final plan
        if (str_contains($lastMessage, 'hours') || str_contains($lastMessage, 'minutes')) {
            return $this->getFinalPlan();
        }

        // 2. Check for goals to ask about time
        if (str_contains($lastMessage, 'project') || str_contains($lastMessage, 'career') || str_contains($lastMessage, 'hobby')) {
            return [
                'status' => 'in_progress',
                'response' => 'Great! And how much time can you commit to learning per week?'
            ];
        }

        // 3. Check for experience level to ask about goals
        if (str_contains($lastMessage, 'beginner') || str_contains($lastMessage, 'intermediate') || str_contains($lastMessage, 'advanced')) {
             return [
                'status' => 'in_progress',
                'response' => 'Understood. What is your main goal for learning this? (e.g., a specific project, career growth, hobby)'
            ];
        }

        // 4. Default first question
        return [
            'status' => 'in_progress',
            'response' => 'To get started, could you tell me about your current experience level? (e.g., beginner, intermediate, advanced)'
        ];
    }

    /**
     * The system prompt that would be sent to the real AI.
     * @return string
     */
    private function getSystemPrompt(): string
    {
        return <<<PROMPT
You are StudAI Loop, an expert AI course planner. Your goal is to have a short, friendly conversation with the user to understand their learning needs.

1.  First, ask about their experience level (beginner, intermediate, advanced).
2.  Second, ask about their primary goal (career, project, hobby, etc.).
3.  Third, ask about their time commitment (e.g., hours per week).
4.  Once you have this information, you MUST respond with a JSON object that follows this exact structure: {"status": "plan_ready", "plan": { ... }}.
5.  The plan should contain a title, an estimated total time, and a list of courses. Each course should have a title, duration, and number of chapters.

Do not deviate from this flow. Keep your conversational responses short and to the point.
PROMPT;
    }

    /**
     * Generates the final mock plan.
     * @return array
     */
    private function getFinalPlan(): array
    {
        return [
            'status' => 'plan_ready',
            'plan' => [
                'title' => 'Custom AI-Generated Path',
                'estimated_time' => 'Approx. 3 months',
                'courses' => [
                    [
                        'title' => 'Introduction to Python for AI',
                        'duration' => '4 weeks',
                        'chapters' => 5,
                    ],
                    [
                        'title' => 'Core Machine Learning Concepts',
                        'duration' => '6 weeks',
                        'chapters' => 5,
                    ],
                    [
                        'title' => 'Building Your First AI Application',
                        'duration' => '2 weeks',
                        'chapters' => 5,
                    ],
                ]
            ]
        ];
    }

    /**
     * Simulates a call to the OpenAI API to get chapter content.
     * @param string $courseTitle
     * @param string $chapterTitle
     * @param float|null $previousQuizScore
     * @return array
     */
    public function getChapterContent(string $courseTitle, string $chapterTitle, ?float $previousQuizScore = null): array
    {
        $baseContent = 'This is the core learning text for ' . $chapterTitle . '. We will explore the fundamental ideas and theories.';
        $analogy = 'Think of it like building with LEGOs. The concepts you just learned are the individual bricks...';

        // --- Simulate Adaptive Content ---
        if ($previousQuizScore !== null) {
            if ($previousQuizScore < 70) {
                // User struggled, provide more foundational content
                $baseContent = 'It seems you had some trouble with the last chapter, so let\'s review. ' . $baseContent . ' We will take it slow and focus on the basics.';
                $analogy = 'Let\'s use a simpler analogy. Imagine baking a cake. Each ingredient is a concept...';
            } else {
                // User did well, provide more advanced content
                $baseContent = 'You did great on the last quiz! Let\'s move on to some more advanced topics in ' . $chapterTitle . '.';
            }
        }

        // This is a mock response.
        return [
            'lessons' => [
                [
                    'title' => 'Understanding Core Concepts',
                    'type' => 'text',
                    'lesson_src' => null,
                    'content' => $baseContent,
                ],
                [
                    'title' => 'A Real-World Analogy',
                    'type' => 'analogy',
                    'lesson_src' => null,
                    'content' => $analogy,
                ],
                [
                    'title' => 'Curated Video Explanation',
                    'type' => 'video',
                    'lesson_src' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', // Placeholder video
                    'content' => 'This handpicked video provides a great visual explanation of the concepts we are discussing. Watch it to solidify your understanding.',
                ],
                [
                    'title' => 'Find an Infographic',
                    'type' => 'infographic_link',
                    'lesson_src' => 'https://example.com/infographic.png',
                    'content' => 'This link contains a helpful infographic that summarizes the key points.',
                ],
                [
                    'title' => 'Your Next Project',
                    'type' => 'project',
                    'lesson_src' => null,
                    'content' => 'Based on your progress, your next task is to enhance the previous project with new concepts from this chapter.',
                ],
            ]
        ];
    }

    /**
     * Simulates a call to the OpenAI API to get quiz content.
     * @param string $chapterContent
     * @return array
     */
    public function getQuizContent(string $chapterContent): array
    {
        // This is a mock response. It ignores the chapter content for now.
        return [
            'title' => 'Chapter Quiz',
            'duration_minutes' => 10,
            'questions' => [
                [
                    'title' => 'What is the main topic of this chapter?',
                    'options' => ['Topic A', 'Topic B', 'Core Concepts', 'Topic D'],
                    'correct_answer_index' => 2,
                ],
                [
                    'title' => 'Which analogy was used in this chapter?',
                    'options' => ['Building a house', 'Cooking a meal', 'Building with LEGOs', 'Driving a car'],
                    'correct_answer_index' => 2,
                ],
                [
                    'title' => 'What is the goal of the mini-project?',
                    'options' => ['To build a complex system', 'To apply learned concepts', 'To write a report', 'To design a UI'],
                    'correct_answer_index' => 1,
                ],
            ]
        ];
    }
}
