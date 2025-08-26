<?php

namespace App\Services;

use App\Models\User;
use App\Models\GamificationSetting;
use App\Models\PointTransaction;
use Illuminate\Database\Eloquent\Model;

class GamificationService
{
    /**
     * Award points to a user for a specific action.
     *
     * @param User $user
     * @param string $actionName The name of the action (e.g., 'pass_quiz').
     * @param Model $relatedModel The model that triggered the action (e.g., a QuizResult).
     */
    public function awardPoints(User $user, string $actionName, Model $relatedModel)
    {
        // 1. Find the setting for this action
        $setting = GamificationSetting::where('action_name', $actionName)->where('is_active', true)->first();

        if (!$setting || $setting->points == 0) {
            // Rule is not active or has no points, so do nothing.
            return;
        }

        // 2. Award the points
        $user->points += $setting->points;
        $user->save();

        // 3. Create a transaction log
        PointTransaction::create([
            'user_id' => $user->id,
            'points' => $setting->points,
            'reason' => $setting->display_name,
            'related_type' => get_class($relatedModel),
            'related_id' => $relatedModel->id,
        ]);
    }
}
