<?php

namespace Tests\Feature;

use App\Events\AchievementUnlocked;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class AchievementTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_get_users_full_status()
    {
        $user = User::factory()->create();
        $response = $this->get('users/'.$user->id.'/achievements');

        $response
        ->assertStatus(200)
            ->assertJsonStructure([
                'unlocked_achievements',
                'next_available_achievements',
                'current_badge',
                'next_badge',
                'remaining_to_unlock_next_badge',
            ])
            ->assertJson(fn (AssertableJson $json) =>
                $json
                ->whereType('unlocked_achievements', 'array')
                ->whereType('next_available_achievements', 'array')
                ->whereType('current_badge', 'string')
                ->whereType('next_badge', 'string')
                ->whereType('remaining_to_unlock_next_badge', 'integer')

                
            );
    }

    public function test_comment_achievements_can_be_unlocked()
    {
        $this->post('/comments');

        $this->expectsEvents(AchievementUnlocked::class);
    }

    public function test_lesson_watch_achievements_can_be_unlocked()
    {
        $user = User::factory()->create();

        $comment = Comment::factory()->create([
            'body' => 'First Comment',
            'user_id' => $user->id,
        ]);

        $response = $this->post('/watch/{lessonId}');

        $this->expectsEvents(AchievementUnlocked::class);
    }
}
