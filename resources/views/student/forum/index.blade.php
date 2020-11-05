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
		@forelse($discussions as $discussion)
		<tr>
			<td class="text-center"><a href="{{ route('forum.show', $discussion->id) }}">{{ $discussion->title }}</a></td>
			<td class="text-center"><span class="badge badge-primary">0</span></td>
			<td class="text-center"><span class="badge badge-primary">{{ $discussion->comments->count() }}</span></td>
			<td class="text-center">{{ $discussion->postBy->name }}</td>
			<td>{{ $discussion->created_at->format('l, j  F Y, h:i A') }}</td>
		</tr>
		@empty
			<td colspan="5" class="text-danger text-center">No available data</td>
		@endforelse
	</tbody>
</table>
@push('page-scripts')
@endpush
@endsection