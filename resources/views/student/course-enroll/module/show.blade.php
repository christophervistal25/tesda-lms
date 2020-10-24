@extends('layouts.student.app')
@section('title', '')
@section('content')
@prepend('meta-data')
  <meta name="overview-files" content="{{ $overviewFiles }}">
  <meta name="student-files-accomplish" content="{{ $studentAccomplish }}">
  <meta name="student-activities-accomplish" content="{{ $noOfAccomplishActivityByModule }}">
  <meta name="student-exam-accomplish" content="{{ $studentAccomplishExam->toJson() }}">
  <meta name="student-exam-accomplish-by-module" content="{{ $accomplishExamByModule }}">
@endprepend
@prepend('page-css')
{{-- <style type="text/css">
	.course-bg {
		width : auto;
		height : 30vh;
		background:url('{{$course->image}}') bottom center;
		position: fixed;
		right : 0%;
		left :0%;
		top :7%;
		z-index: 1;
	}
</style> --}}
@endprepend

{{-- <div class="course-bg"></div> --}}
<div class="card rounded-0 mb-3">
	<div class="card-body">
		<h3 class="text-dark">{{ $course->name }}</h3>
	</div>
</div>

<div class="card rounded-0 mb-4">
	<div class="card-body pl-0 pr-0">
		<div class="p-4">

			<h4 class="text-primary mb-4">Course Introduction</h4>
			<h4 class="text-dark">Welcome to {{ $course->name }} Course!</h4>
			<p class="text-dark">{{ $course->description }}</p>
			<p class="text-dark">
				Teacher : 
				@foreach($course->instructors as $instructor)
					<span class="badge badge-pill badge-primary p-2">{{ $instructor->lastname }}, {{ $instructor->firstname}} {{ $instructor->middlename }}</span>
				@endforeach
			</p>
			<p class="text-dark">
				Normal Duration : {{ $course->duration }}
			</p>
		</div>

		<div id="accordion" class="border-0 rounded-0 m-0">

				<hr>
			  	<div class="card rounded-0 border-0">
				    <div class="card-header border-0"  style="background :white;">
				      
				      <div class="row">
				      	  <div class="col-lg-10">
				      	  	<h4 class="mb-0">
						        <button class="btn btn-default btn-block text-left align-middle border-0 rounded-0" style="box-shadow: none;" data-toggle="collapse" data-target="#overview-{{$overview->id}}" aria-expanded="true" aria-controls="overview-{{$overview->id}}">
						          <h4 class="text-primary"> <i class="text-dark fas fa-caret-right"></i> Course Overview</h4>
						        </button>
					      	</h4>
				      	  </div>
				      	  <div class="col-lg-2 mt-2">
				      	  	<div class="progress rounded-0" style="height : 20%;">
							  <div class="progress-bar" id="overview-{{$overview->id}}-progress" role="progressbar" style="width: 0%;"  aria-valuemin="0" aria-valuemax="100"></div>
							</div>
				      	  </div>
				      </div>
				    </div>

				    <div id="overview-{{$overview->id}}" class="collapse" aria-labelledby="overview-{{ $overview->id }}" data-parent="#accordion">
				      <div class="card-body pl-5 pr-5 text-dark">
				      		{!! $overview->body !!}
				      </div>
				    </div>
				  </div>
				
				  <div class="float-right py-2 mr-3 text-dark">
				  	Label: 1 &nbsp;
				  	@if($overview->files->where('type', 'page')->count() >= 2)
				  		Pages: {{ $overview->files->where('type', 'page')->count() }} &nbsp;
				  		@else
				  		Page: {{ $overview->files->where('type', 'page')->count() }} &nbsp;
				  	@endif

				  	@if($overview->files->where('type', 'file')->count() >= 2)
				  		Files: {{ $overview->files->where('type', 'file')->count() }} 
				  		@else
				  		File: {{ $overview->files->where('type', 'file')->count() }} 
				  	@endif
				  </div>
				  <div class="clearfix"></div>

		  @foreach($course->modules->where('is_overview', 0) as $module)
		  <hr>
		  	<div class="card rounded-0 border-0">
			    <div class="card-header border-0" id="{{ $module->title }}" style="background :white;">
			      <div class="row">
			      	<div class="col-lg-10">
			      	  <h4 class="mb-0">
				        <button class="btn btn-default btn-block text-left align-middle border-0 rounded-0" style="box-shadow: none;" data-toggle="collapse" data-target="#module-{{$module->id}}" aria-expanded="true" aria-controls="module-{{$module->id}}">
				          <h4 class="text-primary text-capitalize"><i class="text-dark fas fa-caret-right"></i> {{ $module->title }}</h4>
				        </button>
				      </h4>
			      	</div>
			      	<div class="col-lg-2 mt-2">
						<div class="progress rounded-0" style="height : 20%;">
							<div class="progress-bar" role="progressbar" id="progress-{{ $module->id }}" style="width: 0%;"  aria-valuemin="0" aria-valuemax="100"></div>
						</div>
			      	</div>	
			      </div>	
			    </div>

			    <div id="module-{{$module->id}}" class="collapse" aria-labelledby="module-{{ $module->id }}" data-parent="#accordion">
			      <div class="card-body pl-5 pr-5 text-dark">
			      	@php $isFinalExamination = false @endphp
			        {!! $module->body !!}
			        	@foreach($module->activities->sortBy('activity_no') as $activity)
			        		@if($activity->downloadable == 0 && !$activity->completion)
								<span>
									<img src="{{ $activity->icon }}">
									<a class="module-activity belongs-to-{{ $module->id }}" data-downloadable="{{ $activity->downloadable }}" data-id="{{ $activity->id }}" data-module="{{ $module->id }}" href="{{ route('student.activity.view', $activity->id) }}">{{ $activity->activity_no }} {{ $activity->title }}</a>
									@if(in_array($activity->id, $studentActivitiesAccomplish))
									<img src="https://res.cloudinary.com/dfm6cr1l9/image/upload/v1602065138/icons/activity-icon/readable_check.webp" class="mt-1 float-right" style="cursor:pointer;">
									@else
									<img src="https://res.cloudinary.com/dfm6cr1l9/image/upload/v1602065138/icons/activity-icon/not-check.webp" class="mt-1 float-right" style="cursor:pointer;"  id="checkbox-{{$activity->id}}">
									@endif
								</span>
								<br><br>
								@elseif($activity->downloadable == 1 && !$activity->completion)
								<span>
									<img src="{{ $activity->icon }}">
									<a class="module-activity belongs-to-{{ $module->id }}" data-downloadable="{{ $activity->downloadable }}" data-module="{{ $module->id }}" data-link="{{ $activity->files[0]->link }}" data-id="{{ $activity->id }}"  href="{{ $activity->files[0]->link }}">{{ $activity->activity_no }} {{ $activity->title }}</a>
									@if(in_array($activity->id, $studentActivitiesAccomplish))
									<img src="https://res.cloudinary.com/dfm6cr1l9/image/upload/v1602065138/icons/activity-icon/readable_check.webp" class="mt-1 float-right" style="cursor:pointer;">
									@else
									<img src="https://res.cloudinary.com/dfm6cr1l9/image/upload/v1602065138/icons/activity-icon/not-check.webp" class="mt-1 float-right" style="cursor:pointer;" id="checkbox-{{$activity->id}}">
									@endif
								</span>
								<br><br>
							@endif
			        	@endforeach
	        			@if(!is_null($module->exam))
	        				<span>
			        			<img src="https://res.cloudinary.com/dfm6cr1l9/image/upload/v1601889372/icons/final-exam_mdj9vl.png" style="width:24px;" alt="Final exam">
			        			@if($canTakeExam)
			        				<a href="{{ route('view.final.exam', $module->id) }}" class=" belongs-to-{{ $module->id }}">{{ $module->exam->title }}</a>
			        			@else
			        				<a href="#" id="warning-cant-exam" class="belongs-to-{{ $module->id }}">{{ $module->exam->title }}</a>
			        			@endif
			        			
			        			@if(in_array($module->exam->id, $studentAccomplishExam->toArray()))
									<img src="https://res.cloudinary.com/dfm6cr1l9/image/upload/v1603003803/icons/activity-icon/completion-auto-pass_a4ca9d.png" class="mt-1 float-right" style="cursor:pointer;">
									@else
									<img src="https://res.cloudinary.com/dfm6cr1l9/image/upload/v1602065138/icons/activity-icon/not-check.webp" class="mt-1 float-right" style="cursor:pointer;" id="checkbox-{{$module->exam->id}}">

								@endif
			        			<br>
			        			<span class="ml-4">Pass the exam to be able to receive a Certificate of Completion.</span>
		        			</span>
		        			<br><br>
	        			@endif
	        			@foreach($module->activities->where('completion', 1) as $activity)
	        				<span>
									<img src="{{ $activity->icon }}">
									@if($canDownloadCertificate)
										<a class="belongs-to-{{ $module->id }}"  href="{{ route('student.activity.view', $activity->id) }}">{{ $activity->title }}</a>
									@else
										<a class="belongs-to-{{ $module->id }}"  href="#">{{ $activity->title }}</a>
									@endif
									@if(in_array($activity->id, $studentActivitiesAccomplish))
									<img src="https://res.cloudinary.com/dfm6cr1l9/image/upload/v1602065138/icons/activity-icon/readable_check.webp" class="mt-1 float-right" style="cursor:pointer;">
									@else
									<img src="https://res.cloudinary.com/dfm6cr1l9/image/upload/v1602065138/icons/activity-icon/not-check.webp" class="mt-1 float-right" style="cursor:pointer;"  id="checkbox-{{$activity->id}}">
									@endif
								</span>
								<br><br>
	        			@endforeach

					</div>
			      </div>
			    </div>
			    <div class="float-right py-2 mr-3 text-dark">
				  	Label: 1 &nbsp;
				  	@if($module->activities->where('downloadable', 0)->count() >= 2)
				  		Pages: {{ $module->activities->where('downloadable', 0)->count() }} &nbsp;
				  		@else
				  		Page: {{ $module->activities->where('downloadable', 0)->count() }} &nbsp;
				  	@endif

				  	@if($module->activities->where('downloadable', 1)->count() >= 2)
				  		Files: {{ $module->activities->where('downloadable', 1)->count() }} &nbsp;
				  		@else
				  		File: {{ $module->activities->where('downloadable', 1)->count() }} &nbsp; 
				  	@endif
			  		
			  		@if(!is_null($module->exam))
			  			Quiz: {{ $module->exam->count() }} &nbsp;
			  		@endif
				  </div>
			  </div>
			  
				<div class="clearfix"></div>
		  @endforeach


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
	let noOfOverviewFiles         = {{ $noOfOverviewFiles }};
	let overviewId                = {{ $overview->id }};
	let overviewCount             = 0;
	const overviewFiles           = JSON.parse($('meta[name="overview-files"]').attr('content'));
	const accomplishOverviewFiles = JSON.parse($('meta[name="student-files-accomplish"]').attr('content'));
	// get all activity checkbox icons
	document.querySelectorAll('img').forEach((element, index) => {
		// Align the checkbox in right
		if (element.getAttribute('src').includes('activity-icon')) {
			// Only interesed in overview files not in other activities.
			 if (noOfOverviewFiles > overviewCount) {
			 	element.classList.add('float-right');
			 	element.setAttribute('style', 'cursor:pointer;');
			 	element.classList.add('overview-activity-status');
			 	element.setAttribute('data-id', overviewFiles[overviewCount].id);
				element.setAttribute('data-tyep', 'file');

				 if (accomplishOverviewFiles.includes(overviewFiles[overviewCount].id)) {
				 	element.setAttribute('src', 'https://res.cloudinary.com/dfm6cr1l9/image/upload/v1602065137/icons/activity-icon/check.webp');
				 	element.setAttribute('data-status', 'check');
				 	
				 	let progressElement = document.querySelector(`#overview-${overviewId}-progress`);
				 	progressElement.style.width = parseFloat(progressElement.style.width) + parseFloat(100 / noOfOverviewFiles) + '%';
				 }

			 	overviewCount++;
			 }
			 
			 	
		}
	});

	document.body.addEventListener('click', (e) => {
		let targetElement = e.target;

		// Check if the element is checkbox or activity status
		if (targetElement.tagName == 'IMG' && targetElement.getAttribute('class') != null && targetElement.getAttribute('class').includes('overview-activity-status')) {
			// Checking if the checbox is already check
			if (targetElement.getAttribute('data-status') === 'check') {
				targetElement.setAttribute('src', 'https://res.cloudinary.com/dfm6cr1l9/image/upload/v1602065137/icons/activity-icon/checkable.webp');
				targetElement.removeAttribute('data-status');
				removeProgress(targetElement);
			} else {
				// Change the src element to check.
				if (targetElement.getAttribute('src').includes('checkable')) {
					targetElement.setAttribute('src', 'https://res.cloudinary.com/dfm6cr1l9/image/upload/v1602065137/icons/activity-icon/check.webp');
					targetElement.setAttribute('data-status', 'check');
					applyProgress(targetElement);
				}
			} 
		} else if(targetElement.tagName == 'A' && (targetElement.innerHTML.toLowerCase().includes('course') || targetElement.innerHTML.includes('design')) ) { // Checking if the anchor element click is course design or not.
			e.preventDefault();
			// get the id of the course design 
			const [courseDesigId] = targetElement.getAttribute('href').split('/').slice(-1)
			// get the other information of course design.

			$.ajax({
				url : `/student/course/${courseDesigId}/design`,
				method : 'GET',
				success: (course_design) => {
					sendAccomplish(course_design.id, function () {
						location.href = course_design.link;
					});
				},
			});
		}
	});




	let sendAccomplish = (fileId, callback) => {
		$.ajax({
			url : "{{ route('accomplish.store') }}",
			method : 'POST',
			data : {file_id : fileId},
			success: (response) => {
				if (callback) callback();
			},
		});
	};

	let removeAccomplish = (fileId) => {
		 $.ajax({
			url : `/student/accomplish/${fileId}`,
			method : 'DELETE',
			success: (response) => {

			},
		});
	};

	let applyProgress = (element) => {
		let currentElement     = element.parentElement;
		let documentName = ``;

		currentElement.childNodes.forEach((el) => {
			if (el.tagName === 'A') {
				documentName = el.innerHTML;
			}
		});
		let calculate = 100 / noOfOverviewFiles;
		// console.log(documentName, noOfOverviewFiles, calculate);
		let pElement = document.querySelector(`#overview-${overviewId}-progress`)
		progressCurrentValue = parseFloat(pElement.style.width);
		pElement.style.width = parseFloat(progressCurrentValue + calculate) + '%';
			
		// send
		sendAccomplish(element.getAttribute('data-id'));
	};

	let removeProgress = (element) => {
		let currentElement     = element.parentElement;
		let documentName = ``;

		currentElement.childNodes.forEach((el) => {
			if (el.tagName === 'A') {
				documentName = el.innerHTML;
			}
		});
		let calculate = 100 / noOfOverviewFiles;

		let pElement = document.querySelector(`#overview-${overviewId}-progress`)
		progressCurrentValue = parseFloat(pElement.style.width);

		if (parseInt(progressCurrentValue - calculate) < 0  || parseInt(progressCurrentValue - calculate) == -0 ) {
			pElement.style.width = '0%';
		} else {
			pElement.style.width = parseFloat(progressCurrentValue - calculate) + '%';	
		}
		removeAccomplish(element.getAttribute('data-id'));
		
	};
