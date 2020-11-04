@extends('layouts.home.app')
@section('title', 'Sign In')
@prepend('page-css')
<link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet">
<style>
input,span { font-family : "Poppins", sans-serif; }
</style>
@endprepend
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
                            <h1 data-animation="bounceIn" data-delay="0.2s">&nbsp;</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="container mt-5">
    <div class="card shadow">
        <div class="card-body p-0">
            @include('layouts.admin.error')
            <div class="row">
                <div class="col-md-6">
                    <div class="container"style="background :url(https://res.cloudinary.com/dfm6cr1l9/image/upload/v1603900935/icons/ReadingSideDoodle_srngpp.png); width:100%; height : 100%;"></div>
                </div>
                <div class="col-lg-6 p-5">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <h1>Login your account</h1>
                        <hr>
                        <div class="form-group row">
                            <div class="col-md-auto m-0">
                                <span>Email or Username</span>
                            </div>
                            <div class="col-md-12">
                                <input id="email" type="text"  class="p-3 border border-1 w-100" name="login" value="{{ old('login') }}" required >
                            </div>
                        </div>
                        <br>
                        <div class="form-group row">
                            <div class="col-md-auto m-0">
                                <span>Password</span>
                            </div>
                            <div class="col-md-12">
                                <input id="password" type="password" class=" p-3 border border-1 w-100 @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                            </div>
                        </div>
                        <a href="{{ route('register') }}" class="text-primary">Create an account</a>
                        <hr>
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-1">
                                <button type="submit" class="ml-5 btn btn-block">
                                {{ __('Login') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            
        </div>
    </div>
</div>
<br>

@endsection