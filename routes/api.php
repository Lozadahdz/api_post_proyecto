<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Registro\RegistroController;
use App\Http\Controllers\Login\LoginController;
use App\Http\Controllers\Home\HomeController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// USUARIOS
Route::post('/registro', [RegistroController::class, 'registro']);
Route::post('/login', [LoginController::class, 'login']);

// ADMINS
Route::post('/registro-admin', [RegistroController::class, 'registroAdmin']);
Route::post('/login-admin', [LoginController::class, 'loginAdmin']);

Route::post('/savePost', [HomeController::class, 'savePost']);
Route::get('/allpost', [HomeController::class, 'allPosts']);
Route::post('/mypost', [HomeController::class, 'mypost']);
Route::post('/postvalidate', [HomeController::class, 'postValidate']);

//VALIDATED POST ADMIN
Route::post('/post-accept', [HomeController::class, 'postAccept']);
Route::post('/post-decline', [HomeController::class, 'postDecline']);
Route::get('/allUsers', [HomeController::class, 'allUsers']);
Route::post('/disableUser', [HomeController::class, 'disableUser']);
Route::post('/updatepass', [HomeController::class, 'updatepass']);


