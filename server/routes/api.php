<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskRecordController;
use Illuminate\Console\View\Components\Task;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::get('/get_data', [TaskRecordController::class, 'getAllData']);
Route::post('/todo/insert', [TaskRecordController::class, 'insert']);
Route::post('/todo/update', [TaskRecordController::class, 'update']);
Route::post('/todo/delete', [TaskRecordController::class, 'delete']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
