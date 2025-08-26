<?php

namespace App\Http\Controllers\student;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use Illuminate\Support\Facades\Auth;

class MyCertificatesController extends Controller
{
    public function index()
    {
        $page_data['certificates'] = Certificate::where('user_id', Auth::id())->latest()->get();
        $view_path                 = 'frontend.' . get_frontend_settings('theme') . '.student.my_certificates.index';
        return view($view_path, $page_data);
    }
}
