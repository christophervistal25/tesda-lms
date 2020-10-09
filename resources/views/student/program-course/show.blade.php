@extends('layouts.student.app')
@section('title', '')
@section('content')
<div class="card text-dark rounded-0">
	<div class="card-body">
		<div class="float-right">
			<div class="dropdown">
				<a href="#" tabindex="0" class="d-inline-block  dropdown-toggle icon-no-margin" id="action-menu-toggle-3" aria-label="Actions menu" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" aria-controls="action-menu-3-menu">
					<i class="icon fa fa-cog fa-fw " title="Actions menu" aria-label="Actions menu"></i>
				</a>
				<div class="dropdown-menu dropdown-menu-right menu align-tr-br" id="action-menu-3-menu" data-rel="menu-content" aria-labelledby="action-menu-toggle-3" role="menu" data-align="tr-br">
					<div class="dropdown-item">
						<a href="" id="" class="" role="menuitem"><i class="icon fa fa-check-square-o fa-fw " aria-hidden="true"></i>Competency frameworks</a>
					</div>
				</div>
			</div>
		</div>
		<form class="form-inline">
			<div class="form-group mx-sm-1 mb-2">
				<label>Search courses &nbsp;</label>
				<input type="password" class="form-control rounded-0 " >
			</div>
			<button type="submit" class="btn btn-primary mb-2 rounded-0 border-0 text-dark" style="background :#ced4da;">Go</button>
			<i class="icon fa fa-question-circle text-info fa-fw mb-2 " title="Help with Search courses" aria-label="Help with Search courses"></i>
		</form>
		<br>
		<div class="row">
			@foreach($programCourse->courses as $course)
			<div class="col-lg-3">
				<div class="card rounded-0">
					<img class="card-img-top rounded-0" src="https://res.cloudinary.com/dfm6cr1l9/image/upload/v1601120617/samples/imagecon-group.jpg" alt="Card image cap">
					<div class="card-body">
						<div class="float-left">
							<span class="badge badge-info rounded-0"><a href="{{ route('program.show', $programCourse) }}" class="text-white">{{ $programCourse->name }}</a></span>
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
		</div>
	</div>
</div>
@endsection