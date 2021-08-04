<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Facades\UserActivity;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'unlocked_achievements' => $this->achievements()->pluck('name')->toArray(),
            'next_available_achievements' => UserActivity::nextAvailableAchievements($this->id),
            'current_badge' => UserActivity::currentBadge($this->id),
            'next_badge' => UserActivity::nextBadge($this->id),
            'remaining_to_unlock_next_badge' => UserActivity::remainingToUnlockNextBadge($this->id)
        ];
    }
}
