<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\EduController;
use App\Http\Controllers\CateController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\BillController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\StudentController;
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
    Route::get('getAllActiveUser', 'indexActive');
    Route::get('getAllDataUser', 'index');
    Route::get('getAllNewUser', 'getAllNewUser');
    Route::get('getSumUser', 'getSumUsers');
    Route::get('getTeacher', 'getTeacher');
    Route::get('Admin', 'Admin');
    Route::post('addAUser', 'create');
    Route::post('updateNameUser', 'updateName');
    Route::post('updateStatusUser', 'updateStatus');
    Route::post('updateEmailUser', 'updateEmail');
    Route::post('updatePhonelUser', 'updatePhone');
    Route::post('loginTeacher', 'loginTeacher');
    Route::post('loginAdmin', 'loginAdmin');
    Route::post('loginStudent', 'loginStudent');
    Route::post('delete', 'delete');
    Route::post('updateRole', 'updateRole');

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
    Route::get('getLatestCourses', 'getLatestCourses');
    Route::get('getAllCourse', 'getAllCourse');
    Route::post('createCourse', 'createCourse');
    Route::post('addPrice', 'addPrice');
    Route::post('deleteCourse', 'deleteCourse');
    Route::post('editcourse', 'editcourse');
    Route::post('editFileCourse', 'editFileCourse');
    Route::get('getSumCourse', 'getSumCourse');
    Route::get('activeCate', 'activeCate');
    Route::get('singleCourseUser/{id}', 'singleCourseUser');
    Route::get('course/{id}', 'singleCourse1');
});
Route::controller(BillController::class)->group(function () {
    Route::get('getAllDataBill', 'index');
    Route::get('getSumBill', 'getSumBill');
});
Route::controller(CustomerController::class)->group(function () {
    Route::get('getAllDataCustomer', 'index');
    Route::post('createCustomer', 'create');
    Route::post('loginCustomer', 'loginCustomer');
});

Route::controller(StudentController::class)->group(function () {
    Route::get('getAllDataStudent', 'index');
    
});

