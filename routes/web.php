<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ViewsController;
use App\Http\Controllers\CodesController;
use App\Http\Controllers\PeliculasController;
use App\Http\Controllers\QrController;
use App\Http\Controllers\TokenValidateController;
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
    return view('Auth.login');
});

Route::get('login',[ViewsController::class,'loginView'])->name('login');

Route::post('session',[AuthController::class,'login'])->name('session');

Route::middleware(['auth'])->group(function () {
    Route::get('verificarCodigo', ([ViewsController::class,'verifyCode']))->name('verifyCode');
    Route::post('validarCodigo',([CodesController::class,'validateCodeView']))->name('validateCodeView');
});
Route::middleware(['validarRol'])->group(function () {
    Route::get('dashboard', ([ViewsController::class,'dashboardView']))->name('dashboardView');
    Route::get('signout',([AuthController::class,'signOut']))->name('signOut');
    Route::get('peliculas', ([ViewsController::class,'vistaPelicula']))->name('vistaPelicula');
    Route::get('denegado', ([ViewsController::class,'denegadoView']))->name('denegadoView');

    Route::prefix('peli')->group(function () {
        Route::post('addpeli', ([PeliculasController::class,'addPeliculas']))->name('addPeliculas');
        Route::put('updatepeli/{id}', ([PeliculasController::class,'updatePeliculas']))->name('updatePeliculas');
        Route::delete('deletepeli/{id}', ([PeliculasController::class,'changeStatusPelicula']))->name('changeStatusPelicula');
    });
});

Route::middleware(['codesMiddleware'])->group(function () {
    Route::get('verificarCodigo', ([ViewsController::class,'verifyCode']))->name('verifyCode');
    Route::post('validarCodigo',([CodesController::class,'validateCodeView']))->name('validateCodeView');
});

Route::middleware(['QrMiddleware'])->group(function () {
    Route::get('QrView',([QrController::class,'generateQrCode']))->name('generateQrCode');
});

Route::middleware(['GenerateTokenMiddleware'])->group(function () {
    Route::get('notification', ([ViewsController::class,'notificationToken']))->name('notificationToken');
});

Route::middleware(['auth'])->group(function () {
    Route::prefix('tokengenerate')->group(function () {
        Route::post('tokengen/{id}', ([TokenValidateController::class,'getTokensGenerate']))->name('getTokensGenerate');
        Route::post('tokengenupdate/{id}', ([TokenValidateController::class,'generateTokenUpdate']))->name('generateTokenUpdate');
        Route::post('tokengendelete/{id}', ([TokenValidateController::class,'generateTokenDelete']))->name('generateTokenDelete');
        Route::delete('deletetoken', ([TokenValidateController::class,'deleteTokens']))->name('deleteTokens');
        Route::post('valtoken', ([TokenValidateController::class,'validateToken']))->name('validateToken');
    });
});
