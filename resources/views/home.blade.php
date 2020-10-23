@extends('layouts.student.short-app')
@section('title', '')
@section('content')
@prepend('page-css')
<style>
	.course-header {
		background :#FBFBFB;
		width:100%;
		height : 9vh;
	}
	.cursor-pointer  {
		cursor: pointer;
	}
</style>
@endprepend
<div class="card text-dark rounded-0">
	<div class="card-body">
		<div class="row mb-4">
			<div class="col-lg-auto">
				<img src="{{ $student->profile }}" alt="" class="img-fluid rounded-circle">
			</div>
			<div class="col-lg-auto">
				<h2 class="text-capitalize">{{ $student->name }}</h2>
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
		@if($studentCourses->count() === 0)
		<div class="text-center">
			<img src="https://res.cloudinary.com/dfm6cr1l9/image/upload/v1601806532/no-courses_rrzfqi.png" alt="">
		</div>
		<br>
		<span>No recent courses</span>
		@else
		<div class="row">
			<div class="col-lg-6">
				<div class="card rounded-0">
					<a href="/student/course/view/{{$currentCourse->id}}">
						<div class="course-header" data-background="{{ str_replace(['c_fit,', 'w_150', 'h_150,'], '', Auth::user()->courses->last()->course->image) }}"></div>
					</a>
					
					<div class="card-body">
						<div class="text-muted">
							<span>{{ $currentCourse->program->name }}</span>
						</div>
						<span>
							@php
								$recentHasStar = $currentCourse->status && $currentCourse->status->count() !== 0 && $currentCourse->status->first()->star === 1 ? '' : 'd-none';
							@endphp
						
							<i class="fas fa-star text-primary recent-star-icon-{{ $currentCourse->id }} {{ $recentHasStar}}"></i>
							<a href="/student/course/view/{{ $currentCourse->id }}">{{ $currentCourse->name }}</a>
						</span>
					</div>
				</div>
			</div>
		</div>
		@endif
	</div>
</div>
<div class="card text-dark rounded-0 mt-4" style="border-top: 2px solid #1177d1;">
	<div class="card-body">
		<div class="row">
			<div class="col-lg-auto">
				<h5>Course overview</h5>
			</div>
		</div>
		<div class="row mb-1">
			<div class="col-lg-6">
				<div class="dropdown text-dark">
					<button class="btn rounded-0 btn-outline-secondary border-dark dropdown-toggle" type="button" id="courseViewType" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<i class="fas fa-filter"></i> All (except removed from view)
					</button>
					<div class="dropdown-menu text-dark rounded-0" id="course-view-type-menu" aria-labelledby="courseViewType">
						<a class="dropdown-item" data-type="except_view">All (except removed from view)</a>
						<div class="dropdown-divider"></div>
						<a class="cursor-pointer dropdown-item " data-type="in_progress">In progress</a>
						<a class="cursor-pointer dropdown-item" data-type="future">Future</a>
						<a class="cursor-pointer dropdown-item" data-type="past">Past</a>
						<div class="dropdown-divider"></div>
						<a class="cursor-pointer dropdown-item" data-type="starred">Starred</a>
						<div class="dropdown-divider"></div>
						<a class="cursor-pointer dropdown-item" data-type="remove_from_view">Remove from view</a>
					</div>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="row float-right">
					<div class="col-lg-auto">
						<div class="dropdown text-dark">
							<button class="btn rounded-0 btn-outline-secondary border-dark dropdown-toggle" type="button" id="courseViewType" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							 Course name
							</button>
							<div class="dropdown-menu text-dark rounded-0" id="course-view-type-menu" aria-labelledby="courseViewType">
								<a class="cursor-pointer dropdown-item" data-type="course_name">Course name</a>
								<a class="cursor-pointer dropdown-item " data-type="last_accessed">Last accessed</a>
							</div>
						</div>
					</div>
					<div class="col-lg-auto">
						<div class="dropdown text-dark">
							<button class="btn rounded-0 btn-outline-secondary border-dark dropdown-toggle" type="button" id="courseDisplayType" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<i class="icon fa fa-th fa-fw "></i> Card
							</button>
							<div class="dropdown-menu text-dark rounded-0" id="display-type" aria-labelledby="courseViewType">
								<a class="cursor-pointer dropdown-item" data-type="card_type">Card</a>
								<a class="cursor-pointer dropdown-item " data-type="list_type">List</a>
								<a class="cursor-pointer dropdown-item " data-type="summary_type">Summary</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div>
			@if($studentCourses->count() === 0)
			<div class="text-center">
				<img src="https://res.cloudinary.com/dfm6cr1l9/image/upload/v1601806532/no-courses_rrzfqi.png" alt="">
				<br>
				<span>No courses</span>
			</div>
			@else
				@foreach($studentCourses as $record)
				@php
					$hasStar = $record->course->status && $record->course->status->count() !== 0 && $record->course->status->star == 1 ? '' : 'd-none';
				@endphp
					@if($record->course->status && $record->course->status->status === 'hide')
						@include('student.includes.remove-from-view')
					@else
						@include('student.includes.show-from-view')
					@endif
				@endforeach
			@endif
		</div>
	</div>
