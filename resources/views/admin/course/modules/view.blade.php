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
			        <button class="btn btn-default btn-block text-left align-middle border-0 rounded-0" style="box-shadow: none;" data-toggle="collapse" data-target="#overview-{{$course->overview->id}}" aria-expanded="true" aria-controls="overview-{{$course->overview->id}}">
			          <h4 class="text-primary"> <i class="text-dark fas fa-caret-right"></i> Course Overview</h4>
			        </button>
			      </h4>
			    </div>

			    <div id="overview-{{$course->overview->id}}" class="collapse" aria-labelledby="overview-{{ $course->overview->id }}" data-parent="#accordion">
			      <div class="card-body pl-5 pr-5 text-dark">
			        	{!! $course->overview->body !!}
			        	<hr>
			      		<div class="text-right">
			      			<a target="_blank" href="{{ route('edit.course.overview', $course) }}" class="btn btn-sm btn-success">Modify</a>
			      		</div>

			      </div>
			    </div>
			  </div>

		  @foreach($course->modules as $module)
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
			        <ul>
			        	@foreach($module->activities as $activity)
			        	@if($activity->downloadable == 0)
			        		<a href="{{ route('activity.view', $activity->id) }}"><p>{{ $activity->activity_no }} {{ $activity->title }}</p></a>
			        		@else
			        		<p>{{ $activity->activity_no }} {!! str_replace(['<p>','</p>'], '',  $activity->body) !!}</p>
			        	@endif
			        	@endforeach	
			        </ul>

			        <hr>
		      		<div class="text-right">
		      			<a target="_blank" href="{{ route('course.edit.module', [$module->id]) }}" class="btn btn-sm btn-success">Modify</a>
		      		</div>
			        
			      </div>
			    </div>
			  </div>
			  <hr>
		  @endforeach
		</div>
	</div>
</div>


@push('page-scripts')
@endpush
@endsection