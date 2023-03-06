<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\UserController;

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

Route::controller(AuthenticationController::class)->group(function(){
    Route::post('register', 'register');
    Route::post('login', 'login');
});


// Route::group(['middleware' => ['api', 'role:admin', 'auth:api']], function () {
//     Route::post('logout', [AuthenticationController::class, 'logout']);
//     Route::post('create-org', [OrganizationController::class, 'store']);
//     Route::get('org-list', [OrganizationController::class, 'index']);
//     Route::get('fetchData', [UserController::class, 'index']);
// });

Route::group(['middleware' => ['api', 'role:user', 'auth:api']], function () {
    Route::controller(OrganizationController::class)->group(function () {
        Route::get('list-organization', 'index');
        Route::post('create-organization', 'store');
    });

    Route::post('logout', [AuthenticationController::class, 'logout']);
    Route::get('user', [UserController::class, 'index']);

});




