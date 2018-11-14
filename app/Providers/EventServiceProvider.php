<?php

namespace App\Providers;

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
        'App\Events\Event' => [
            'App\Listeners\EventListener',
        ],
        'SocialiteProviders\Manager\SocialiteWasCalled' => [
//            'SocialiteProviders\Qq\QqExtendSocialite@handle',//这里的SocialiteProviders\Qq\QqExtendSocialite@handle，里面有个q改成大写
            'SocialiteProviders\QQ\QqExtendSocialite@handle',//改成这样就对了，之前如果那个q是小写的话会报找不到类的错误。
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
