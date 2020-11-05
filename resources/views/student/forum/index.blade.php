@extends('layouts.student.app')
@section('title', '')
@section('content')
@prepend('page-css')
@endprepend
<table class="table table-bordered table-hover text-dark bg-white">
	<thead>
		<tr>
			<th>News & More</th>
			<th>Views</th>
			<th>Comments</th>
			<th>Posted by</th>
			<th>Created at</th>
		</tr>
	</thead>
	<tbody>
		@foreach($discussions as $discussion)
		<tr>
			<td class="text-center"><a href="{{ route('forum.show', $discussion->id) }}">{{ $discussion->title }}</a></td>
			<td class="text-center"><span class="badge badge-primary">0</span></td>
			<td class="text-center"><span class="badge badge-primary">{{ $discussion->comments->count() }}</span></td>
			<td class="text-center">{{ $discussion->postBy->name }}</td>
			<td>{{ $discussion->created_at->format('l, j  F Y, h:i A') }}</td>
		</tr>
		@endforeach
	</tbody>
</table>
@push('page-scripts')
@endpush
@endsection