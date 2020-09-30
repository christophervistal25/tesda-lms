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
			<h2 class="text-dark">{{ $file->title }} - {{ $course->name }}</h2>
			<br>
			<p class="">
				<span class="text-dark">Click </span> <a href="{{ $file->link }}"> {{ $file->title }} </a> <span class="text-dark">link to view the file.</span>
			</p>
				
			<br>
			<p class="text-dark">Last modified: {{ $file->updated_at->format('l, j  F Y, h:i A') }}</p>
		</div>
		<hr>
		<div class="container-fluid py-2">
			<div class="row">
				<div class="col-md-4 text-left">
					<span class="text-dark ml-3">PREVIOUS ACTIVITY</span>
					<br>
					@if(!is_null($previousFile))
						<a href="{{ route('course.overview.show.file', [$course->id, $previousFile->id]) }}" id="prev-activity-link" class="btn btn-link" title="{{ $previousFile->title }}">◄ {{ $previousFile->title }}</a>
						@else
						<a href="{{ route('course.design', [$course, true]) }}">◄ Course Design</a>
					@endif
					
				</div>

				<div class="col-md-4 mt-2">
					<select name="" id="" class="form-control rounded-0 text-dark">
						<option>Jump to...</option>
					</select>
					<div class="pagination">
				</div>
				</div>

				<div class="col-md-4 text-right">
					<span class="text-dark mr-3">NEXT ACTIVITY</span>
					<br>
					@if(!is_null($nextFile))
						<a href="{{ route('course.overview.show.file', [$course->id, $nextFile->id]) }}" class="btn btn-link" title="{{$nextFile->title}}"> {{ $nextFile->title }} ►</a>
						@else
						<a href="{{ route('activity.view', $firstActivity->id) }}" class="btn btn-link" title="{{ $firstActivity->title}}">{{$firstActivity->activity_no}} {{$firstActivity->title}} ►</a>
					@endif
					
				</div>

			</div>
		</div>
	</div>

</div>


@push('page-scripts')
@endpush
@endsection