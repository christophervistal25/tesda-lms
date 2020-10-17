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
			<h2 class="text-dark">{{ $activity->activity_no }} {{ $activity->title }}</h2>
			<br>
			<p class="text-dark">{{ $activity->instructions }}</p>
				{!! $activity->body !!}
			<br>
			<p class="text-dark">Last modified: {{ $activity->updated_at->format('l, j  F Y, h:i A') }}</p>
		</div>
		<hr>
		<div class="container-fluid py-2">
			<div class="row">
				<div class="col-md-4 text-left">
					@if($previous instanceof App\Activity)
						<span class="text-dark mr-3">PREVIOUS ACTIVITY</span>
						<br>
						<a href="{{ route('student.activity.view', $previous->id) }}" class="btn btn-link" title="{{$previous->title}}">◄ {{ $previous->activity_no }} {{ $previous->title }}</a>
					@elseif($previous instanceof App\File)
						<span class="text-dark mr-3">PREVIOUS ACTIVITY</span>
						<br>
						<a href="{{ route('student.course.overview.show.file', [$course->id, $previous->id]) }}" id="prev-activity-link" class="btn btn-link" title="{{ $previous->title }}">◄ {{ $previous->title }}</a>
					@endif
				</div>

				<div class="col-md-4 mt-2">
					<select id="jumpToOptions" class="form-control rounded-0 text-dark">
						<option selected disabled>Jump to...</option>
						
						@foreach($files as $f)
							<option data-link="/student/course/{{ $course->id }}/overview/show/{{ $f->id }}">{{ $f->title }}</option>
						@endforeach

						@foreach($modules as $module)
							@foreach($module->activities as $activity)
								<option {{ $activity->id == $activity_id ? 'selected' : '' }} data-link="/student/activity/view/{{ $activity->id }}">{{ $activity->activity_no }} {{ $activity->title }}</option>
							@endforeach
						@endforeach

						<option {{ $canTakeExam ? '' : 'disabled' }} data-link="/student/final/exam/{{ $moduleWithExam->id }}">{{ $moduleWithExam->exam->title }}</option>

					

					</select>
				</div>
				<div class="col-md-4 text-right">
					@if(!is_null($next->title) && $next instanceof App\Activity)
						<span class="text-dark mr-3">NEXT ACTIVITY</span>
						<br>
						<a href="{{ route('student.activity.view', $next->id) }}" class="btn btn-link" title="{{$next->title}}">{{ $next->activity_no }} {{ $next->title }} ►</a>
					@elseif($next instanceof App\Exam)
						<span class="text-dark mr-3">NEXT ACTIVITY</span>
						<br>
						<a href="{{ route('view.final.exam', $module->id) }}" class="btn btn-link" title="Final Exam">Final Exam  ►</a>
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
	let activityId = "{{ $activity_id }}";
	$(document).ready(function () {
		$.ajax({
				url : "/student/activity/accomplish",
				method : 'POST',
				data : { activity_id : activityId },
				success: (response) => {},
			});
	});

	$('#jumpToOptions').change(function (e) {
		let selectedItemLink = $(this).children("option:selected").attr('data-link');
		location.href = selectedItemLink;
	});
</script>
@endpush
@endsection