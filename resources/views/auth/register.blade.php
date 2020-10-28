@extends('layouts.home.app')
@section('title', 'Sign Up')
@prepend('page-css')
<link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet">
    <style>
        input,span,li.errors { font-family : "Poppins", sans-serif; }
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
@if($errors->any())
<div class="container mt-5">
    <div class="alert alert-danger" role="alert">
        @foreach($errors->all() as $error)
        <li class="errors">• {{ $error }}</li>
        @endforeach
    </div>
</div>
@else
<div class="container mt-5">
    <div class="alert alert-danger text-center" role="alert">
        <span>All fields with * is required</span>
    </div>
</div>
@endif
<div class="container mt-5">
    <div class="card shadow">
        <div class="card-body p-0">
            <div class="row">
                <div class="col-md-6">
                    <div class="container"style="background :url(https://res.cloudinary.com/dfm6cr1l9/image/upload/v1603900935/icons/ReadingSideDoodle_srngpp.png); background-repeat :no-repeat; width:100%; height : 100%;"></div>
                </div>
                <div class="col-lg-6 p-5">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <h1>Create an account</h1>
                        <hr>
                        <div class="form-group row">
                            <div class="col-md-auto m-0">
                                <span>Username <span class="text-danger">*</span></span>
                            </div>
                            <div class="col-md-12">
                                <input id="text" type="text" class="p-3 border border-1 w-100 " name="username" value="{{ old('username') }}"  autocomplete="email" autofocus>
                            </div>
                        </div>
                        <br>
                        <div class="form-group row">
                            <div class="col-md-auto m-0">
                                <span>Password <span class="text-danger">*</span></span>
                            </div>
                            <div class="col-md-12">
                                <input id="password" type="password" class="p-3 border border-1 w-100 " name="password"  autocomplete="current-password">
                                <div class="col-md-auto m-0">
                                    <span class="text-danger"><small>8 characters, 1 digit, 1 lower case and non alpha numeric characters such as *,- or #</small></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-auto m-0">
                                <span>Email <span class="text-danger">*</span></span>
                            </div>
                            <div class="col-sm-12">
                                <input type="text" class="p-3 border border-1 w-100" name="email" id="inputEmail" value="{{ old('email') }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-auto m-0">
                                <span>Firstname <span class="text-danger">*</span></span>
                            </div>
                            <div class="col-sm-12">
                                <input type="text" class="p-3 border border-1 w-100" name="first_name" value="{{ old('first_name') }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <span for="inputSurname" class="col-sm-auto">Surname <span class="text-danger">*</span></span>
                            <div class="col-sm-12">
                                <input type="text" class="p-3 border border-1 w-100" name="surname" id="inputSurname" value="{{ old('surname') }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputCityTown" class="col-sm-auto text-dark">City/Town <span class="text-danger">*</span></label>
                            <div class="col-sm-12">
                                <input type="text" class="p-3 border border-1 w-100" name="city_town" id="inputCityTown" value="{{ old('city_town') }}">
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-1">
                                <button type="submit" class="ml-5 btn btn-block text-white">
                                {{ __('Join for free') }}
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