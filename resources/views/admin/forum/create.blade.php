@extends('layouts.admin.app')
@section('title', 'Announcements & Forums')
@section('content')
@prepend('page-css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
@endprepend
	@if(Session::has('success'))
		<div class="card bg-primary text-white shadow mb-2">
			<div class="card-body">
				{{ Session::get('success') }} <a class="text-white" href=" {{ route('forums.index') }}"> / <u>View records</u></a>
			</div>
		</div>
	@endif

<div class="card shadow mb-4">
	<div class="card-header py-3">
		<h6 class="m-0 font-weight-bold text-primary">Create new announcement</h6>
	</div>

	
	<div class="card-body">
		<form action="{{ route('forums.store') }}" method="POST">
			@csrf
			<div class="form-group">
				<label>Title</label>
				<input type="text" name="title" class="form-control" placeholder="Enter title here...">
			</div>	

			<div class="form-group">
				<label>Body</label>
				<textarea name="body" id="body"></textarea>
			</div>

			<div class="form-group">
				<label>Announcement for course</label>
				<select class="form-control selectpicker" data-live-search="true" name="course">
					<option value=""  selected>N/A</option>
					@foreach($courses as $course)
					<option value="{{ $course->id }}" data-tokens="{{ $course->name }}">{{ $course->program->batch->name }} Batch / {{ $course->program->name }} / {{ $course->program->batch->batch_no}} {{ $course->name }}</option>
					@endforeach
				</select>
			</div>

			<div class="form-group">
				<div class="float-right">
					<input type="submit" value="Create news" class="btn btn-primary">
				</div>
				<div class="clearfix"></div>
			</div>
		</form>
	</div>
</div>





@push('page-scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
<script src="https://cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
<script>
let moduleBodyEditor = CKEDITOR.replace( 'body' );
 $('.selectpicker').selectpicker();
</script>
@endpush
@endsection