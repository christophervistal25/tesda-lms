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
			<h2 class="text-dark">Final Exam</h2>
			<br>
			<p class="text-dark">Pass the exam to be able to receive a Certificate of Completion</p>
			
			<div class="text-center text-dark">
				<p>Attempts allowed: 3</p>
				<p>Grading method: Highest grade</p>
			</div>
		 <h3 class="text-dark">Summary of your previous attempts</h3>
		 <table class="table table-striped table-hover">
		 	<thead>
		 		<tr class="text-dark text-center">
		 			<th>Attempt</th>
		 			<th>State</th>
		 			<th>Review</th>
		 		</tr>
		 	</thead>
		 	<tbody>
		 		<tr class="text-dark text-center">
		 			<td>{{ Auth::user()->exam_attempt->count() ?? 0 }}</td>
		 			<td>{{ Auth::user()->exam_attempt->count() != 0 ? 'In Progress' : '' }}</td>
		 			<td></td>
		 		</tr>
		 	</tbody>
		 </table>
		 <div class="text-center">

		 	@if(is_null(Auth::user()->exam_attempt))
		 		<a href="{{ route('user.add.attempt', $module) }}" class="btn rounded-0 text-dark" style="background :#ced4da">Take Final Exam</a>
		 	@else
		 		<a href="{{ route('answer.final.exam', $module) }}" class="btn rounded-0 text-dark" style="background :#ced4da">Continue the last attempt</a>
		 	@endif
		 	
		 </div>
		</div>
		<hr>
		<div class="container-fluid py-2">
			<div class="row">
				{{-- <div class="col-md-4 text-left">
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
 --}}
			{{-- 	<div class="col-md-4 mt-2">
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

					

					</select>
				</div> --}}

			</div>
		</div>
	</div>

</div>

@push('page-scripts')

<script>
	$('#jumpToOptions').change(function (e) {
		let selectedItemLink = $(this).children("option:selected").attr('data-link');
		location.href = selectedItemLink;
	});
</script>
@endpush
@endsection