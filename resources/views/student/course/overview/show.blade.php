@extends('layouts.student.app')
@section('title', '')
@section('content')

<div class="card rounded-0 mb-4">
	<div class="card-body">
		<h1 class="text-dark">{{ $course->name }}</h1>
	</div>
</div>

<div class="card rounded-0 mb-4">
	<div class="card-body pl-0 pr-0">
		<div class="pl-4 pr-4">
			<h2 class="text-dark">{{ $file->title }} - {{ $course->name }}</h2>
			<br>
			<p class="">
				@if(Str::contains(strtolower($file->title), ['course', 'design']))
					{!! $course->design !!}
					@else
					<span class="text-dark">Click </span> <a href="{{ $file->link }}"> {{ $file->title }} </a> <span class="text-dark">link to view the file.</span>
				@endif
				
			</p>
				
			<br>
			<p class="text-dark">Last modified: {{ $file->updated_at->format('l, j  F Y, h:i A') }}</p>
		</div>
		<hr>
		<div class="container-fluid py-2">
			<div class="row">
				<div class="col-md-4 text-left">
					@if($previous instanceof App\File)
						<span class="text-dark ml-3">PREVIOUS ACTIVITY</span>
						<br>
						<a href="{{ route('student.course.overview.show.file', [$course->id, $previous->id]) }}" id="prev-activity-link" class="btn btn-link" title="{{ $previous->title }}">◄ {{ $previous->title }}</a>
					{{-- @else
						<span class="text-dark ml-3">PREVIOUS ACTIVITY</span>
						<br>
						<a href="">◄ Announcement & Forums</a> --}}
					@endif
					
				</div>

				<div class="col-md-4 mt-2">
					<select id="jumpToOptions" class="form-control rounded-0 text-dark">
						<option selected disabled>Jump to...</option>
						@foreach($files as $f)
						<option {{ $f->id == $fileId ? 'selected' : '' }} data-link="/student/course/{{ $course->id }}/overview/show/{{ $f->id }}">{{ $f->title }}</option>
						@endforeach
						@foreach($modules as $module)
							@foreach($module->activities as $activity)
								<option data-link="/student/activity/view/{{ $activity->id }}">{{ $activity->activity_no }} {{ $activity->title }}</option>
							@endforeach
						@endforeach
					</select>
				</div>

				<div class="col-md-4 text-right">
					@if($next instanceof App\Activity)
						<span class="text-dark mr-3">NEXT ACTIVITY</span>
						<br>
						<a href="{{ route('student.activity.view', $next->id) }}" class="btn btn-link" title="{{ $next->title }}">{{ $next->activity_no }} {{ $next->title }}</a>
					@elseif ($next instanceof App\File)
						<span class="text-dark mr-3">NEXT ACTIVITY</span>
						<br>
						<a href="{{ route('student.course.overview.show.file', [$course->id, $next->id]) }}" class="btn btn-link" title="{{ $next->title }}"> {{ $next->title }}</a>
					@endif
				</div>

			</div>
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
	let fileId = "{{ $fileId }}";

	
	$(document).ready(function () {
		$.ajax({
			url : "{{ route('accomplish.store') }}",
			method : 'POST',
			data : {file_id : fileId},
		});
	});

	$('#jumpToOptions').change(function (e) {
		let selectedItemLink = $(this).children("option:selected").attr('data-link');
		location.href = selectedItemLink;
	});
</script>
@endpush
@endsection