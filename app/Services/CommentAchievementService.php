<?php

namespace App\Services;

use App\Models\User;
use App\Events\AchievementUnlocked;
use App\Interfaces\AchievementInterface;
use Illuminate\Database\Eloquent\Model;

class CommentAchievementService implements AchievementInterface
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
     * CommentAchievementService constructor.
     *
     * @param Model $userModel
     * @param array $achievements
     */
    public function __construct(User $userModel, array $achievements)
    {
        $this->userModel = $userModel;
        $this->achievements = $achievements;
    }

    public function unlock($userId)
    {
        if (! $user = $this->userModel->find($userId)) {
            abort(404);
        }

        foreach ($this->achievements as $achievementName => $achievementCondition) {
            if ($user->comments()->count() >= $achievementCondition['number_of_comments_to_unlock']) {
                if (! $user->achievements()->where('name', $achievementName)->first()) {
                    $user->achievements()->create([
                        'name' => $achievementName,
                        'achievable_type' => 'App\Models\Comment',
                        'achievable_count' => $achievementCondition['number_of_comments_to_unlock'],
                    ]);
            
                    AchievementUnlocked::dispatch($achievementName, $user);
                }
            }
        }
    }
}
