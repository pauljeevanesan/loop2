<?php

namespace App\Services;

use App\Models\User;
use App\Models\Badge;
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

    /**
     * Check all active badges and award them to the user if the criteria are met.
     *
     * @param User $user
     * @param string $actionName The action that was just performed.
     * @param Model|null $relatedModel The model related to the action.
     */
    public function checkAndAwardBadges(User $user, string $actionName, ?Model $relatedModel = null)
    {
        $badges = Badge::where('is_active', true)->where('rule_type', $actionName)->get();

        foreach ($badges as $badge) {
            // Check if user already has this badge
            if ($user->badges()->where('badge_id', $badge->id)->exists()) {
                continue;
            }

            $criteriaMet = false;
            switch ($badge->rule_type) {
                case 'perfect_quiz_score':
                    // The related model should be a QuizResult
                    if ($relatedModel instanceof \App\Models\QuizResult && $relatedModel->percentage >= 100) {
                        $criteriaMet = true;
                    }
                    break;

                case 'complete_lessons':
                    // Get the total number of completed lessons for the user across all courses.
                    $watchHistories = \App\Models\WatchHistory::where('student_id', $user->id)->get();
                    $totalCompletedLessons = 0;
                    foreach ($watchHistories as $history) {
                        $completed = json_decode($history->completed_lesson, true);
                        if (is_array($completed)) {
                            $totalCompletedLessons += count($completed);
                        }
                    }

                    if ($totalCompletedLessons >= (int)$badge->rule_value) {
                        $criteriaMet = true;
                    }
                    break;
            }

            if ($criteriaMet) {
                $user->badges()->attach($badge->id);
                // Optionally, create a notification for the user here.
            }
        }
    }
}
