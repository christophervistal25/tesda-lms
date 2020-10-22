<?php


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');



// Admin routes
Route::prefix('admin')->group(function() {
	Route::get('/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
	Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');

    Route::get('/register', 'Auth\AdminRegisterController@showRegisterForm')->name('admin.register');
    Route::post('/register', 'Auth\AdminRegisterController@register')->name('admin.register.submit');

    
    

    Route::group(['middleware' => 'auth:admin'], function () {
    	Route::get('/', 'AdminController@index')->name('admin.dashboard');
    	Route::post('logout', 'AdminController@logout')->name('admin.logout');

	    Route::namespace('Admin')->group(function () {
            Route::put('course/{id}/hide', 'CourseController@hide');
            Route::get('course/design/{course}/{forceview?}', 'CourseController@design')->name('course.design');
            Route::resource('course', 'CourseController');

            Route::get('/course/{course}/overview/create', 'CourseOverviewController@create')->name('create.course.overview');
            Route::post('/course/{course}/overview/create', 'CourseOverviewController@store')->name('create.store.overview');
            Route::get('/course/{course}/overview/edit', 'CourseOverviewController@edit')->name('edit.course.overview');

            Route::put('/course/{id}/overview/update', 'CourseOverviewController@update')->name('update.course.overview');

            Route::get('/course/{course}/overview/show/{file?}', 'CourseOverviewController@show')->name('course.overview.show.file');

            Route::get('batch/list', 'BatchController@list');
            Route::put('batch/{id}/hide', 'BatchController@hide');
            Route::resource('batch', 'BatchController');

             Route::get('programs/list', 'ProgramsController@list');
            Route::put('programs/{id}/hide', 'ProgramsController@hide');
            Route::resource('programs', 'ProgramsController');

            Route::get('instructor/list', 'InstructorController@list');
            Route::post('instructor/assign/course/{instructor}', 'InstructorController@assignCourse');
            Route::resource('instructor', 'InstructorController');

            Route::get('/course/create/module/{course}', 'ModulesController@create')->name('course.add.module')->middleware('create.courseoverview.first');
            Route::post('/course/create/module/{course}', 'ModulesController@store')->name('course.submit.module');
            Route::get('/course/view/module/{course}', 'ModulesController@view')->name('course.view.module')->middleware('create.courseoverview.first');
            Route::get('/course/view/module/{module}/edit', 'ModulesController@edit')->name('course.edit.module');
            Route::put('/course/view/module/{module}/update', 'ModulesController@update')->name('course.update.module');

            Route::get('/course/forum/{forum}', 'CourseForumController@show')->name('course.forum.show');


            //Route::resource('modules', 'ModulesController');

            Route::post('activity/add/file', 'FileController@store')->name('activity.add.file');

            Route::get('activity/view/{activity}', 'ActivityController@view')->name('activity.view');

            Route::get('/forums', 'ForumController@index')->name('forum.index');
            Route::resource('/forums', 'ForumController');

            Route::get('/module/{module}/final/exam', 'FinalExamController@create')->name('module.final.exam');

            Route::get('/final/exam/{module}', 'FinalExamController@view')->name('admin.view.final.exam');

            Route::post('/module/{module}/final/exam', 'FinalExamController@store')->name('module.final.exam.submit');

            Route::get('/module/{module}/final/exam/edit/{forceview?}', 'FinalExamController@edit')->name('module.final.exam.edit');

            Route::put('/final/exam/{exam}/edit', 'FinalExamController@update')->name('module.final.exam.update');            
	    });
    });

});

// Admin routes
Route::prefix('student')->group(function() {
    

    Route::group(['middleware' => 'auth'], function () {
        Route::get('/site/home', 'HomeController@siteHome')->name('site.home');
        

        Route::namespace('Student')->group(function () {
            Route::get('/enroll/{program}', 'EnrollCourseController@show')->name('enroll.course');
            Route::post('/enroll/{program}', 'EnrollCourseController@enroll')->name('enroll.submit.course');
            Route::resource('program', 'ProgramController');


            Route::get('/course/view/{course}', 'CourseController@show')->name('student.course.view');
            Route::get('activity/view/{activity}', 'ActivityController@view')->name('student.activity.view');
            Route::get('course/design/{course}', 'CourseController@design')->name('student.course.design');
            Route::get('course/{course}/design', 'CourseController@getCourseDesign')->name('get.course.design');
            Route::get('/course/{course}/overview/show/{file?}', 'CourseOverviewController@show')->name('student.course.overview.show.file');


            Route::get('calendar', 'CalendarController@index')->name('calendar.index');

            Route::post('/activity/accomplish', 'AccomplishController@activity');
            Route::resource('accomplish', 'AccomplishController');

            Route::resource('course/status', 'CourseStatusController');

            Route::get('/final/exam/attempt/{module}', 'FinalExamController@userAddAttempt')->name('user.add.attempt');
            Route::get('/final/exam/{module}', 'FinalExamController@view')->name('view.final.exam');

            Route::get('/final/exam/answer/{module}', 'FinalExamController@answer')->name('answer.final.exam');
            Route::post('/final/exam/answer/{module}', 'FinalExamController@submit')->name('answer.final.exam.submit');

            Route::get('/final/exam/answer/{module}/result/{attempt}', 'FinalExamController@result')->name('answer.final.exam.result');
        });
        
    });

});
