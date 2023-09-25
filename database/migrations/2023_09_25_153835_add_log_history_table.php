<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //
        Schema::create('log_history', function(Blueprint $table){
            $table->smallIncrements('id');
            // for huge informations it will be nice to add a timestamp column
            $table->string('message', 2000);
            $table->datetime('created_at');
            $table->datetime('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('log_history');
    }
};
