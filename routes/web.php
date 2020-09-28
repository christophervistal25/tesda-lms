<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


// Admin routes
Route::prefix('admin')->group(function(){
	Route::get('/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
	Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');

    Route::get('/register', 'Auth\AdminRegisterController@showRegisterForm')->name('admin.register');
    Route::post('/register', 'Auth\AdminRegisterController@register')->name('admin.register.submit');

    
    

    Route::group(['middleware' => 'auth:admin'], function () {
    	Route::get('/', 'AdminController@index')->name('admin.dashboard');
    	Route::post('logout', 'AdminController@logout')->name('admin.logout');

	    Route::namespace('Admin')->group(function () {
            Route::put('course/{id}/hide', 'CourseController@hide');
            Route::get('course/design/{course}', 'CourseController@design')->name('course.design');
            Route::resource('course', 'CourseController');
            Route::get('batch/list', 'BatchController@list');
            Route::put('batch/{id}/hide', 'BatchController@hide');
            Route::resource('batch', 'BatchController');
            Route::get('programs/list', 'ProgramsController@list');
            Route::put('programs/{id}/hide', 'ProgramsController@hide');
            Route::resource('programs', 'ProgramsController');
            Route::get('instructor/list', 'InstructorController@list');
            Route::post('instructor/assign/course/{instructor}', 'InstructorController@assignCourse');
            Route::resource('instructor', 'InstructorController');
            Route::get('/course/create/module/{course}', 'CourseController@addModule')->name('course.add.module');
            Route::post('/course/create/module/{course}', 'CourseController@submitModule')->name('course.submit.module');
            Route::resource('modules', 'ModulesController');
	    });
    });

});
