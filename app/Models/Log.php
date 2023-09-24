<?php

namespace App\Models;

class Log
{
    const DEBUG = 1;
    const INFO = 2;
    const WARNING = 3;
    const ERROR = 4;

    public static $levelText = [
        self::DEBUG => 'debug',
        self::INFO => 'info',
        self::WARNING => 'warning',
        self::ERROR => 'error'
    ];

    public function log($level, string|\Stringable $message, array $context = []): void
    {
        if($level < config('log.minimum_log_level')){
            return;
        }
        $dateFormatted = (new \DateTime())->format('Y-m-d H:i:s');
        $contextString = !empty($context) ? json_encode($context) : '';
        $message = sprintf(
            '[%s] %s: %s%s',
            $dateFormatted,
            $level,
            $message,
            $contextString,
            PHP_EOL
        );

        echo '<script>console.log("'.$message.'"); </script>';
        // file_put_contents('devto.log', $message, FILE_APPEND);
    }

    public function error(string|\Stringable $message, array $context = []): void
    {
        $this->log(self::$levelText[self::ERROR], $message, $context);
    }

    public function warning(string|\Stringable $message, array $context = []): void
    {
        $this->log(self::$levelText[self::WARNING], $message, $context);
    }

    public function info(string|\Stringable $message, array $context = []): void
    {
        $this->log(self::$levelText[self::INFO], $message, $context);
    }

    public function debug(string|\Stringable $message, array $context = []): void
    {
        $this->log(self::$levelText[self::DEBUG], $message, $context);
    }
}