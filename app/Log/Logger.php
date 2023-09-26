<?php

namespace App\Log;

use App\Log\Handler\LogJobHandler;
use App\Events\LogEvent;
use Psr\Log\AbstractLogger;
use App\Models\TargetLogManager;
use Monolog\Logger as MainLogger;
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

    public $handler;
    public $info;

    /**
     * @var HandlerInterface
     */

     public function __invoke(array $config)
    {
        $logger = new MainLogger('custom');
        $handler = new LogJobHandler();
        $logger->pushHandler($handler);
        return $logger;
    }

    public function __construct()
    {

    }

    public function log($level, string|\Stringable $message, array $context = []): void
    {
        $configLogId = (int)config('log.minimum_log_level');
        if(!isset(self::$levelText[$level])){
            return;
        }
        if($level < $configLogId){
            return;
        }
        $targetLogManager = TargetLogManager::where(function($query) use($configLogId){
            $query->where('minimum_level_for_target', '<=', $configLogId)->whereNotNull('target');
        })
        ->orWhere(function($query) use($level){
            $query->where('id', '=', $level)->whereNotNull('target');
        })
        ->distinct()
        ->pluck('target')
        ->toArray();

        $this->info = [
            'message' => self::interpolate((string)$message, $context),
            'level' => self::$levelText[$level],
            'timestamp' => (new \DateTimeImmutable())->format(self::DEFAULT_DATETIME_FORMAT),
        ];

        event(new LogEvent($this->info, $targetLogManager));
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