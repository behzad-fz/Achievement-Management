<?php

namespace App\Listeners;

use App\Events\AchievementUnlocked;
use App\Services\UserService;

class UpdateBadge
{
    private $userService;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Handle the event.
     *
     * @param  AchievementUnlocked  $event
     * @return void
     */
    public function handle(AchievementUnlocked $event)
    {   
        $this->userService->updateBadge($event->user->id);
    }
}
