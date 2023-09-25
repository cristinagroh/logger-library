<?php

namespace App\Http\Controllers;

use App\Log\Logger;
use Illuminate\Support\Facades\Config;
use App\Models\Config as LocalConfig;
use Illuminate\Routing\Controller as BaseController;

class LogController extends BaseController
{
    public function list_()
    {
        $levelTextArray = Logger::$levelText;
        $currentMinimLevel = config('log.minimum_log_level');
        return view('settings', compact('levelTextArray', 'currentMinimLevel'));
    }

    public function edit()
    {
        if(isset($_POST['minimum_level'])){
            if(in_array($_POST['minimum_level'], Logger::$levelText)){
                Config::set('log.minimum_log_level', $_POST['minimum_level']);
                LocalConfig::where('variable', 'minimum_log_level')->update([
                    'value' => $_POST['minimum_level'], 
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            }
        }
        return redirect()->route('log_controller.list_');
        
    }
}
