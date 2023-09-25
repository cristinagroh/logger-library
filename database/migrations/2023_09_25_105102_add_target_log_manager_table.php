<?php

use App\Log\Logger;
use App\Models\TargetLogManager;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //
        Schema::create('target_log_manager', function(Blueprint $table){
            $table->smallIncrements('id')->comment('similar to const of each log');
            $table->string('log_name', 100)->unique();
            $table->string('target', 100)->nullable();
            $table->string('minimum_level', 100);
            $table->datetime('created_at');
            $table->datetime('updated_at');
        });
        $dataToInsert = [];
        $logLevels = Logger::$levelText;
        foreach($logLevels as $key => $lvl)
        {
            $dataToInsert[] = [
                'id' => array_search($lvl, $logLevels),
                'log_name' => $lvl,
                'target' => null,
                'minimum_level' => array_search(env('LOG_LEVEL', 'debug'), Logger::$levelText),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
        }
        if(!empty($dataToInsert)) {
            TargetLogManager::insert($dataToInsert);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('target_log_manager');
    }
};
