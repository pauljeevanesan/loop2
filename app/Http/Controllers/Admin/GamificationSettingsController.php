<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GamificationSetting;
use Illuminate\Http\Request;

class GamificationSettingsController extends Controller
{
    public function index()
    {
        $page_data['settings'] = GamificationSetting::all()->keyBy('action_name');
        $page_data['page_title'] = 'Gamification Settings';
        return view('admin.gamification.settings', $page_data);
    }

    public function update(Request $request)
    {
        foreach ($request->settings as $action_name => $values) {
            GamificationSetting::where('action_name', $action_name)->update([
                'points' => (int) $values['points'],
                'is_active' => isset($values['is_active']) ? 1 : 0,
            ]);
        }

        Session::flash('success', 'Gamification settings updated successfully.');
        return redirect()->back();
    }
}
