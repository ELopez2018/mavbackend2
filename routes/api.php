<?php

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::middleware('auth:api')->get('/user', function () {
    return 'Prueba';
});

Route::get('/login/{socialNetwork}', [SocialLoginController::class, 'redirectToSocialNetwork'])->name('login.social')->middleware('guest', 'social_network');
Route::get('/login/{socialNetwork}/callback', [SocialLoginController::class, 'handleSocialNetworkCallback'])->middleware('guest', 'social_network');
