<?php

namespace App\Providers;

use App\Events\AchievementUnlocked;
use App\Events\LessonWatched;
use App\Events\CommentWritten;
use App\Listeners\unlockCommentAchievements;
use App\Listeners\unlockLessonAchievements;
use App\Listeners\UpdateBadge;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        CommentWritten::class => [
            unlockCommentAchievements::class
        ],
        LessonWatched::class => [
            unlockLessonAchievements::class
        ],
        AchievementUnlocked::class => [
            UpdateBadge::class
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
