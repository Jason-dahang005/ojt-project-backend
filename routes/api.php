<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
  
use App\Http\Controllers\API\PassportController;
use App\Http\Controllers\API\OrganizationController;
  
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
  
Route::post('register', [PassportController::class, 'register']);
Route::post('login', [PassportController::class, 'login']);


Route::resource('organizations', OrganizationController::class);