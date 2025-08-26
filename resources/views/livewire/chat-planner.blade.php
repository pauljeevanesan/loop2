<div>
    @if ($chatIsActive)
        <div class="chat-window mb-4" style="height: 400px; overflow-y: auto; border: 1px solid #e2e8f0; padding: 1rem; border-radius: 0.5rem;">
            @foreach ($conversation as $message)
                <div class="message mb-4">
                    <div class="font-bold @if ($message['role'] == 'user') text-blue-600 @else text-green-600 @endif">
                        {{ $message['role'] === 'assistant' ? 'AI Planner' : 'You' }}
                    </div>
                    <div class="text-gray-800">
                        {!! nl2br(e($message['content'])) !!}
                    </div>
                </div>
            @endforeach
        </div>

        <form wire:submit.prevent="sendMessage">
            <div class="flex">
                <input wire:model.defer="input" type="text" class="flex-grow border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" placeholder="Type your response..." autocomplete="off">
                <button type="submit" class="ml-4 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                    Send
                </button>
            </div>
        </form>
    @endif

    @if ($proposedPlan)
        <div class="plan-display p-6 bg-gray-50 rounded-lg">
            <h3 class="text-2xl font-bold mb-4">{{ $proposedPlan['title'] }}</h3>
            <p class="mb-4 text-gray-600"><strong>Estimated Time:</strong> {{ $proposedPlan['estimated_time'] }}</p>

            <div class="space-y-4">
                @foreach ($proposedPlan['courses'] as $course)
                    <div class="p-4 border rounded-md">
                        <h4 class="font-bold text-lg">{{ $course['title'] }}</h4>
                        <p class="text-sm text-gray-500">Duration: {{ $course['duration'] }} | Chapters: {{ $course['chapters'] }}</p>
                    </div>
                @endforeach
            </div>

            <div class="mt-6 flex justify-end space-x-4">
                <button wire:click="requestChanges" class="px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-800 uppercase tracking-widest hover:bg-gray-200">
                    Request Changes
                </button>
                <button wire:click="acceptPlan" class="px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-500">
                    Accept Plan & Create First Course
                </button>
            </div>
        </div>
    @endif
</div>
