@extends('layouts.admin.app')
@section('title', 'Course Design of ' . $course->name)
@section('content')
@prepend('page-css')
@endprepend
<div class="card shadow mb-4">
	<div class="card-header py-3">
		<h6 class="m-0 font-weight-bold text-primary"></h6>
	</div>
	
	<div class="card-body">
	
		<div class="clearfix"></div>
		
		{!! $course->design !!}
			<div class="float-right mb-1">
			<a href="{{ route('course.create') }}" class="btn btn-success btn-sm"> <i class="fas fa-edit"></i> Modify</a>
		</div>
	</div>
</div>



@push('page-scripts')
@endpush
@endsection