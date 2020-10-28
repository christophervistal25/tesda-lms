@extends('layouts.home.app')
@section('content')
<!--? slider Area Start-->
<section class="slider-area ">
    <div class="slider-active">
        <!-- Single Slider -->
        <div class="single-slider slider-height d-flex align-items-center">
            <div class="container">
                <div class="row">
                    <div class="col-xl-6 col-lg-7 col-md-12">
                        <div class="hero__caption">
                            <h1 data-animation="fadeInLeft" data-delay="0.2s">Explore & <br> Learn for free</h1>
                            <p data-animation="fadeInLeft" data-delay="0.4s">Build skills with courses and certificates online</p>
                            <a href="{{ route('register') }}" class="btn hero-btn" data-animation="fadeInLeft" data-delay="0.7s">Join for Free</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ? services-area -->
<div class="services-area">
    <div class="container">
        <div class="row justify-content-sm-center">
            <div class="col-lg-4 col-md-6 col-sm-8">
                <div class="single-services mb-30">
                    <div class="features-icon">
                        <img src="assets/img/icon/icon1.svg" alt="">
                    </div>
                    <div class="features-caption">
                        <h3>Good courses</h3>
                        <p>That you can access for free.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-8">
                <div class="single-services mb-30">
                    <div class="features-icon">
                        <img src="assets/img/icon/icon2.svg" alt="">
                    </div>
                    <div class="features-caption">
                        <h3>Expert instructors</h3>
                        <p>That will enhanced your skills.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-8">
                <div class="single-services mb-30">
                    <div class="features-icon">
                        <img src="assets/img/icon/icon3.svg" alt="">
                    </div>
                    <div class="features-caption">
                        <h3>Free access</h3>
                        <p>Anytime or anywhere.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Courses area start -->
<div class="courses-area section-padding40 fix" id="course-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-7 col-lg-8">
                <div class="section-tittle text-center mb-55">
                    <h2>Our featured courses</h2>
                </div>
            </div>
        </div>
        <div class="courses-actives">
            @foreach(range(1, 10) as $range)
            @foreach($courses as $course)
            <!-- Single -->
            <div class="properties pb-20">
                <div class="properties__card">
                    <div class="properties__img overlay1">
                        <a href="#"><img src="{{ $course->image }}" alt=""></a>
                    </div>
                    <div class="properties__caption">
                        <p>{{ $course->program->name }}</p>
                        <h3><a href="#">{{ $course->name }}</a></h3>
                        <p>{{ Str::limit($course->description, 100, '...')}} </p>
                        
                        <a href="/about/course/{{ $course->id }}" class="border-btn border-btn2">Find out more</a>
                    </div>
                </div>
            </div>
            <!-- Single -->
            @endforeach
            @endforeach
        </div>
    </div>
</div>
<!-- Courses area End -->
<!--? About Area-1 Start -->
<section class="about-area1 fix pt-10" id="about-section">
    <div class="support-wrapper align-items-center">
        <div class="left-content1">
            <div class="about-icon">
                <img src="assets/img/icon/about.svg" alt="">
            </div>
            <!-- section tittle -->
            <div class="section-tittle section-tittle2 mb-55">
                <div class="front-text">
                    <h2 class="">Learn new skills online</h2>
                    <p>While decades ago, we were limited to the confinements of a library or a classroom, we face no restrictions now. We can learn from the same device that we carry throughout the day, at anytime of the day, and anywhere we are.</p>
                </div>
            </div>
        </div>
        <div class="right-content1">
            <!-- img -->
            <div class="right-img">
                <img src="/assets/img/gallery/about2.png" alt="">
                <div class="video-icon" >
                    <a class="popup-video btn-icon" href="https://www.youtube.com/watch?v=qhd0Ce4Rsyk"><i class="fas fa-play"></i></a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- About Area End -->
<!--? About Area-3 Start -->
<section class="about-area3 fix">
    <div class="support-wrapper align-items-center">
        <div class="right-content3">
            <!-- img -->
            <div class="right-img">
                <img src="assets/img/gallery/about3.png" alt="">
            </div>
        </div>
        <div class="left-content3">
            <!-- section tittle -->
            <div class="section-tittle section-tittle2 mb-20">
                <div class="front-text">
                    <h2 class="">Explore new skills, deepen existing passions, and get lost in creativity. What you find just might surprise and inspire you.</h2>
                </div>
            </div>
        </div>
    </div>
</section>


@endsection