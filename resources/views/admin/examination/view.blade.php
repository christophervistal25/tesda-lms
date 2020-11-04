@extends('layouts.admin.app')
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
		 		<tr class="text-dark">
		 			<th class="text-center">Attempt</th>
		 			<th>State</th>
		 		</tr>
		 	</thead>
		 	<tbody>
		 			<tr>
		 				<td></td>
		 				<td></td>
		 			</tr>
		 	</tbody>
		 </table>
			 <div class="text-center">
			 	<a href="{{ route('module.final.exam.edit', [$module->exam->id, 1]) }}" class="btn rounded-0 text-dark" style="background :#ced4da">View Final Exam</a>
		 	</div>
		</div>
		<hr>
		<div class="container-fluid py-2">
			<div class="row">
				<div class="col-md-4 text-left">
					@if($previous instanceof App\Activity)
						<span class="text-dark mr-3">PREVIOUS ACTIVITY</span>
						<br>
						<a href="{{ route('activity.view', $previous->id) }}" class="btn btn-link" title="{{$previous->title}}">◄ {{ $previous->activity_no }} {{ $previous->title }}</a>
					@elseif($previous instanceof App\File)
						<span class="text-dark mr-3">PREVIOUS ACTIVITY</span>
						<br>
						<a href="{{ route('course.overview.show.file', [$course->id, $previous->id]) }}" id="prev-activity-link" class="btn btn-link" title="{{ $previous->title }}">◄ {{ $previous->title }}</a>
					@endif
				</div>

				<div class="col-md-4 mt-2">
					<select id="jumpToOptions" class="form-control rounded-0 text-dark">
						<option selected disabled>Jump to...</option>
						
						@foreach($overview->files as $f)
							<option data-link="/admin/course/{{ $course->id }}/overview/show/{{ $f->id }}">{{ $f->title }}</option>
						@endforeach

						@foreach($modules as $module)
							@foreach($module->activities->where('completion', null) as $activity)
								<option data-link="/admin/activity/view/{{ $activity->id }}">{{ $activity->activity_no }} {{ $activity->title }}</option>
							@endforeach
						@endforeach 

						<option selected data-link="/admin/final/exam/{{ $module->exam->id }}">{{ $module->exam->title }}</option>

						@foreach($modules as $module)
							@foreach($module->activities->where('completion', 1) as $activity)
								<option data-link="/admin/activity/view/{{ $activity->id }}">{{ $activity->title }}</option>
							@endforeach
						@endforeach

					</select>
				</div>

				<div class="col-md-4 text-right">
					@if(!is_null($next) && $next instanceof App\Activity)
						<span class="text-dark mr-3">NEXT ACTIVITY</span>
						<br>
						<a href="{{ route('activity.view', $next->id) }}" class="btn btn-link" title="{{$next->title}}"> {{ $next->title }} ►</a>
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