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
		@if($canTakeExam)
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
		 		<tr class="text-dark">
		 			<th class="text-center">Attempt</th>
		 			<th>State</th>
		 			@if(!is_null($student->exam_attempt->first()) && $student->exam_attempt->first()->result->count() != 0)
		 			<th class="text-center">Marks / {{ $student->exam_attempt->last()->result->count() }}.00</th>
		 			<th class="text-center">Grade / 100.00</th>
		 			@endif
		 			<th class="text-center">Review</th>
		 		</tr>
		 	</thead>
		 	<tbody>
		 			@foreach($student->exam_attempt as $key => $attempt)
		 				<tr class="text-dark">
		 						<td class="text-center align-middle">{{ $key + 1 }}</td>
		 						@if($attempt->result->count() != 0)
		 							<td class="align-middle">
	 									<span class="text-left">Finished</span>
		 								<br>
		 								{{ $attempt->result->first()->created_at->format('l d F Y, h:i A') }}
		 							</td>
		 						@else
		 							<td>In Progress</td>
		 						@endif
		 						@if($attempt->result->count() != 0)
		 							<td class="text-center align-middle">{{ $attempt->result->where('status', 'correct')->count() }}.00 </td>
		 							@php
		 							$grade = ( 100 / $attempt->result->count() ) *  $attempt->result->where('status', 'correct')->count();
		 							@endphp
		 							<td class="text-center align-middle">{{ number_format($grade, 2, '.', '') }} out of 100.00 </td>
									<td class="text-center align-middle"><a href="{{ route('answer.final.exam.result', [$module, $attempt->id]) }}">Review</a></td>
		 							@else
		 							<td></td>
		 							<td></td>
		 							<td></td>
		 						@endif
							</tr>
		 			@endforeach
		 	</tbody>
		 </table>
		 @if(!is_null($highestGrade))
		 	<h4 class="text-dark ml-5 py-4">Highest grade : {{  number_format($highestGrade, 2, '.', '') }} / 100.00</h4>
		 @endif
		 
			 <div class="text-center">
			 	@if(!is_null($student->exam_attempt->last()) && $student->exam_attempt->last()->result->count() != 0 && $student->exam_attempt->count() < 3)
			 		<a href="{{ route('user.add.attempt', $module) }}" class="btn rounded-0 text-dark" style="background :#ced4da">Re-attempt Final Exam</a>
			 	{{-- IF THE USER ALREADY TAKE THE EXAM AND NOT FINISH --}}
			 	@elseif(!is_null($student->exam_attempt->last()) && $student->exam_attempt->last()->result->count() == 0)
			 		<a href="{{ route('answer.final.exam', $module) }}" class="btn rounded-0 text-dark" style="background :#ced4da">Continue the last attempt</a>
			 	{{-- IF THE USER DOESN'T TAKE EXAMINATION --}}
			 	@elseif(is_null($student->exam_attempt->last()) ||  $student->exam_attempt->count() < 3)
			 		<a href="{{ route('user.add.attempt', $module) }}" class="btn rounded-0 text-dark" style="background :#ced4da">Take Final Exam</a>
			 	@endif
		 	
		 	</div>
		</div>
			@else
			<h5 class="text-center text-danger">
				Please review all the activities seem's like you left something
			</h5>
		@endif
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
						
						@foreach($overview->files as $f)
							<option data-link="/student/course/{{ $course->id }}/overview/show/{{ $f->id }}">{{ $f->title }}</option>
						@endforeach

						@foreach($modules as $module)
							@foreach($module->activities->where('completion', null) as $activity)
								<option data-link="/student/activity/view/{{ $activity->id }}">{{ $activity->activity_no }} {{ $activity->title }}</option>
							@endforeach
						@endforeach 

						<option selected data-link="/student/final/exam/{{ $module->exam->id }}">{{ $module->exam->title }}</option>

						@foreach($modules as $module)
							@foreach($module->activities->where('completion', 1) as $activity)
								<option {{ $canDownloadCertificate ?: 'disabled' }} data-link="/student/activity/view/{{ $activity->id }}">{{ $activity->title }}</option>
							@endforeach
						@endforeach

					</select>
				</div>

				<div class="col-md-4 text-right">
					@if(!is_null($next) && $next instanceof App\Activity)
						<span class="text-dark mr-3">NEXT ACTIVITY</span>
						<br>
						<a href="{{ route('student.activity.view', $next->id) }}" class="btn btn-link" title="{{$next->title}}"> {{ $next->title }} ►</a>
					@endif
				</div>
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