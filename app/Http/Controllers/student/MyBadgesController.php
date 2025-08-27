<?php

namespace App\Http\Controllers\student;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class MyBadgesController extends Controller
{
    public function index()
    {
        $page_data['badges'] = Auth::user()->badges()->latest()->get();
        $view_path           = 'frontend.' . get_frontend_settings('theme') . '.student.my_badges.index';
        return view($view_path, $page_data);
    }
}
