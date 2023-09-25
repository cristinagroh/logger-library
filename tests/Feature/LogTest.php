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
        $log->log(Logger::DEBUG, "This is a debug log");
        $log->log(Logger::INFO, "This is a info log");
        $log->log(Logger::WARNING, "This is a warning log");
        $log->log(Logger::ERROR, "This is a error log");
    }
}
