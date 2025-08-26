<?php

namespace App\Http\Controllers\student;

use App\Http\Controllers\Controller;
use App\Models\PointTransaction;
use Illuminate\Support\Facades\Auth;

class PointHistoryController extends Controller
{
    public function index()
    {
        $page_data['transactions'] = PointTransaction::where('user_id', Auth::id())->latest()->paginate(10);
        $view_path                 = 'frontend.' . get_frontend_settings('theme') . '.student.point_history.index';
        return view($view_path, $page_data);
    }
}
