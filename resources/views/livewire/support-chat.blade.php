<div style="position: fixed; bottom: 20px; right: 20px; z-index: 1000;">
    @if ($isOpen)
        {{-- Chat Window --}}
        <div class="card" style="width: 350px; height: 500px; display: flex; flex-direction: column;">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Course Support</span>
                <button type="button" class="btn-close" wire:click="toggleChat"></button>
            </div>
            <div class="card-body" style="flex-grow: 1; overflow-y: auto;">
                @foreach ($conversation as $message)
                    <div class="message mb-3">
                    <div class="font-bold @if($message['role'] == 'user') text-primary @else text-dark @endif d-flex align-items-center">
                        <span>{{ $message['role'] === 'assistant' ? 'Support Bot' : 'You' }}</span>
                        @if ($message['role'] === 'assistant')
                            <button onclick="studaiTtsService.speak(this.closest('.message').querySelector('.message-content').textContent)" class="btn btn-sm btn-outline-secondary ms-2">
                                <i class="fas fa-volume-up"></i>
                            </button>
                        @endif
                        </div>
                    <div class="text-muted message-content">
                            {!! nl2br(e($message['content'])) !!}
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="card-footer">
                <form wire:submit.prevent="sendMessage">
                    <div class="input-group">
                        <input type="text" wire:model.defer="input" class="form-control" placeholder="Ask a question...">
                        <button class="btn btn-primary" type="submit">Send</button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    {{-- Chat Toggle Button --}}
    <button wire:click="toggleChat" class="btn btn-primary btn-lg rounded-circle" style="width: 60px; height: 60px;">
        <i class="fas fa-comment-dots"></i>
    </button>
</div>
