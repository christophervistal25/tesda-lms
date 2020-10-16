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
		@if(Auth::user()->courses->count() === 0)
		<div class="text-center">
			<img src="https://res.cloudinary.com/dfm6cr1l9/image/upload/v1601806532/no-courses_rrzfqi.png" alt="">
		</div>
		<br>
		<span>No recent courses</span>
		@else
		<div class="row">
			<div class="col-lg-6">
				<div class="card rounded-0">
					<a href="/student/course/view/{{Auth::user()->courses->last()->course->id}}">
						<div class="course-header" data-background="{{ str_replace(['c_fit,', 'w_150', 'h_150,'], '', Auth::user()->courses->last()->course->image) }}"></div>
					</a>
					
					<div class="card-body">
						<div class="text-muted">
							<span>{{ Auth::user()->courses->last()->course->program->name }}</span>
						</div>
						<span id="recent-course-name-{{ Auth::user()->courses->last()->course->id }}">
							@if(Auth::user()->courses->last()->course->status->first()->star === 1)
									<i id="recent-star-icon-{{Auth::user()->courses->last()->course->id }}" class="fas fa-star text-primary"></i>
							@endif
							<a href="/student/course/view/{{Auth::user()->courses->last()->course->id}}">{{ Auth::user()->courses->last()->course->name }}</a>
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
				
					<div class="row">
						<div class="col-lg-6" id="view-card-type">
							<div class="card rounded-0">
								<a href="/student/course/view/{{$record->course->id}}}">
									<div class="course-header" data-background="{{ str_replace(['c_fit,', 'w_150', 'h_150,'], '', $record->course->image) }}"></div>
								</a>
								<div class="card-body">
									<div class="row">
										<div class="col-lg-10">
											<div class="text-muted">
												<span>{{ $record->course->program->name }}</span>
											</div>
											<span id="course-name-{{ $record->course->id }}">
												@if($record->course->status->first()->star == 1)
													<i id="star-icon-{{ $record->course->id }}" class="fas fa-star text-primary"></i>
												@endif
												<a  href="/student/course/view/{{ $record->course->id }}">{{ $record->course->name }}</a>
											</span>
										</div>
										<div class="col-lg-2 text-right">
											<button class="btn btn-link btn-icon icon-size-3 coursemenubtn" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="yui_3_17_2_1_1602503905824_137">
											<i class="icon fa fa-ellipsis-h fa-fw"></i>
											</button>
											<div class="dropdown-menu dropdown-menu-right rounded-0 text-dark" style="will-change: transform;">
												<div id="course-{{$record->course->id}}-option-button">
													@if($record->course->status->first()->star == 1)
														<a class="dropdown-item cursor-pointer" id="remove-star-course-{{ $record->course->id }}" data-id="{{ $record->course->id }}">
														Unstar this course
													</a>
													@else
														<a class="dropdown-item cursor-pointer" id="add-star-course-{{ $record->course->id }}" data-id="{{ $record->course->id }}">
														Star this course
														</a>	
													@endif	
												</div>
												
												<a class="dropdown-item cursor-pointer remove-from-view" data-id="{{ $record->course->id }}">
													Remove from view
												</a>
											</div>
										</div>
									</div>
									
									<div class="pt-3">
										<div class="progress rounded-0" style="height : .8vh">
											<div class="progress-bar" id="course-progress" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width:{{ $progress }}%;"></div>
										</div>
									</div>
									<div class="mt-3">
										<span><small><b>{{ $progress }}</b>% complete</small></span>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-12 d-none" id="view-list-type">
							<div class="card rounded-0">
								<div class="card-body">
									<div class="row">
										<div class="col-lg-5">
											{{ Auth::user()->courses->last()->course->program->name }}
											<br>
											<span id="course-name-{{ $record->course->id }}">
												@if($record->course->status->first()->star == 1)
													<i id="star-icon-{{ $record->course->id }}" class="fas fa-star text-primary"></i>
												@endif
												<a  href="/student/course/view/{{ $record->course->id }}">{{ $record->course->name }}</a>
											</span>
										</div>
										<div class="col-lg-5">
											<div class="progress rounded-0" style="height : .8vh">
												<div class="progress-bar" id="course-progress" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width:{{ $progress }}%;"></div>
											</div>
											<div class="py-2 mt-1 small">
												<span><b>{{ $progress }}</b>% complete</span>
											</div>
										</div>
										<div class="col-lg-2 text-right">
											<button class="btn btn-link btn-icon icon-size-3 coursemenubtn" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="yui_3_17_2_1_1602503905824_137">
											<i class="icon fa fa-ellipsis-h fa-fw " aria-hidden="true" id="yui_3_17_2_1_1602503905824_136"></i>
											</button>
											<div class="dropdown-menu dropdown-menu-right rounded-0">
												{{-- INSERT BUTTON --}}
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-12 d-none" id="view-summary-type">
							<div class="card rounded-0" style="background :#eef5f9">
								<div class="card-body">
									<div class="row">
										<div class="col-lg-1">
											<img class="img-thumbnail img-fluid rounded-circle" src="{{ Auth::user()->courses->last()->course->image }}" alt="">
										</div>
										<div class="col-lg-5">
											<span class="text-muted">{{ Auth::user()->courses->last()->course->program->name }}</span>
											<br>
											<span id="course-name-{{ $record->course->id }}">
												@if($record->course->status->first()->star == 1)
													<i id="star-icon-{{ $record->course->id }}" class="fas fa-star text-primary"></i>
												@endif
												<a  href="/student/course/view/{{ $record->course->id }}">{{ $record->course->name }}</a>
											</span>
										</div>
										<div class="col-lg-4">
											<br>
											<br>
											<div class="progress rounded-0" style="height : .8vh">
												<div class="progress-bar" id="course-progress" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width:{{ $progress }}%;"></div>
											</div>
											<div class="py-2 mt-1 small">
												<span><b>{{ $progress }}</b>% complete</span>
											</div>
										</div>
										<div class="col-lg-2 text-right">
											<button class="btn btn-link btn-icon icon-size-3 coursemenubtn" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="yui_3_17_2_1_1602503905824_137">
											<i class="icon fa fa-ellipsis-h fa-fw"></i>
											</button>
											<div class="dropdown-menu dropdown-menu-right rounded-0" style="will-change: transform;">
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
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

	$('.course-header').each(function (index, element) {
		let background = $(this).attr('data-background');
		$(this).css('background' , `url(${background})`);
		$(this).css('background-size' , 'cover');
		$(this).css('background-position', 'center');
	});

	$('#course-view-type-menu a').click(function () {
		let selectedItem = $(this).text();
		let selectedItemType = $(this).attr('data-type');
		console.log(selectedItem);
	});

	let processDisplayType = (type) => {
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
	};
	
	$('#display-type a').click(function () {
		let selectedItem = $(this).text();
		let selectedItemType = $(this).attr('data-type');
		processDisplayType(selectedItemType);
		$('#courseDisplayType').html(`<i class="icon fa fa-th fa-fw "></i> ${selectedItem}`);
	});


	$(document).on('click', 'a', function (e) {
		if ($(this).attr('id') != null && $(this).attr('id').includes('add-star')) {
			let course_id = $(this).attr('data-id');
			let element = this;
			$.post({
				url : "{{ route('status.store') }}",
				data : { course_id , status : 'show' , star : 1},
				success : function (response) {
					if (response.success) {
						$(`#course-name-${course_id}`).prepend(`<i id="star-icon-${course_id}" class="fas fa-star text-primary"></i>`);
						$(`#recent-course-name-${course_id}`).prepend(`<i id="recent-star-icon-${course_id}" class="fas fa-star text-primary"></i>`);
						element.remove();
						$(`#course-${course_id}-option-button`).html('');
						$(`#course-${course_id}-option-button`).append(`
							<a class="dropdown-item " href="#" id="remove-star-course-${course_id}" data-action="add-favourite" data-id="${course_id}">Unstar this course</a>
						`);
					}
				}
			});
		} else if($(this).attr('id') != null && $(this).attr('id').includes('remove-star')) {
			let course_id = $(this).attr('data-id');
			let element = this;
			$.post({
				url : "{{ route('status.store') }}",
				data : { course_id , status : 'show' , star : 0},
				success : function (response) {
					if (response.success) {
						$(`#star-icon-${course_id}`).remove();
						$(`#recent-star-icon-${course_id}`).remove();
						element.remove();
						$(`#course-${course_id}-option-button`).html('');
						$(`#course-${course_id}-option-button`).append(`
							<a class="dropdown-item " href="#" id="add-star-course-${course_id}" data-action="add-favourite" data-id="${course_id}">Star this course</a>
						`);
					}
				}
			});
		} else {

		}

		
	});
</script>
@endpush
@endsection