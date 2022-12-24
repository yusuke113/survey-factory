<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::as('api.')->group(function () {
    Route::prefix('/v1')->as('v1.')->group(function () {
        Route::prefix('questionnaires')->namespace('Questionnaire')->as('questionnaire.')->group(function () {
            Route::post('/', 'Store')->name('store');
            Route::post('/ranking', 'GetRanking')->name('ranking');
            Route::get('/{questionnaireId}', 'Show')->name('show');
        });
    });

    /**
     * ヘルスチェック用
     */
    Route::get(
        '/health',
        fn () => response()->json(['message' => 'OK'])
    )->name('health');

    /**
     * APIのバージョンチェック用
     */
    Route::get(
        '/version',
        fn () => response()->json(['version' => config('app.version')])
    )->name('version');
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
