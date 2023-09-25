<?php

namespace App\Log\Handler\HandlerTypes;

use App\Log\Handler\HandlerInterface;
use App\Models\LogHistory;

class DatabaseHandler implements HandlerInterface
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
            static::saveDataToDB($output);
        }
    }

    protected static function saveDataToDB(string $str): void
    {
        $addHistory = new LogHistory();
        $addHistory->message = $str;
        $addHistory->created_at = date('Y-m-d H:i:s');
        $addHistory->updated_at = date('Y-m-d H:i:s');
        $addHistory->save();
        return;
    }
}