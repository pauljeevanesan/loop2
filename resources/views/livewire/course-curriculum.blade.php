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
                                            <li>
                                                {{-- Display Lesson --}}
                                                <a href="javascript:void(0);" class="d-flex justify-content-between align-items-center">
                                                    <p class="d-flex">
                                                        <svg class="mt-0" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M8.87508 13.1253L12.9376 10.5212C13.132 10.3962 13.2292 10.2225 13.2292 10.0003C13.2292 9.7781 13.132 9.60449 12.9376 9.47949L8.87508 6.87533C8.66675 6.73644 8.45494 6.72602 8.23966 6.84408C8.02439 6.96213 7.91675 7.14616 7.91675 7.39616V12.6045C7.91675 12.8545 8.02439 13.0385 8.23966 13.1566C8.45494 13.2746 8.66675 13.2642 8.87508 13.1253ZM10.0001 18.3337C8.8473 18.3337 7.76397 18.1149 6.75008 17.6774C5.73619 17.2399 4.85425 16.6462 4.10425 15.8962C3.35425 15.1462 2.7605 14.2642 2.323 13.2503C1.8855 12.2364 1.66675 11.1531 1.66675 10.0003C1.66675 8.84755 1.8855 7.76421 2.323 6.75033C2.7605 5.73644 3.35425 4.85449 4.10425 4.10449C4.85425 3.35449 5.73619 2.76074 6.75008 2.32324C7.76397 1.88574 8.8473 1.66699 10.0001 1.66699C11.1529 1.66699 12.2362 1.88574 13.2501 2.32324C14.264 2.76074 15.1459 3.35449 15.8959 4.10449C16.6459 4.85449 17.2397 5.73644 17.6772 6.75033C18.1147 7.76421 18.3334 8.84755 18.3334 10.0003C18.3334 11.1531 18.1147 12.2364 17.6772 13.2503C17.2397 14.2642 16.6459 15.1462 15.8959 15.8962C15.1459 16.6462 14.264 17.2399 13.2501 17.6774C12.2362 18.1149 11.1529 18.3337 10.0001 18.3337ZM10.0001 16.667C11.8612 16.667 13.4376 16.0212 14.7292 14.7295C16.0209 13.4378 16.6667 11.8614 16.6667 10.0003C16.6667 8.13921 16.0209 6.56283 14.7292 5.27116C13.4376 3.97949 11.8612 3.33366 10.0001 3.33366C8.13897 3.33366 6.56258 3.97949 5.27091 5.27116C3.97925 6.56283 3.33341 8.13921 3.33341 10.0003C3.33341 11.8614 3.97925 13.4378 5.27091 14.7295C6.56258 16.0212 8.13897 16.667 10.0001 16.667Z" fill="#192335" />
                                                        </svg>
                                                        {{ ucfirst($lesson->title) }} ({{ $lesson->lesson_type }})
                                                    </p>
                                                </a>
                                            </li>
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
