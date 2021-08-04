<?php

namespace App\Listeners;

use App\Events\LessonWatched;
use App\Services\LessonAchievementService;

class unlockLessonAchievements
{
    private $lessonAchievementService;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(LessonAchievementService $lessonAchievementService)
    {
        $this->lessonAchievementService = $lessonAchievementService;
    }

    /**
     * Handle the event.
     *
     * @param  LessonWatched  $event
     * @return void
     */
    public function handle(LessonWatched $event)
    {
        $this->lessonAchievementService->unlock($event->user->id);
    }
}
