<?php

namespace App\Providers;

use App\Models\User;
use App\Services\CommentAchievementService;
use App\Services\LessonAchievementService;
use App\Services\UserService;
use Illuminate\Support\ServiceProvider;

class CustomServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(CommentAchievementService::class, function ($app) {
            return new CommentAchievementService($app->make(User::class), config('achievements.comment_written'));
        });

        $this->app->bind(LessonAchievementService::class, function ($app) {
            return new LessonAchievementService($app->make(User::class), config('achievements.lesson_watched'));
        });

        $this->app->bind(UserService::class, function ($app) {
            return new UserService($app->make(User::class), config('achievements'), config('badges'));
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
