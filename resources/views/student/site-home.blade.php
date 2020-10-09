@extends('layouts.student.short-app')
@section('title', '')
@section('content')
<div class="card text-dark rounded-0">
	<div class="card-body">
		<div class="row mb-4">
			<div class="col-lg-auto py-2">
				<h3>Site Announcements</h3>
			</div>
		</div>
		<br>
		<div class="float-right">
			<a class="text-primary" href="">Subscribe to this forum</a>
		</div>
		<div class="clearfix"></div>

		<form class="form-inline">
		  <div class="form-group mx-sm-1 mb-2">
		    <label>Search courses &nbsp;</label>
		    <input type="password" class="form-control rounded-0 " >
		  </div>
		  <button type="submit" class="btn btn-primary mb-2 rounded-0 border-0 text-dark" style="background :#ced4da;">Go</button>
		  <i class="icon fa fa-question-circle text-info fa-fw mb-2 " title="Help with Search courses" aria-label="Help with Search courses"></i>
		</form>
		<br>
		<h3 class="text-dark">Course Categories</h3>
		<br>
		@foreach($programs as $program)
			<h4 class="ml-2"><i class="fas fa-caret-right "></i> <a href="{{ route('program.show', $program) }}">{{ $program->name }}</a> <span style="font-size: 13px;">({{ $program->courses->count() }})</span></h4>
		@endforeach

		<div class="text-center">
			<h3 class="text-primary">Available courses</h3>
			<div class="row">
				@foreach($programs as $program)
					@foreach($program->courses as $course)
						<div class="col-lg-3">
							<div class="card rounded-0">
								<img class="card-img-top rounded-0" src="{{ $course->image }}" alt="Card image cap">
								<div class="card-body">
									<div class="float-left">
										<span class="badge badge-info rounded-0"><a href="{{ route('program.show', $program) }}" class="text-white">{{ $program->name }}</a></span>
									</div>
									<div class="clearfix"></div>
									<h5 class="card-title text-left"><a href="{{ route('enroll.course', $course->id) }}">{{ $course->name }}</a></h5>
								</div>
								<div class="card-footer">
									<div class="float-left">
										<i class="fas fa-sign-in-alt"></i>
									</div>
										<div class="float-right">
											<a class="card-link btn btn-primary rounded-0" href="{{ route('enroll.course', $course->id) }}">Access</a>
										</div>
								</div>
							</div>
						</div>
					@endforeach
				@endforeach	
			</div>
			
		</div>
	</div>
</div>
@endsection