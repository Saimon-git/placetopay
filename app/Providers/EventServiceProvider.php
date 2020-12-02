<?php

namespace App\Providers;

use App\Challenge;
use App\Comment;
use App\Company;
use App\Content;
use App\ContentView;
use App\DailyContent;
use App\Invitation;
use App\Like;
use App\Notification;
use App\NotificationQueue;
use App\Observers\ChallengeObserver;
use App\Observers\ClientObserver;
use App\Observers\CommentObserver;
use App\Observers\CompanyObserver;
use App\Observers\ContentObserver;
use App\Observers\ContentViewObserver;
use App\Observers\DailyContentObserver;
use App\Observers\InvitationObserver;
use App\Observers\LikeObserver;
use App\Observers\NotificationObserver;
use App\Observers\NotificationQueueObserver;
use App\Observers\UserObserver;
use App\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use Laravel\Passport\Client;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot()
    {
        parent::boot();
    }
}
