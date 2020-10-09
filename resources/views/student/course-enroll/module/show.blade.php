@extends('layouts.student.app')
@section('title', '')
@section('content')
@prepend('meta-data')
  <meta name="accomplish" content="{{ @$accomplish->data }}" >
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
				  	Label: 1
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
							<div class="progress-bar" role="progressbar" style="width: 10%;"  aria-valuemin="0" aria-valuemax="100"></div>
						</div>
			      	</div>	
			      </div>	
			    </div>

			    <div id="module-{{$module->id}}" class="collapse" aria-labelledby="module-{{ $module->id }}" data-parent="#accordion">
			      <div class="card-body pl-5 pr-5 text-dark">
			        {!! $module->body !!}
			        <ul>
			        	@foreach($module->activities as $activity)
			        	@php
			        			preg_match( '@src="([^"]+)"@' , $activity->body, $match );
			        			$src = array_pop($match);
			        	@endphp
			        	@if($activity->downloadable == 0)
			        		<div class="container row">
			        			<div class="col-lg-auto p-0">
			        				<img src="{{ $src }}" width="24">
			        			</div>
			        			<div class="col-lg-auto p-1">
			        				<a href="{{ route('student.activity.view', $activity->id) }}"><p>{{ $activity->activity_no }} {{ $activity->title }}</p></a>
			        			</div>
			        		</div>
			        		@else
							 <div class="container row">
							 	<div class="col-lg-auto p-0">
									<img src="{{ $src }}" width="24">
								</div>
								<div class="col-lg-auto p-1">
									<a href="{{ $activity->files[0]->link }}"><p>{{ $activity->activity_no }} {{ $activity->title }}</p></a>
								</div>
							 </div>
			        	@endif
			        	@endforeach	
			        </ul>
			      </div>
			    </div>
			  </div>
			  <div class="float-right py-2 mr-3 text-dark">
			  	Label: 1
			  	@if($module->activities->where('downloadable', 0)->count() >= 2)
			  		Pages: {{ $module->activities->where('downloadable', 0)->count() }} &nbsp;
			  		@else
			  		Page: {{ $module->activities->where('downloadable', 0)->count() }} &nbsp;
			  	@endif

			  	@if($module->activities->where('downloadable', 1)->count() >= 2)
			  		Files: {{ $module->activities->where('downloadable', 1)->count() }} 
			  		@else
			  		File: {{ $module->activities->where('downloadable', 1)->count() }} 
			  	@endif
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
	// get all activity checkbox icons
	document.querySelectorAll('img').forEach((element) => {
		// Align the checkbox in right
		if (element.getAttribute('src').includes('activity-icon')) {
			 element.classList.add('float-right');
			 element.setAttribute('style', 'cursor:pointer;');
			 element.classList.add('activity-status');
		}
	});

	document.body.addEventListener('click', (e) => {
		let targetElement = e.target;
		// Check if the element is checkbox or activity status
		if (targetElement.getAttribute('class').includes('activity-status')) {
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
		}
	});

	let progressDeterminer = (clickedElement) => {
		let secondParentElement = clickedElement.parentElement.parentElement;
		let grandParentElement = secondParentElement.parentElement;

		// get all the numbers of checkbox
		noOfCheckbox = secondParentElement.querySelectorAll('img.activity-status').length;
		percentageByCheckbox = 100 / noOfCheckbox;

		progressElement = document.querySelector(`#${grandParentElement.getAttribute('id')}-progress`);
		let progressCurrentValue = parseInt(progressElement.style.width);
		return [progressElement, progressCurrentValue];
	};

	let elementsCleaner = (element) => {
		let files = [];
		let fileStatus = [];

		element.parentElement.childNodes.forEach((e, i) => {
			if (e.tagName != 'BR' && typeof e.innerHTML != 'undefined') {
				if (e.tagName == 'A') {
					files.push(e.innerHTML);
				}

				if (e.getAttribute('class') != null && e.getAttribute('class').includes('activity-status')) {
					 fileStatus.push(e.getAttribute('data-status'));
				}
			}
		});
		return [files, fileStatus];
	};

	let accomplish = []
	let merger = (files, status) => {
		files.forEach((file, index) => {
			data = { 'name' : file, 'status' : status[index] };
			accomplish.push(data);
		});
		return accomplish;
	};

	let remover = (file) => {
		accomplish = accomplish.filter((f) => f.name != file[0]);
	};



	let sender = (studentAccomplish) => {
		$.ajax({
			url : "{{ route('accomplish.store') }}",
			method : 'POST',
			data : { 'data' : studentAccomplish, 'course' : {{ $course->id }}, 'student' : {{ $student_id}} },
			success: (response) => {
				console.log(response);
			}
		});
	};

	let applyProgress = (element) => {
		let files      = [];
		let fileStatus = [];
		

		[pElement, pCurrentValue] = progressDeterminer(element);
		progressElement.style.width = pCurrentValue + 33 + '%';

		[files, fileStatus] = elementsCleaner(element);
		//sender(merger(files, fileStatus));
	};

	let removeProgress = (element) => {
		let files      = [];
		let fileStatus = [];
		[pElement, pCurrentValue] = progressDeterminer(element); 
		progressElement.style.width = pCurrentValue - 33 + '%';

		[files, fileStatus] = elementsCleaner(element);
		remover(files);
		//sender(accomplish);
	};
</script>
@endpush
@endsection