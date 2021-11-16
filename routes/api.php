<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ProfileController;
use App\Http\Controllers\API\InvitationsController;


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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });








//this is the route for the first registration from the admin
Route::post('admin/register', [AuthController::class, 'first_register']);

// route for other users
Route::post('user/register', [AuthController::class, 'register'])->middleware('has_invitation');


Route::post('user/register/final/{pin}',[AuthController::class, 'final_user_register']);

//Route::post('login-first', [AuthController::class, 'first_login']);
Route::post('login', [AuthController::class, 'login']);

Route::post('logout',[AuthController::class,'logout']);


Route::post('update-role/{id}',[AuthController::class,'updateUserRole'])->middleware(['auth:api','admin']);

Route::apiResource('invitations', InvitationsController::class)->middleware(['auth:api','admin']);



Route::apiResource('profile', ProfileController::class)->middleware(['auth:api','register_success']);