@extends('layouts.home.app')
@section('content')
<!--? slider Area Start-->
<section class="slider-area slider-area2">
    <div class="slider-active">
        <!-- Single Slider -->
        <div class="single-slider slider-height2">
            <div class="container">
                <div class="row">
                    <div class="col-xl-8 col-lg-11 col-md-12">
                        <div class="hero__caption hero__caption2">
                            <h1 data-animation="bounceIn" data-delay="0.2s">About course</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--? About Area-1 Start -->
<section class="about-area1 fix pt-10">
    <div class="support-wrapper align-items-center">
        <div class="left-content1">
            <div class="about-icon">
                <img src="/assets/img/icon/about.svg" alt="">
            </div>
            <!-- section tittle -->
            <div class="section-tittle section-tittle2 mb-55">
                <div class="front-text">
                    <h2 class="">{{ $course->name }}</h2>
                    <p>{{ $course->description }}</p>
                </div>
            </div>
            <div class="single-features">
                <div class="features-icon">
                    <img src="/assets/img/icon/right-icon.svg" alt="">
                </div>
                <div class="features-caption">
                    <p>Access this course for free.</p>
                </div>
            </div>
            <div class="single-features">
                <div class="features-icon">
                    <img src="/assets/img/icon/right-icon.svg" alt="">
                </div>
                <div class="features-caption">
                    <p>Modules of this course {{ $course->modules->count() }}.</p>
                </div>
            </div>
            <div class="single-features">
                <div class="features-icon">
                    <img src="/assets/img/icon/right-icon.svg" alt="">
                </div>
                <div class="features-caption">
                    <p>Receive a certification of complete.</p>
                </div>
            </div>
            <div class="single-features">
                <a href="{{ route('register') }}" class="border-btn border-btn2">Access</a>
            </div>
        </div>
        <div class="right-content1">
            <!-- img -->
            <div class="right-img">
                <img src="{{ $course->image }}" alt="">
            </div>
        </div>
    </div>
</section>
<!-- About Area End -->
<br>
@endsection