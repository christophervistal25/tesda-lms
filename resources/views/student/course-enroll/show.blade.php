@extends('layouts.student.app')
@section('title', '')
@section('content')
<div class="card text-dark rounded-0">
	<div class="card-body">
		<h3>Enrollment options</h3>
		<br>
		<div class="row">
			<div class="col-lg-4">
				<div class="card rounded-0">
					<img class="card-img-top rounded-0" src="{{ $course->image }}" alt="Card image cap">
					<div class="card-body">
						<div class="float-left">
							<span class="badge badge-info rounded-0"><a href="{{ route('program.show', $course->program->id) }}" class="text-white">{{ $course->program->name }}</a></span>
						</div>
						<div class="clearfix"></div>
						<h4 class="card-title text-left"><a href="">{{ $course->name }}</a></h4>
					</div>
				</div>
			</div>

			<div class="col-lg-8">
				<h4><a href="">Self Enrollment (Student)</a></h4>
				<form action="{{ route('enroll.submit.course', $course->id) }}" method="POST">
					@csrf
					<p class="text-dark text-center">No Enrollment key required</p>
					<div class="pl-3 pr-3">
						<hr>
					</div>
					<div class="text-center">
						<button type="submit" class="btn btn-primary rounded-0">Enroll me</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection