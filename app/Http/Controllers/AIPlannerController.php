<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AIPlannerController extends Controller
{
    /**
     * Display the AI course planner page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('ai.planner');
    }
}
