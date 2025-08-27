<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\User;

class LeaderboardController extends Controller
{
    public function index()
    {
        $page_data['users'] = User::where('role', 'student')
            ->orderBy('points', 'desc')
            ->take(50)
            ->get();

        $view_path = 'frontend.' . get_frontend_settings('theme') . '.leaderboard.index';
        return view($view_path, $page_data);
    }
}
