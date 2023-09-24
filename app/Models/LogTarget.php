<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogTarget extends Model
{
    protected $table = 'log_target';
    
    protected $guarded = [];

    const TARGET_FILE = 1;
    const TARGET_DAILY_FILE = 2;
    const TARGET_MAIL = 3;
}
