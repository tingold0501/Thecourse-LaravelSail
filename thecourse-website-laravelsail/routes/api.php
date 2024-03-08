<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\EduController;
use App\Http\Controllers\CateController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\BillController;
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
    Route::post('loginAdmin', 'loginAdmin');

});

Route::controller(RoleController::class)->group(function () {
    Route::get('getAllDataRole', 'index');
    Route::get('getAllNewRole', 'getNewRole');
    Route::get('getSumRole', 'getSumRole');
    Route::get('getActive', 'getAcctiveRole');
    Route::post('addARole', 'create');
    Route::post('updateNameRole', 'updateName');
    Route::post('updateStatusRole', 'updateStatus');
    Route::post('deleteRole', 'destroy');
});

Route::controller(EduController::class)->group(function () {
    Route::get('getAllDataEdu', 'index');
    Route::get('getActiveEdu', 'activeEdu');
    Route::post('createEdu', 'create');
    Route::post('ediEdu', 'editEdu');
    Route::post('switchEdu', 'switchEdu');
    Route::post('deleteEdu', 'deleteEdu');
});

Route::controller(CateController::class)->group(function () {
    Route::get('getAllDataCate', 'index');
});

Route::controller(CourseController::class)->group(function () {
    Route::get('getAllDataCourse', 'index');
    Route::post('createCourse', 'createCourse');
    Route::post('addPrice', 'addPrice');
    Route::post('getSumCourse', 'getSumCourse');
});
Route::controller(BillController::class)->group(function () {
    Route::get('getAllDataBill', 'index');
    Route::get('getSumBill', 'getSumBill');
});

