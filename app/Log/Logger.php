<?php

namespace App\Log;

use Psr\Log\AbstractLogger;
use App\Log\Handler\HandlerInterface;

class Logger extends AbstractLogger
{
    protected const DEFAULT_DATETIME_FORMAT = 'c';

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

    /**
     * @var HandlerInterface
     */
    private $handler;

    public function __construct(HandlerInterface $handler)
    {
        $this->handler = $handler;
    }

    public function log($level, string|\Stringable $message, array $context = []): void
    {
        if(!isset(self::$levelText[$level])){
            return;
        }
        if($level < array_search(config('log.minimum_log_level'), self::$levelText)){
            return;
        }
        $this->handler->handle([
            'message' => self::interpolate((string)$message, $context),
            'level' => self::$levelText[$level],
            'timestamp' => (new \DateTimeImmutable())->format(self::DEFAULT_DATETIME_FORMAT),
        ]);
    }

    protected static function interpolate(string $message, array $context = []): string
    {
        $replace = [];
        foreach ($context as $key => $val) {
            if (is_string($val) || method_exists($val, '__toString')) {
                $replace['{' . $key . '}'] = $val;
            }
        }
        return strtr($message, $replace);
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