<?php

namespace App\Listeners;

use App\Events\RefreshUploadHistory;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class RefreshUploadHistoryListener implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(RefreshUploadHistory $event)
    {
        broadcast(new RefreshUploadHistory($event->data))->to('upload-history');
    }
}
