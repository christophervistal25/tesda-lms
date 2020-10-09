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
<div class="card  mb-4 rounded-0">
	
	<div class="card-body p-0">
			<div class="pl-4 pt-4 pr-4 text-dark">
			{!! $course->design !!}
			<br>
			<p class="text-dark">Last modified: {{ $course->updated_at->format('l, j  F Y, h:i A') }}</p>
			</div>
		

			<div class="clearfix"></div>
			<hr>

	
			<div class="container-fluid py-2">
				<div class="row">
					<div class="col-md-4 text-left">
						<span class="text-dark ml-3">PREVIOUS ACTIVITY</span>
						<br>
						<a href="">◄ Announcement & Forums</a>
					</div>

					<div class="col-md-4 mt-2">
						<option selected disabled>Jump to...</option>
						<select id="jumpToOptions" class="form-control rounded-0 text-dark">
							<option value="">Announcement & Forums</option>
						{{-- 	<option data-link="/student/course/design/{{$course->id}}">Course Design</option>
							@foreach($course->overview->files as $file)
								<option data-link="/student/course/{{$course->id}}/overview/show/{{$file->id}}">{{ $file->title }}</option>
							@endforeach
							@foreach($course->modules as $module)
								@foreach($module->activities as $activity)
										<option value="{{ $activity->id }}" data-link="/student/activity/view/{{$activity->id}}">{{ $activity->activity_no }} {{ $activity->title }}</option>
								@endforeach
							@endforeach --}}
						</select>
					</div>

					<div class="col-md-4 text-right">
						<span class="text-dark mr-3">NEXT ACTIVITY</span>
						<br>
						
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