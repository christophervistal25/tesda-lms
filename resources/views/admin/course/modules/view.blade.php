@extends('layouts.admin.app')
@section('title', 'View Module')
@section('content')

<div class="card rounded-0 mb-4">
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
			<hr>
			<div class="text-right">
				<a target="_blank" href="{{ route('course.edit', $course) }}" class="btn btn-success btn-sm">Modify</a>
			</div>
		</div>

		<div id="accordion" class="border-0 rounded-0 m-0">

			 <hr>
		  	<div class="card rounded-0 border-0">
			    <div class="card-header border-0"  style="background :white;">
			      <h4 class="mb-0">
			        <button class="btn btn-default btn-block text-left align-middle border-0 rounded-0" style="box-shadow: none;" data-toggle="collapse" data-target="#overview-{{$overview->id}}" aria-expanded="true" aria-controls="overview-{{$overview->id}}">
			          <h4 class="text-primary"> <i class="text-dark fas fa-caret-right"></i> Course Overview</h4>
			        </button>
			      </h4>
			    </div>

			    <div id="overview-{{$overview->id}}" class="collapse" aria-labelledby="overview-{{ $overview->id }}" data-parent="#accordion">
			      <div class="card-body pl-5 pr-5 text-dark">
			        	{!! $overview->body !!}
			        	<hr>
			      		<div class="text-right">
			      			<a target="_blank" href="{{ route('edit.course.overview', $course) }}" class="btn btn-sm btn-success">Modify</a>
			      		</div>

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

		  @foreach($course->modules->where('is_overview', '!=', 1) as $module)
		  <hr>
		  	<div class="card rounded-0 border-0">
			    <div class="card-header border-0" id="{{ $module->title }}" style="background :white;">
			      <h4 class="mb-0">
			        <button class="btn btn-default btn-block text-left align-middle border-0 rounded-0" style="box-shadow: none;" data-toggle="collapse" data-target="#module-{{$module->id}}" aria-expanded="true" aria-controls="module-{{$module->id}}">
			          <h4 class="text-primary text-capitalize"><i class="text-dark fas fa-caret-right"></i> {{ $module->title }}</h4>
			        </button>
			      </h4>
			    </div>

			    <div id="module-{{$module->id}}" class="collapse" aria-labelledby="module-{{ $module->id }}" data-parent="#accordion">
			      <div class="card-body pl-5 pr-5 text-dark">
			        {!! $module->body !!}
			      	@foreach($module->activities->sortBy('activity_no') as $activity)
			      		  @if($activity->downloadable == 0 && !$activity->completion)
								<span>
									<img src="{{ $activity->icon }}">
									<a class="module-activity belongs-to-{{ $module->id }}" data-downloadable="{{ $activity->downloadable }}" data-id="{{ $activity->id }}" data-module="{{ $module->id }}" href="{{ route('activity.view', $activity->id) }}">{{ $activity->activity_no }} {{ $activity->title }}</a>
									<img src="https://res.cloudinary.com/dfm6cr1l9/image/upload/v1602065138/icons/activity-icon/not-check.webp" class="mt-1 float-right" style="cursor:pointer;"  id="checkbox-{{$activity->id}}">
								</span>
								<br><br>
								@elseif($activity->downloadable == 1 && !$activity->completion)
								<span>
									<img src="{{ $activity->icon }}">
									<a class="module-activity belongs-to-{{ $module->id }}" data-downloadable="{{ $activity->downloadable }}" data-module="{{ $module->id }}" data-link="{{ $activity->files[0]->link }}" data-id="{{ $activity->id }}"  href="{{ $activity->files[0]->link }}">{{ $activity->activity_no }} {{ $activity->title }}</a>
									<img src="https://res.cloudinary.com/dfm6cr1l9/image/upload/v1602065138/icons/activity-icon/not-check.webp" class="mt-1 float-right" style="cursor:pointer;" id="checkbox-{{$activity->id}}">
								</span>
								<br><br>
							@endif
			      	@endforeach
			      	@if(!is_null($module->exam))
			      	<span>
		        			<img src="https://res.cloudinary.com/dfm6cr1l9/image/upload/v1601889372/icons/final-exam_mdj9vl.png" style="width:24px;" alt="Final exam">
		        			<a href="{{ route('admin.view.final.exam', $module->id) }}" class=" belongs-to-{{ $module->id }}">{{ $module->exam->title }}</a>
		        			<img src="https://res.cloudinary.com/dfm6cr1l9/image/upload/v1602065138/icons/activity-icon/not-check.webp" class="mt-1 float-right" style="cursor:pointer;" id="checkbox-{{$module->exam->id}}">
		        			<br>
		        			<span class="ml-4">Pass the exam to be able to receive a Certificate of Completion.</span>
	        		</span>
	       			<br><br>
	       			@endif
	       			@foreach($module->activities->where('completion', 1) as $activity)
    				<span>
							<img src="{{ $activity->icon }}">
							<a class="belongs-to-{{ $module->id }}"  href="{{ route('activity.view', $activity->id) }}">{{ $activity->title }}</a>
							<img src="https://res.cloudinary.com/dfm6cr1l9/image/upload/v1602065138/icons/activity-icon/not-check.webp" class="mt-1 float-right" style="cursor:pointer;"  id="checkbox-{{$activity->id}}">
						</span>
						<br><br>
	        		@endforeach
			        <hr>
		      		<div class="text-right">
		      			<a target="_blank" href="{{ route('course.edit.module', [$module->id]) }}" class="btn btn-sm btn-success">Modify</a>
		      		</div>
			        
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
				  <div class="clearfix"></div>
		  @endforeach
		</div>
	</div>
</div>


@push('page-scripts')
<script>
	let links = document.querySelectorAll('a');
	console.log(links);
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
			if (targetElement.getAttribute('data-status') === 'check') {
				targetElement.setAttribute('src', 'https://res.cloudinary.com/dfm6cr1l9/image/upload/v1602065137/icons/activity-icon/checkable.webp');
				targetElement.removeAttribute('data-status');
			} else {
				if (targetElement.getAttribute('src').includes('checkable')) {
					targetElement.setAttribute('src', 'https://res.cloudinary.com/dfm6cr1l9/image/upload/v1602065137/icons/activity-icon/check.webp');
					targetElement.setAttribute('data-status', 'check');
				}
			}
		}
		
	});
</script>
@endpush
@endsection