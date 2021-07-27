<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use \App\Http\Controllers\MajorController;
use \App\Http\Controllers\StudentController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::prefix('majors')->group(function () {
    Route::get('all/{limit}/{offset?}/{direction?}', [MajorController::class, 'index'])
        ->whereNumber(['limit', 'offset'])->whereAlpha(['direction']);

    Route::get('{major}', [MajorController::class, 'show']);
    Route::post('new', [MajorController::class, 'store']);
    Route::post('search/{limit}', [MajorController::class, 'search'])->whereNumber('limit');
    Route::put('edit/{major}', [MajorController::class, 'update']);
    Route::delete('delete/{major}', [MajorController::class, 'destroy']);
});

Route::prefix('students')->group(function () {
    Route::get('all/{limit}/{offset?}/{direction?}', [StudentController::class, 'index'])
        ->whereNumber(['limit', 'offset'])->whereAlpha(['direction']);

    Route::get('{student}', [StudentController::class, 'show']);
    Route::post('new', [StudentController::class, 'store']);
    Route::put('edit/{student}', [StudentController::class, 'update']);
    Route::delete('delete/{student}', [StudentController::class, 'destroy']);
});
