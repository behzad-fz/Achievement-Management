<?php

namespace App\Services;

use App\Events\BadgeUnlocked;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class UserService
{
    /**
     * @var Model
     */
    private Model $userModel;

    /**
     * @var array
     */
    private array $achievements;

    /**
     * @var array
     */
    private array $badges;

    /**
     * UserService constructor.
     *
     * @param Model $userModel
     * 
     * @param array $achievements
     * 
     * @param array $badges
     */
    public function __construct(User $userModel, array $achievements, array $badges)
    {
        $this->userModel = $userModel;
        $this->achievements = $achievements;
        $this->badges = $badges;

    }

    public function nextAvailableAchievements($userId)
    {
        $user = $this->find($userId);

        return array_filter([$this->nextCommentAchievement($user), $this->nextLessonAchievement($user)],'strlen');
    }

    public function currentBadge($userId)
    {
        $user = $this->find($userId);

        foreach (array_reverse($this->badges) as $badgeName => $badgeCondition) {
            if ($user->achievements()->count() >= $badgeCondition['number_of_achievements_to_unlock']) {
                return $badgeName;
            }
        }
    }

    public function nextBadge($userId)
    {
        $user = $this->find($userId);
        $badges = array_keys($this->badges);
        $current = array_search($this->currentBadge($user->id), $badges);
        return isset($badges[$current + 1]) ? $badges[$current + 1] : null;
    }
 
    public function remainingToUnlockNextBadge($userId)
    {
        $user = $this->find($userId);

        if (! $nextBadge = $this->nextBadge($user->id)) {
            return 0;
        }

        return $this->badges[$nextBadge]['number_of_achievements_to_unlock'] - $user->achievements()->count();
    }

    public function updateBadge($userId)
    {
        $user = $this->find($userId);

        $userCurrentBadge = $this->currentBadge($user->id);

        if ($userCurrentBadge != $user->badge) {
            $user->update(['badge' => $userCurrentBadge]);

            BadgeUnlocked::dispatch($userCurrentBadge, $user);
        }
    }

    private function find($userId)
    {
        if (! $user = $this->userModel->find($userId)) {
            abort(404);
        }

        return $user;
    }

    private function latestCommentAchievement(User $user)
    {
        return optional($user->commentWrittenAchievements()->orderByDesc('achievable_count')->first())->name;
    }

    private function nextCommentAchievement(User $user)
    {
        $achievements = array_keys($this->achievements['comment_written']);
        $current = array_search($this->latestCommentAchievement($user), $achievements) ?: -1;
        return isset($achievements[$current + 1]) ? $achievements[$current + 1] : null;
    }

    private function latestLessonAchievement(User $user)
    {
        return optional($user->lessonWatchedAchievements()->orderByDesc('achievable_count')->first())->name;
    }

    private function nextLessonAchievement(User $user)
    {
        $achievements = array_keys($this->achievements['lesson_watched']);
        $current = array_search($this->latestLessonAchievement($user), $achievements) ?: -1;
        return isset($achievements[$current + 1]) ? $achievements[$current + 1] : null;
    }
}
