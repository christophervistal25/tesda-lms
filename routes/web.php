<?php

Route::get('/', 'HomePageController@index');
Route::get('/about/course/{course}', 'AboutCourseController@show');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/events', 'Admin\EventController@events');


// Admin routes
Route::prefix('admin')->group(function() {
	Route::get('/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
	Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');

    Route::get('/register', 'Auth\AdminRegisterController@showRegisterForm')->name('admin.register');
    // Route::post('/register', 'Auth\AdminRegisterController@register')->name('admin.register.submit');

    
    

    Route::group(['middleware' => 'auth:admin'], function () {
        Route::get('/', 'AdminController@index')->name('admin.dashboard');
        Route::get('/dashboard/{type?}', 'AdminController@dashboard')->name('admin.dashboard.index');
    	// Route::get('/{type?}', 'AdminController@index')->name('admin.dashboard');
    	Route::post('logout', 'AdminController@logout')->name('admin.logout');
        Route::get('/documentation', 'DocumentationController@index')->name('documentation.index');

        Route::get('/admin/register', 'AdminController@register')->name('create.new.admin');
        Route::post('/admin/register', 'AdminController@submit')->name('submit.new.admin');
        Route::get('/admin/edit/{id}', 'AdminController@edit')->name('admin.edit');
        Route::put('/admin/update/{id}', 'AdminController@update')->name('admin.update');

	    Route::namespace('Admin')->group(function () {
            Route::get('/profile', 'ProfileController@edit')->name('admin.profile');
            Route::put('/profile', 'ProfileController@update')->name('admin.profile.update');

            

            Route::get('/student/list', 'StudentController@list');
            Route::resource('student', 'StudentController');
            
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

            // Route::get('/forums', 'ForumController@index')->name('forum.index');

            Route::post('/{forum}/forum/add/comment', 'ForumController@addComment');
            Route::resource('/forums', 'ForumController');

            Route::get('/student/{id}/modules', 'StudentProgressController@show')->name('student.show.progress');
            Route::get('/module/{module}/final/exam', 'FinalExamController@create')->name('module.final.exam');

            Route::get('/final/exam/{module}', 'FinalExamController@view')->name('admin.view.final.exam');

            Route::post('/module/{module}/final/exam', 'FinalExamController@store')->name('module.final.exam.submit');

            Route::get('/module/{module}/final/exam/edit/{forceview?}', 'FinalExamController@edit')->name('module.final.exam.edit');

            Route::put('/final/exam/{exam}/edit', 'FinalExamController@update')->name('module.final.exam.update');

                            
            Route::get('course/badge/{course}/show', 'CourseBadgeController@show')->name('badge.course.show');
            Route::get('course/badge/{course}', 'CourseBadgeController@create')->name('badge.course.create');
            Route::post('course/badge/{course}', 'CourseBadgeController@store')->name('badge.course.store');
            Route::get('course/{course}/badge/{badge}/edit', 'CourseBadgeController@edit')->name('badge.course.edit');
            Route::put('course/{coures}/badge/{badge}/edit', 'CourseBadgeController@update')->name('badge.course.update');

            
            Route::put('event/reschedule/{id}', 'EventController@reschedule');
            Route::resource('event', 'EventController');

            Route::resource('report', 'ReportController');
            Route::get('/report/{from}/{to}', 'ReportPrintController@show')->name('print.report');
            Route::get('/student/{id}/activity/log', 'StudentActivityLogController@show');
	    });
    });

});

Route::prefix('student')->group(function() {
    

    Route::group(['middleware' => 'auth'], function () {
        Route::get('/site/home', 'HomeController@siteHome')->name('site.home');

        Route::namespace('Student')->group(function () {
            Route::get('profile', 'ProfileController@show')->name('student.profile');
            Route::get('profile/edit', 'ProfileController@edit')->name('student.profile.edit');
            Route::post('profile', 'ProfileController@update')->name('student.profile.update');

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
            Route::post('/final/exam/answer/{module}/save', 'FinalExamController@examSave')->name('answer.final.exam.save');

            Route::get('/grade/report/{course}', 'GradeController@show')->name('student.grade.report');

            Route::get('/badge', 'BadgeController@index')->name('student.badge.index');

            Route::get('/event/view/{event}', 'EventController@view');
            Route::post('/forum/{forum}/add/comment', 'ForumController@addComment');
            Route::resource('forum', 'ForumController');
        });
        
    });

});
