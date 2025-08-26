<?php

namespace App\Services;

class OpenAIService
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
}
