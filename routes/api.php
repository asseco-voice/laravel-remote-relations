<?php

use Asseco\RemoteRelations\App\Http\Controllers\RemoteRelationController;
use Asseco\RemoteRelations\App\Http\Controllers\RemoteServicesController;
use Asseco\RemoteRelations\App\Http\Controllers\ResolvedRemoteRelationController;
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

Route::prefix('api')
    ->middleware('api')
    ->group(function () {
        Route::get('services', [RemoteServicesController::class, 'index']);

        Route::get('remote-relations/{remote_relation}/resolved',
            [ResolvedRemoteRelationController::class, 'show'])->name('remote-relations.resolve');

        Route::apiResource('remote-relations', RemoteRelationController::class);
    });
