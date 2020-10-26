@extends('layouts.admin.app')
@section('title', 'Badges')
@section('content')
@prepend('page-css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/startbootstrap-sb-admin-2@4.1.1/vendor/datatables/dataTables.bootstrap4.min.css">
@endprepend
<div class="card shadow mb-4">
	<div class="card-header py-3">
		<h6 class="m-0 text-primary">Course with badges</h6>
	</div>
	
	<div class="card-body">
		<div class="clearfix"></div>
		{{-- <table class="table table-bordered table-inverse table-hover" id="badge-table">
			<thead>
				<tr class="text-dark">
					<th>Badge</th>
					<th>Course</th>
					<th>Icon</th>
					<th class="text-center">Actions</th>
				</tr>
			</thead>
			<tbody>
				@foreach($badges as $badge)	
				<tr class="text-dark">
					<td>{{ $badge->name }}</td>
					<td class="text-primary text-center"><a href="{{ route('course.view.module', $badge->course) }}">{{ $badge->course->name }}</a></td>
					<td class="text-center"><img width="24px" src="{{ asset('badges/' . $badge->image) }}" alt="course badge"></td>
					<td class="text-center text-white">
						<div class="btn-group dropleft">
						  <button type="button" class="btn btn-sm btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						    Actions
						  </button>
						  <div class="dropdown-menu">
						
						  </div>
						</div>
					</td>
				</tr>
				@endforeach				
			</tbody>
		</table>
		 --}}
	</div>
</div>



@push('page-scripts')
<script>
	$.ajaxSetup({
	    headers: {
	        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	    }
	});
</script>
<script src="https://cdn.jsdelivr.net/npm/startbootstrap-sb-admin-2@4.1.1/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/startbootstrap-sb-admin-2@4.1.1/vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script>
	$(document).ready(function () {
		$('#badge-table').DataTable({
			  "order": [[ 1, "asc" ]],
		});
	});
</script>
@endpush
@endsection