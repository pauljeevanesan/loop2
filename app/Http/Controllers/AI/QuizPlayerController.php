<?php

namespace App\Http\Controllers\AI;

use App\Http\Controllers\Controller;
use App\Models\Quiz;

class QuizPlayerController extends Controller
{
    public function show(Quiz $id)
    {
        $page_data['quiz'] = $id;
        $view_path = 'frontend.' . get_frontend_settings('theme') . '.ai.quiz.player';
        return view($view_path, $page_data);
    }
}
