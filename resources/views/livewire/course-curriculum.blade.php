<div class="ps-box p-0 shadow-none">
    <h4 class="g-title mb-15">{{ get_phrase('Course curriculum') }}</h4>
    <div class="lesson-play-list p-0">
        @if ($sections->count() > 0)
            <div class="accordion" id="accordionExample">
                @foreach ($sections as $key => $section)
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button @if($key > 0) collapsed @endif" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_{{ $section->id }}" aria-expanded="@if($key == 0) true @else false @endif" aria-controls="collapse_{{ $section->id }}">{{ ucfirst($section->title) }}
                            </button>
                        </h2>
                        <div id="collapse_{{ $section->id }}" class="accordion-collapse collapse @if($key == 0) show @endif" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                @if ($section->lessons->count() > 0)
                                    <ul class="lesson-list course_list">
                                        @foreach ($section->lessons as $lesson)
                                            <div class="border-bottom py-3">
                                                <p class="d-flex my-2">
                                                    @if ($lesson->lesson_type == 'video')
                                                        <i class="fas fa-video me-2"></i>
                                                    @else
                                                        <i class="fas fa-file-alt me-2"></i>
                                                    @endif
                                                    {{ ucfirst($lesson->title) }}
                                                    <span class="badge bg-secondary ms-2">{{ $lesson->lesson_type }}</span>
                                                </p>

                                                <div class="lesson-content">
                                                    @if ($lesson->lesson_type == 'video' && $lesson->lesson_src)
                                                        @php
                                                            // Basic parser for YouTube URL
                                                            $videoId = null;
                                                            if (str_contains($lesson->lesson_src, 'watch?v=')) {
                                                                parse_str(parse_url($lesson->lesson_src, PHP_URL_QUERY), $query);
                                                                $videoId = $query['v'] ?? null;
                                                            }
                                                        @endphp
                                                        @if ($videoId)
                                                            <div class="ratio ratio-16x9">
                                                                <iframe src="https://www.youtube.com/embed/{{ $videoId }}" title="{{ $lesson->title }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                                            </div>
                                                        @else
                                                            <p class="text-danger">Could not parse video URL.</p>
                                                        @endif
                                                        <p class="mt-2">{{ $lesson->description }}</p>
                                                    @else
                                                        <p>{{ $lesson->description }}</p>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </ul>

                                    <div class="text-center p-4 border-top mt-3">
                                        <button wire:click="generateQuiz({{ $section->id }})" class="btn btn-success">
                                            <span wire:loading.remove wire:target="generateQuiz({{ $section->id }})">
                                                <i class="fas fa-question-circle"></i> Take Chapter Quiz
                                            </span>
                                            <span wire:loading wire:target="generateQuiz({{ $section->id }})">
                                                Generating Quiz... <i class="fas fa-spinner fa-spin"></i>
                                            </span>
                                        </button>
                                    </div>

                                @else
                                    {{-- Generate Content Button --}}
                                    <div class="text-center p-4">
                                        <p class="text-muted mb-3">This chapter has no content yet.</p>
                                        <button wire:click="generateChapterContent({{ $section->id }})" class="btn btn-primary">
                                            <span wire:loading.remove wire:target="generateChapterContent({{ $section->id }})">
                                                <i class="fas fa-magic"></i> Generate Content for this Chapter
                                            </span>
                                            <span wire:loading wire:target="generateChapterContent({{ $section->id }})">
                                                Generating... <i class="fas fa-spinner fa-spin"></i>
                                            </span>
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-center">{{ get_phrase('Course curriculum Empty') }}</p>
        @endif
    </div>
</div>
