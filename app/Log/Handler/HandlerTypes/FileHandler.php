<?php

namespace App\Log\Handler\HandlerTypes;

use App\Log\Handler\HandlerInterface;
use Illuminate\Support\Facades\Storage;

class FileHandler implements HandlerInterface
{
    /**
     * @var string
     */
    private $filename;

    public function __construct()
    {
        $filename = storage_path() . DIRECTORY_SEPARATOR . 'logs' . DIRECTORY_SEPARATOR . date('Y-m-d') . '.log';
        $dir = dirname($filename);
        if (!file_exists($dir)) {
            $status = mkdir($dir, 0777, true);
            if ($status === false && !is_dir($dir)) {
                throw new \UnexpectedValueException(sprintf('There is no existing directory at "%s"', $dir));
            }
        }
        $this->filename = $filename;
    }

    public function handle(array $vars): void
    {
        $output = self::DEFAULT_FORMAT;
        foreach ($vars as $var => $val) {
            $output = str_replace('%' . $var . '%', $val, $output);
        }
        file_put_contents($this->filename, $output . PHP_EOL, FILE_APPEND);
    }
}