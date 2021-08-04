<?php

namespace App\Listeners;

use App\Events\CommentWritten;
use App\Services\CommentAchievementService;

class unlockCommentAchievements
{
    private $commentAchievementService;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(CommentAchievementService $commentAchievementService)
    {
        $this->commentAchievementService = $commentAchievementService;
    }

    /**
     * Handle the event.
     *
     * @param  CommentWritten  $event
     * @return void
     */
    public function handle(CommentWritten $event)
    {
        $this->commentAchievementService->unlock($event->comment->user_id);
    }
}
