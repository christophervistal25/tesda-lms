@extends('layouts.student.short-app')
@section('title', '')
@section('content')
<div class="card text-dark rounded-0">
	<div class="card-body">
		<div class="row mb-4">
			<div class="col-lg-auto">
				<img src="{{ Auth::user()->profile }}" alt="" class="img-fluid rounded-circle">
			</div>
			<div class="col-lg-auto">
				<h2 class="text-capitalize">{{ Auth::user()->name }}</h2>
			</div>
			<div class="col-lg-auto">
				<span><i class="fas fa-comment"></i> Message</span>
			</div>
		</div>
		<br>
		<div class="float-right">
			<button class="btn btn-light text-dark rounded-0" style="background :#ced4da;">Customise this page</button>
		</div>
		<div class="clearfix"></div>
	</div>
</div>

<div class="card text-dark rounded-0 mt-4" style="border-top: 2px solid #1177d1;">
	<div class="card-body">
		<div class="row mb-4">
			<div class="col-lg-auto">
				<h5>Recently accessed courses</h5>
			</div>
		</div>
		<div class="text-center">
			@if(Auth::user()->courses->count() === 0)
				<img src="https://res.cloudinary.com/dfm6cr1l9/image/upload/v1601806532/no-courses_rrzfqi.png" alt="">
				<br>
				<span>No recent courses</span>
			@endif
		</div>
	</div>
</div>

<div class="card text-dark rounded-0 mt-4" style="border-top: 2px solid #1177d1;">
	<div class="card-body">
		<div class="row mb-4">
			<div class="col-lg-auto">
				<h5>Course overview</h5>
			</div>
		</div>
		<div class="text-center">
			@if(Auth::user()->courses->count() === 0)
				<img src="https://res.cloudinary.com/dfm6cr1l9/image/upload/v1601806532/no-courses_rrzfqi.png" alt="">
				<br>
				<span>No courses</span>
			@endif
		</div>
	</div>
</div>

@endsection