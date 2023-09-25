<?php

namespace Tests\Feature;

use App\Log\Logger;
use Tests\TestCase;

class LogTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function createLog(): void
    {
        $log = new Logger();
        $log->debug("This is a debug log");
        $log->info("This is a info log");
        $log->warning("This is a warning log");
        $log->error("This is a error log");
    }
}
