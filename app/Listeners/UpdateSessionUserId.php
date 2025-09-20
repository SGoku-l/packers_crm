<?php

namespace App\Listeners;

// use App\Events\Login;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Auth\Events\Login;       
use Illuminate\Support\Facades\DB;

class UpdateSessionUserId
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Login $event): void
    {
         DB::table('sessions')
            ->where('id', session()->getId())
                ->update([
                    'user_id' => $event->user->getAuthIdentifier(),
        ]);
    }
}
