@extends('layouts.admin.app')
@section('title', '')
@section('content')
@prepend('page-css')
@endprepend
{{ Breadcrumbs::render('course-design', $course) }}
{{-- <div class="card rounded-0 mb-4">
	<div class="card-body">
		<h1 class="text-dark">{{ $course->name }}</h1>
	</div>
</div> --}}
<div class="card  mb-4 rounded-0">
	
	<div class="card-body p-0">
			<div class="pl-4 pt-4 pr-4">
			<h2 class="text-dark">Course Design</h2>
			<br>
			<div class="text-dark">
				{!! $course->design !!}
			</div>
			<div class="float-right mb-1">
				<a href="{{ route('course.edit', $course) }}" class="btn btn-success"> <i class="fas fa-edit"></i> Modify</a>
			</div>
			<br>
			<p class="text-dark">Last modified: {{ $course->updated_at->format('l, j  F Y, h:i A') }}</p>
			</div>
			<div class="clearfix"></div>
			<hr>
	</div>
</div>



@push('page-scripts')
@endpush
@endsection