</script>

{{-- PROCESS CHECK PROGRESS FOR ACTIVITIES --}}
<script>
	let noOfAccomplishActivityByModule = JSON.parse($('meta[name="student-activities-accomplish"]').attr('content'));
	let studentExamAccomplishByModule = JSON.parse($('meta[name="student-exam-accomplish-by-module"]').attr('content'));

	Object.keys(noOfAccomplishActivityByModule).map((id) => {
		let noOfActivities = document.querySelectorAll(`.belongs-to-${id}`).length;
		let progressPerActivity = parseFloat(100 / noOfActivities);
		if (typeof studentExamAccomplishByModule[id] != 'undefined') {
			condition = noOfAccomplishActivityByModule[id].length + studentExamAccomplishByModule[id].length;
		} else {
			condition = noOfAccomplishActivityByModule[id].length;
		}
		
		for(let i = 0; i<condition; i++) {
			progressElement = document.querySelector(`#progress-${id}`);
			progressElement.style.width = parseFloat(progressElement.style.width) + progressPerActivity + '%';
		}
	});

	$('#warning-cant-exam').click(function () {
		alert('Please review all the activities seem\'s like you left something.');
	});

	$(document).on('click', 'a.module-activity', function (e) {
		e.preventDefault();
		let element      = e.target;
		let activityId   = element.getAttribute('data-id');
		let activityType = element.getAttribute('data-downloadable');
		let activityLink = element.getAttribute('data-link');
		let moduleId     = element.getAttribute('data-module');
		let noOfActivities = document.querySelectorAll(`.belongs-to-${moduleId}`).length;

		
		if (activityType != 0) { // if the activity is downloadable
			$.ajax({
				url : "/student/activity/accomplish",
				method : 'POST',
				data : { activity_id : activityId },
				success: (response) => {
					location.href = activityLink;
					$(`#checkbox-${activityId}`).prop('src', 'https://res.cloudinary.com/dfm6cr1l9/image/upload/v1602065138/icons/activity-icon/readable_check.webp');
					let progressElement = document.querySelector(`#progress-${moduleId}`);
					progressElement.style.width = parseFloat(progressElement.style.width) + parseFloat(100 / noOfActivities) + '%';
				},
			});
		} else {
			$.ajax({
				url : "/student/activity/accomplish",
				method : 'POST',
				data : { activity_id : activityId },
				success: (response) => {
					let progressElement = document.querySelector(`#progress-${moduleId}`);
					progressElement.style.width = parseFloat(progressElement.style.width) + parseFloat(100 / noOfActivities) + '%';
					location.href = `/student/activity/view/${activityId}`;
				},
			});
		}
		
	});

</script>

@endpush
@endsection