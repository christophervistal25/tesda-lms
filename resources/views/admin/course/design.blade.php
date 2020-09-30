@extends('layouts.admin.app')
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
			<div class="pl-4 pt-4 pr-4">
			{!! $course->design !!}
			<div class="float-right mb-1">
				<a href="{{ route('course.create') }}" class="btn btn-success btn-sm"> <i class="fas fa-edit"></i> Modify</a>
			</div>
			<br>
			<p class="text-dark">Last modified: {{ $course->updated_at->format('l, j  F Y, h:i A') }}</p>
			</div>
		
			

			<div class="clearfix"></div>
			<hr>

			@if($forceview)
			<div class="container-fluid py-2">
				<div class="row">
					<div class="col-md-4 text-left">
						<span class="text-dark ml-3">PREVIOUS ACTIVITY</span>
						<br>
						<a href="">◄ Announcement & Forums</a>
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
						<a href="{{ route('course.overview.show.file', [$course->id, $firstFile->id]) }}" class="btn btn-link" title="{{ $firstFile->title }}"> {{ $firstFile->title }} ►</a>
					</div>

				</div>
			</div>
			@endif
	</div>
</div>



@push('page-scripts')
@endpush
@endsection