</div>
@push('page-scripts')
<script>
	$.ajaxSetup({
	    headers: {
	        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	    }
	});
</script>
<script>
	let completedActivities = {{ $progress }};

	$('#course-progress').css('width', completedActivities + '%');

	// Add background image per course.
	$('.course-header').each(function (index, element) {
		let background = $(this).attr('data-background');
		$(this).css('background' , `url(${background})`);
		$(this).css('background-size' , 'cover');
		$(this).css('background-position', 'center');
	});

	// Hide and show by display type.
	function processDisplayType(type) {
		switch(type) {
			case 'list_type' :
				$('#view-list-type').removeClass('d-none');
				$('#view-card-type').addClass('d-none');
				$('#view-summary-type').addClass('d-none');
			break;

			case 'summary_type' :
				$('#view-list-type').addClass('d-none');
				$('#view-card-type').addClass('d-none');
				$('#view-summary-type').removeClass('d-none');
			break;

			default :
				$('#view-list-type').addClass('d-none');
				$('#view-card-type').removeClass('d-none');
				$('#view-summary-type').addClass('d-none');
		}
	}

	// Get the selected view type of the user.
	$('#course-view-type-menu a').click(function () {
		let selectedItem = $(this).text();
		let selectedItemType = $(this).attr('data-type');
	});

	// When user select display type then the view.
	$('#display-type a').click(function () {
		let selectedItem = $(this).text();
		let selectedItemType = $(this).attr('data-type');
		processDisplayType(selectedItemType);
		$('#courseDisplayType').html(`<i class="icon fa fa-th fa-fw "></i> ${selectedItem}`);
	});


	$(document).on('click', 'a.add-star-course', function (e) {
		let course_id = $(this).attr('data-id');
		let element = this;
		$.post({
			url : "{{ route('status.store') }}",
			data : { course_id , status : 'show' , star : 1 },
			success : function (response) {
				if (response.success) {
					element.remove();
					$(`.star-icon-${course_id}`).removeClass('d-none');
					$(`.recent-star-icon-${course_id}`).removeClass('d-none');
					$(`.course-${course_id}-option-button`).html('');
					$(`.course-${course_id}-option-button`).append(`<a class="dropdown-item remove-star-course" href="#" data-action="add-favourite" data-id="${course_id}">Unstar this course</a>`);
				}
			}
		});
	});

	$(document).on('click', 'a.remove-star-course', function (e) {
		let course_id = $(this).attr('data-id');
		let element = this;
		$.post({
			url : "{{ route('status.store') }}",
			data : { course_id , status : 'show' , star : 0},
			success : function (response) {
				if (response.success) {
					element.remove();
					$(`.star-icon-${course_id}`).addClass('d-none');
					$(`.recent-star-icon-${course_id}`).addClass('d-none');
					$(`.course-${course_id}-option-button`).html('');
					$(`.course-${course_id}-option-button`).append(`<a class="dropdown-item add-star-course" href="#"  data-action="add-favourite" data-id="${course_id}">Star this course</a>`);
				}
			}
		});
	});

	$(document).on('click', 'a.remove-from-view', function (e) {
		let course_id = $(this).attr('data-id');
		$.ajax({
			url : `/student/course/status/${course_id}`,
			data : { status : 'hide' },
			method : 'PUT',
			success: function (response) {
				// For each view type remove all the card
				$(`.course-card-${course_id}`).each(function (index, card) {
					$(card).addClass('d-none');
				});
			},
		})
	});
	
	
</script>
@endpush
@endsection