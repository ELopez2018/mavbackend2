<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RequestsServicesController;
use App\Http\Controllers\SocialLoginController;
use App\Http\Controllers\UserController;
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

/*
* USUARIO
*/

Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::post('/users', [UserController::class, 'store'])->name('users.store');
Route::post('/requestServices', [RequestsServicesController::class, 'store'])->name('request.Services');


Route::middleware('auth:api')->get('/user', function () {  return 'Prueba'; });

Route::get('/login/{socialNetwork}', [SocialLoginController::class, 'redirectToSocialNetwork'])->name('login.social')->middleware('guest', 'social_network');
Route::get('/login/{socialNetwork}/callback', [SocialLoginController::class, 'handleSocialNetworkCallback'])->middleware('guest', 'social_network');
