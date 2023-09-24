<?php

use App\Models\Log;
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

    $logger = new Log();
    $logger->info('Message from index.php');
    $logger->debug('Message from index.php');
    $logger->warning('Message from index.php');
    $logger->error('Message from index.php');
    return view('welcome');
});
Route::get('/log', [LogController::class, 'list_'])->name('log_controller.list_');
Route::post('/log/edit', [LogController::class, 'edit'])->name('log_controller.edit');
