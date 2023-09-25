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
        //
        $targets = LogTarget::where('minimum_level', '>=',  array_search($event->log['level'], Log::$levelText))->get();
        if(!isset($event->log) || $event->log['message'] == ''){
            return;
        }
        foreach($targets as $target){
            switch($target->name){
                case LogTarget::TARGET_FILE:
                    file_put_contents('devto.log', $event->log['message'], FILE_APPEND);
                break;
                case LogTarget::TARGET_DAILY_FILE:
                break;
                case LogTarget::TARGET_MAIL:
                break;
                default:
                    echo '<script>console.log("'.$event->log['message'].'"); </script>';
            }
        }
        dd($event);
    }
}
