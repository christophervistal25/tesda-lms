@extends('layouts.admin.app')
@section('title', 'Announcements & Forums')
@section('content')
@prepend('page-css')
@endprepend
{{ Breadcrumbs::render('announcements') }}
<div class="card shadow mb-4">
	<div class="card-header py-3">
		<h6 class="m-0 font-weight-bold text-primary">Announcements & Forums</h6>
	</div>

	
	<div class="card-body">
		<div class="float-right">
			<a href="{{ route('forums.create') }}" class="btn btn-primary mb-2">Create new post</a>

		</div>
		<div class="clearfix"></div>
	
		<table class="table table-hover table-bordered text-dark">
			<thead>
				<tr>
					<th>Discussion</th>
					<th>Course</th>
					<th>Created by</th>
					<th>No. of comments</th>
					<th>Posted on</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				@foreach($posts as $post)
					<tr>
						<td><a href="{{ route('forums.show', $post->id) }}">{{ $post->title }}</a></td>
						<td>{{ $post->course->name ?? '' }}</td>
						<td>{{ $post->postBy->name }}</td>
						<td class="text-center"><span class="badge badge-pill badge-primary">{{ $post->comments->count() }}</span></td>
						<td>{{ $post->created_at->format('l, j  F Y, h:i A') }}</td>
						<td>
							{{-- <a href="" class="btn btn-sm btn-primary"><i class="fas fa-eye"></i></a> --}}
							<a href="{{ route('forums.edit', $post->id) }}" class="btn btn-sm btn-success"><i class="fas fa-pencil"></i> Edit</a>
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>





@push('page-scripts')
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/startbootstrap-sb-admin-2@4.1.1/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/startbootstrap-sb-admin-2@4.1.1/vendor/datatables/dataTables.bootstrap4.min.js"></script>

@endpush
@endsection