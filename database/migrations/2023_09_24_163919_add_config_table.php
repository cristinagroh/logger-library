<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //
        Schema::create('config', function(Blueprint $table){
            $table->smallIncrements('id');
            $table->string('variable', 100)->unique();
            $table->string('value', 100)->unique();
            $table->datetime('created_at');
            $table->datetime('updated_at');
        });

        DB::table("config")->updateOrInsert([
            'variable' => 'minimum_log_level',
            'value' => env('LOG_LEVEL', 'debug'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('config');
    }
};
