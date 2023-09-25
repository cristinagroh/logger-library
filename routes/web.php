<?php

use App\Log\Logger;
use App\Models\Log;
use App\Log\Handler\FileHandler;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LogController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {

    // $logger = new Log();
    // $logger->info('Message from index.php');
    // $logger->debug('Message from index.php');
    // $logger->warning('Message from index.php');
    // $logger->error('Message from index.php');
    $logFileName = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'var' . DIRECTORY_SEPARATOR . 'log' . DIRECTORY_SEPARATOR . date('Y-m-d') . '.log';

    $handler = new FileHandler($logFileName);
    $logger = new Logger($handler);

    $logger->log(Logger::DEBUG, 'an error has occurred'); 
    $logger->log(Logger::INFO, 'an error has occurred'); 
    return view('welcome');
});
Route::get('/log', [LogController::class, 'list_'])->name('log_controller.list_');
Route::post('/log/edit', [LogController::class, 'edit'])->name('log_controller.edit');
