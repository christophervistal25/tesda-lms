<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Auth;
use App\Repositories\StudentRepository;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if (env('REDIRECT_HTTPS')) {
            $this->app['request']->server->set('HTTPS', true);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(UrlGenerator $url)
    {
        if (env('REDIRECT_HTTPS')) {
            $url->formatScheme('https');
        }

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
