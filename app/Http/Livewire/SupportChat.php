<?php

namespace App\Http\Livewire;

use App\Models\Course;
use Livewire\Component;

class SupportChat extends Component
{
    public Course $course;
    public $conversation = [];
    public $input = '';
    public $isOpen = false;

    public function mount(Course $course)
    {
        $this->course = $course;
        $this->conversation[] = [
            'role' => 'assistant',
            'content' => 'Hello! I am your course support assistant. How can I help you with ' . $this->course->title . '?'
        ];
    }

    public function toggleChat()
    {
        $this->isOpen = !$this->isOpen;
    }

    public function sendMessage()
    {
        if (empty($this->input)) {
            return;
        }

        // Add user message to conversation
        $this->conversation[] = ['role' => 'user', 'content' => $this->input];

        // --- MOCK AI RESPONSE (as service cannot be called) ---
        $mockResponse = "Thanks for asking about '{$this->input}'. In the context of '{$this->course->title}', the answer is usually found in the core concepts. Please review the first few lessons.";
        $this->conversation[] = ['role' => 'assistant', 'content' => $mockResponse];

        // In a real implementation, you would uncomment this:
        /*
        $aiService = new \App\Services\AzureOpenAIService();
        $response = $aiService->getSupportResponse($this->input, $this->course->title);
        if ($response) {
            $this->conversation[] = ['role' => 'assistant', 'content' => $response['response']];
        } else {
            $this->conversation[] = ['role' => 'assistant', 'content' => 'Sorry, I could not process your request right now.'];
        }
        */

        $this->input = '';
    }

    public function render()
    {
        return view('livewire.support-chat');
    }
}
