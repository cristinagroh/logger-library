<?php

namespace App\Http\Controllers;

use App\Log\Logger;
use DirectoryIterator;
use App\Models\Config as LocalConfig;
use App\Models\TargetLogManager;
use Illuminate\Support\Facades\Config;
use Illuminate\Routing\Controller as BaseController;

class LogController extends BaseController
{
    public function list_()
    {
        $existingHandlers = [];
        foreach (new DirectoryIterator(dirname(__FILE__, 3).'/Log/Handler/HandlerTypes/') as $file) {
            if ($file->isFile()) {
                $existingHandlers[] = pathinfo($file->getFilename(), PATHINFO_FILENAME);
            }
        }
        $targetLogManager = TargetLogManager::all();
        $levelTextArray = Logger::$levelText;
        $currentMinimLevel = config('log.minimum_log_level');
        return view('settings', compact('levelTextArray', 'currentMinimLevel', 'targetLogManager', 'existingHandlers'));
    }

    public function edit()
    {
        if(isset($_POST)){
            if(isset($_POST['minimum_level'])){
                Config::set('log.minimum_log_level', $_POST['minimum_level']);
                LocalConfig::where('variable', 'minimum_log_level')->update([
                    'value' => $_POST['minimum_level'], 
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            }
            $targetLogManager = TargetLogManager::all();
            foreach($targetLogManager as $tlm){
                if(isset($_POST['minimum_level_for_'.$tlm->log_name], $_POST['target_'.$tlm->log_name])){
                    TargetLogManager::where('log_name', $tlm->log_name)->update([
                        'target' => (trim($_POST['target_'.$tlm->log_name]) != '' ? $_POST['target_'.$tlm->log_name] : null), 
                        'minimum_level' => $_POST['minimum_level_for_'.$tlm->log_name], 
                    ]);
                }
            }
            return redirect()->route('log_controller.list_')->with(['status' => 'Successfully updated  configuration !', 'type' => 'success']);
        }
        return redirect()->route('log_controller.list_')->with(['status' => 'Nothing to update !', 'type' => 'warning']);
        
    }
}
