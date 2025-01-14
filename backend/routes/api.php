<?php

declare(strict_types=1);

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// OpenAPI generated routes start
Route::prefix('v1')->group(function () {
    Route::get('/sample', 'App\Http\Controllers\Api\V1\SampleController@index');
});

Route::middleware('auth:sanctum')->prefix('v1')->group(function () {
});
// OpenAPI generated routes end
