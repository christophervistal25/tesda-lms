<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Auth;
use App\Repositories\StudentRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
         view()->composer('layouts.student.app', function ($view)  {
            $studentRepository = new StudentRepository;
            $currentCourse     = $studentRepository->getCourse();
            $view->with('course_sections', $studentRepository->sections($currentCourse));
            $view->with('current_course', $currentCourse);
         });

         view()->composer(['student.site-home', 'student.program-course.show'], function ($view)  {
            $studentRepository = new StudentRepository;
            $currentCourse     = $studentRepository->getCourse();
            $view->with('current_course', $currentCourse);
         });


        
    }
}
