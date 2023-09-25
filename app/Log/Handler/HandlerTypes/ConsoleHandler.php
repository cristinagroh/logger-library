<?php

namespace App\Log\Handler\HandlerTypes;

use App\Log\Handler\HandlerInterface;

class ConsoleHandler implements HandlerInterface
{
    /**
     * @var string
     */

    public function __construct()
    {
        
    }

    public function handle(array $vars): void
    {
        if (!empty($vars)) {
            $output = self::DEFAULT_FORMAT;
            foreach ($vars as $var => $val) {
                $output = str_replace('%' . $var . '%', $val, $output);
            }
            static::writeOutput("<script>console.log('" . $output . "');</script>");
        }
    }

    protected static function writeOutput(string $str): void
    {
        echo $str;
    }
}