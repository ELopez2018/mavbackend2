<?php


use App\Http\Controllers\LoginController;
use App\Http\Controllers\RequestsServicesController;
use App\Http\Controllers\RequestsTypesController;
use App\Http\Controllers\ServicesTypesController;
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

// ====================== Logeo del sistemas========================||
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::get('/login/{socialNetwork}', [SocialLoginController::class, 'redirectToSocialNetwork'])->name('login.social')->middleware('guest', 'social_network');
Route::get('/login/{socialNetwork}/callback', [SocialLoginController::class, 'handleSocialNetworkCallback'])->middleware('guest', 'social_network');

// ====================== Usuarios =================================||
Route::post('/users', [UserController::class, 'store'])->name('users.store');

// ====================== Servicios ================================||
Route::get('/getServicesTypes', [ServicesTypesController::class, 'index'])->name('servicesTypes.index');
Route::get('/getrequestTypes',  [RequestsTypesController::class, 'index'])->name('requestTypes.index');
Route::post('/requestServices', [RequestsServicesController::class, 'store'])->name('requestServices.store');
Route::get('/requestServices/{id}', [RequestsServicesController::class, 'show'])->name('requestServices.show');
Route::post('/serviceAssignment', [RequestsServicesController::class, 'serviceAssignment'])->name('requestServices.serviceAssignment');


// ====================== Rutas Protegidas===========================||
Route::middleware(['auth:api'])->group(function () {

});
