@extends('layouts.admin.app')
@section('title', 'Announcements & Forums')
@section('content')
@prepend('page-css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
@endprepend
	{{ Breadcrumbs::render('announcements-edit', $post) }}
	@if(Session::has('success'))
		<div class="card bg-success text-white shadow mb-2">
			<div class="card-body">
				{{ Session::get('success') }}
			</div>
		</div>
	@endif

@include('layouts.admin.error')

<div class="card shadow mb-4">
	<div class="card-header py-3">
		<h6 class="m-0 font-weight-bold text-primary">Modify {{ $post->title }}</h6>
	</div>

	
	<div class="card-body text-dark">
		<form action="{{ route('forums.update', $post->id) }}" method="POST">
			@method('PUT')
			@csrf
			<div class="form-group">
				<label>Title</label>
				<input type="text" name="title" class="form-control" placeholder="Enter title here..." value="{{ old('title') ?? $post->title }}">
			</div>	

			<div class="form-group">
				<label>Body</label>
				<textarea name="body" id="body">{{ old('body') ?? $post->body }}</textarea>
			</div>

			<div class="form-group">
				<label>Announcement for course</label>
				<select class="form-control selectpicker" data-live-search="true" name="course">
					<option value=""  selected>N/A</option>
					@foreach($courses as $course)
						@if(!is_null(old('course')))
							<option {{ $course->id == old('course') ? 'selected' : ''}} value="{{ $course->id }}" data-tokens="{{ $course->name }}">{{ $course->program->batch->name }} Batch / {{ $course->program->name }} / {{ $course->program->batch->batch_no}} {{ $course->name }}</option>
							@else
							<option {{ $course->id == $post->course_id ? 'selected' : ''}} value="{{ $course->id }}" data-tokens="{{ $course->name }}">{{ $course->program->batch->name }} Batch / {{ $course->program->name }} / {{ $course->program->batch->batch_no}} {{ $course->name }}</option>
						@endif
					@endforeach
				</select>
			</div>

			<div class="form-group">
				<div class="float-right">
					<input type="submit" value="Update" class="btn btn-success">
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