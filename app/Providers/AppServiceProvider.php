<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Auth;
use App\Repositories\StudentRepository;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Support\Facades\Schema;
use App\Event;
use Carbon\Carbon;

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

        $events = 0;
        if (Schema::hasTable('events')) {
                $events = Event::whereDate('start' , '>=' , Carbon::now()->format('Y/m/d'))->count() ?? 0;

                view()->composer('layouts.student.short-app', function ($view) use($events) {
                    $view->with('no_of_events', $events);
                });
        }

         view()->composer('layouts.student.app', function ($view) use($events) {
            $studentRepository = new StudentRepository;
            $currentCourse     = $studentRepository->getCourse();
            $view->with('no_of_events', $events);
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
