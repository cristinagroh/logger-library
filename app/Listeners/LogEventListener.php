<?php

namespace App\Listeners;

use App\Models\Log;
use App\Models\LogTarget;
use Illuminate\Contracts\Queue\ShouldQueue;

class LogEventListener implements ShouldQueue
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
    public function handle(object $event): void
    {
        if(!isset($event->handlers, $event->info)){
            return;
        }
        $handlers = $event->handlers;
        $info = $event->info;
        foreach($handlers as $handler){
            if(!isset($handler)){
                continue;
            }
            $class = 'App\Log\Handler\HandlerTypes\\'.$handler;
            if (class_exists($class)) {
                $handler = new $class;
                $handler->handle($info);
            }
        }
    }
}
