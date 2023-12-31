<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CarroController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\LocacaoController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\ModeloController;
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

Route::prefix('v1')->group(function() {

    Route::middleware(['jwt.auth'])->group(function() {
        Route::apiResource('carro', CarroController::class);
        Route::apiResource('cliente', ClienteController::class);
        Route::apiResource('locacao', LocacaoController::class);
        Route::apiResource('marca', MarcaController::class);
        Route::apiResource('modelo', ModeloController::class);

        Route::post('me', [AuthController::class, 'me']);
        Route::post('logout', [AuthController::class, 'logout']);
        // Route::apiResource('user', UserController::class);
    });

    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('login', [AuthController::class, 'login'])->name('api.login');

});

