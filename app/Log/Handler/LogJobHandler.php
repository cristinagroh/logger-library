<?php

namespace App\Log\Handler;

use Monolog\Logger;
use Monolog\LogRecord;
use Monolog\Handler\AbstractProcessingHandler;
use App\Log\Logger as CustomLogger;


class LogJobHandler extends AbstractProcessingHandler
{
    public function __construct($level = Logger::DEBUG, bool $bubble = true)
    {
        parent::__construct($level, $bubble);
    }

    /**
     * @inheritDoc
     */
    protected function write(LogRecord $record): void
    {
        //
        $logger = new CustomLogger();
        $level = array_search(strtolower($record->level->name), CustomLogger::$levelText);
        if(!isset($level)){
            return;
        }
        $logger->log($level, $record->formatted);
    }
}