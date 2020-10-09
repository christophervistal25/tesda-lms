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
					<span class="text-dark ml-3">PREVIOUS ACTIVITY</span>
					<br>
					@if(!is_null($previousActivity))
					{{-- THE PREVIOUS IS ACTIVITY --}}
						<a href="{{ route('activity.view', $previousActivity->id) }}" id="prev-activity-link" class="btn btn-link" title="{{ $previousActivity->title }}">◄ {{ $previousActivity->activity_no }} {{ $previousActivity->title }}</a>
					@elseif(!is_null($lastPageOfCourseOverview))
					{{-- THERE IS A FILE ATTACH IN COURSE OVERVIEW --}}
						<a href="{{ route('course.overview.show.file', [$course->id, $lastPageOfCourseOverview->id]) }}" id="prev-activity-link" class="btn btn-link" title="{{ $lastPageOfCourseOverview->title }}">◄ {{ $lastPageOfCourseOverview->title }}</a>
					@else 
					{{-- THERE IS NO FILE ATTACH IN COURSE OVERVIEW --}}
						<a href="{{ route('course.design', [$course->id, 1]) }}" id="prev-activity-link" class="btn btn-link" title="Course Design">◄ Course Design</a>
					@endif
					
				</div>

				<div class="col-md-4 mt-2">
					<select id="jumpToOptions" class="form-control rounded-0 text-dark">
						<option selected disabled>Jump to...</option>
						<option data-link="{{ route('course.forum.show', $course->id) }}">Announcement & Forums</option>
						<option data-link="/admin/course/design/{{ $course->id}}/1">Course Design</option>
						@foreach($course->overview->files as $file)
							<option data-link="/admin/course/{{$course->id}}/overview/show/{{$file->id}}">{{ $file->title }}</option>
						@endforeach
						@foreach($course->modules as $module)
							@foreach($module->activities as $activity)
									<option value="{{ $activity->id }}" data-link="/admin/activity/view/{{$activity->id}}">{{ $activity->activity_no }} {{ $activity->title }}</option>
							@endforeach
						@endforeach
					</select>
				</div>

				<div class="col-md-4 text-right">
					@if(!is_null($nextActivity))
						<span class="text-dark mr-3">NEXT ACTIVITY</span>
						<br>
						<a href="{{ route('activity.view', $nextActivity->id) }}" class="btn btn-link" title="{{$nextActivity->title}}">{{ $nextActivity->activity_no }} {{ $nextActivity->title }} ►</a>
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