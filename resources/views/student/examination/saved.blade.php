@extends('layouts.student.app')
@section('title', '')
@section('content')
@prepend('page-css')
@endprepend
<div class="card rounded-0 mb-4">
	<div class="card-body">
		<h1 class="text-dark">{{ $course->name }}</h1>
	</div>
</div>
<div class="row">
	<div class="col-lg-9">

		<div class="card rounded-0 mb-4">

			<div class="card-body text-dark">
				<h2>Final Exam</h2>
				<h3>Summary of attempt</h3>
				<div class="row">
					<div class="col-lg-12">
						<table class="table table-striped table-hover">
							<thead>
								<tr class="text-dark">
									<th>Question</th>
									<th>Status</th>
								</tr>
							</thead>
							<tbody>
								<tr class="text-dark">
									<th colspan="2">Final Exam</th>
								</tr>
								@foreach($questions as $q)
									<tr class="text-dark">
										<td>{{ $q->question_no }}</td>
										<td>Answer saved</td>
									</tr>
								@endforeach
							</tbody>
						</table>
						<div class="text-center">
							<button class="btn btn-default text-dark mb-3 rounded-0" onclick="window.history.back()" style="background :#ced4da">Return to attempt</button>
							<br>
							<form action="{{ route('answer.final.exam.submit', [$module]) }}" method="POST">
								@csrf
								@foreach($examination_data as $name => $value)
								<input type="hidden" name="{{ $name }}" value="{{ $value }}">
								@endforeach
								<button class="btn btn-default text-dark rounded-0" style="background :#ced4da">Submit all and finish</button>
							</form>
							
						</div>
					</div>
				</div>
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

	<div class="col-lg-3">
		<div class="card rounded-0">
			<div class="card-body text-dark">
				<h5 class="card-title">Quiz Navigation</h5>
				<h3 class="card-text">Final Exam</h3>
				@foreach($questions as $q)
						<a href="">{{ $q->question_no }}</a> |
				@endforeach
			</div>
		</div>
	</div>
</div>
@push('page-scripts')
<script>
	$('#sidebarToggle').trigger('click');
</script>
<script>
	$('#jumpToOptions').change(function (e) {
		let selectedItemLink = $(this).children("option:selected").attr('data-link');
		location.href = selectedItemLink;
	});
</script>
@endpush
@endsection