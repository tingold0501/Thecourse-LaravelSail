<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\EduController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::controller(UserController::class)->group(function () {
    Route::get('getAllDataUser', 'index');
    Route::get('getAllActiveUser', 'indexActive');
    Route::get('getAllNewUser', 'getAllNewUser');
    Route::get('getSumUser', 'getSumUsers');
    Route::get('getTeacher', 'getTeacher');
    Route::post('addAUser', 'create');
    Route::post('updateNameUser', 'updateName');
    Route::post('updateStatusUser', 'updateStatus');
    Route::post('updateEmailUser', 'updateEmail');
    Route::post('updatePhonelUser', 'updatePhone');
    Route::post('loginTeacher', 'loginTeacher');

});

Route::controller(RoleController::class)->group(function () {
    Route::get('getAllDataRole', 'index');
    Route::get('getAllNewRole', 'getNewRole');
    Route::get('getSumRole', 'getSumRole');
    Route::get('getActive', 'getAcctiveRole');
    Route::post('addARole', 'create');
    Route::post('updateNameRole', 'updateName');
    Route::post('updateStatusRole', 'updateStatus');
});

Route::controller(EduController::class)->group(function () {
    Route::get('getAllDataEdu', 'index');
    Route::post('createEdu', 'create');
});
