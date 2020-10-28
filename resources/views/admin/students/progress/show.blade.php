@extends('layouts.admin.app')
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

@endprepend

{{-- <div class="course-bg"></div> --}}
<div class="card rounded-0 mb-3">
	<div class="card-body">
		<h3 class="text-dark">{{ $student->name }} Module Progress</h3>
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

				      		{!! str_replace('href="/student/', 'href="/admin/', $overview->body) !!}
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
			        				<a href="{{ route('view.final.exam', $module->id) }}" class=" belongs-to-{{ $module->id }}">{{ $module->exam->title }}</a>
			        			
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
									<a class="belongs-to-{{ $module->id }}"  href="{{ route('student.activity.view', $activity->id) }}">{{ $activity->title }}</a>
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
				 	element.setAttribute('src', 'https://res.cloudinary.com/dfm6cr1l9/image/upload/v1602065137/icons/activity-icon/readable_check.webp');
				 	element.setAttribute('data-status', 'check');
				 	
				 	let progressElement = document.querySelector(`#overview-${overviewId}-progress`);
				 	progressElement.style.width = parseFloat(progressElement.style.width) + parseFloat(100 / noOfOverviewFiles) + '%';
				 }

			 	overviewCount++;
			 }
			 
			 	
		}
	});


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

</script>

@endpush
@endsection