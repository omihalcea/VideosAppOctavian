<?php

namespace Feature;

use App\Helpers\UserHelpers;
use Tests\TestCase;
use App\Events\VideoCreated;
use App\Models\User;
use App\Models\Video;
use App\Notifications\VideoCreatedNotification;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VideoNotificationsTest extends TestCase
{
    use RefreshDatabase;

    public function test_video_created_event_is_dispatched()
    {
        Event::fake();

        $user = UserHelpers::create_superadmin_user();

        $this->actingAs($user);

        $response = $this->post(route('manage.store'), [
            'title' => 'Test Video',
            'description' => 'Test Description',
            'url' => 'https://www.youtube.com/embed/4LRz5jfvhCs?si=p1E50dfmHzJ1k-iP',
        ]);

        Event::assertDispatched(VideoCreated::class);

        $response->assertRedirect(route('videos.index'));
    }

    public function test_push_notification_is_sent_when_video_is_created()
    {
        Notification::fake();

        $admin = UserHelpers::create_superadmin_user();

        $this->actingAs($admin);

        $this->post(route('manage.store'), [
            'title' => 'Test Video',
            'description' => 'Test Description',
            'url' => 'https://www.youtube.com/embed/4LRz5jfvhCs?si=p1E50dfmHzJ1k-iP',
        ]);

        Notification::assertSentTo(
            [$admin],
            VideoCreatedNotification::class
        );
    }

}
