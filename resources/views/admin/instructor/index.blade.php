@extends('layouts.admin.app')
@section('title', 'Instructors section')
@section('content')
@prepend('page-css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/startbootstrap-sb-admin-2@4.1.1/vendor/datatables/dataTables.bootstrap4.min.css">
@endprepend
<div class="card shadow mb-4">
	<div class="card-header py-3">
		<h6 class="m-0 font-weight-bold text-primary">Instructor</h6>
	</div>

	
	<div class="card-body">
		<div class="float-right">
			<a href="{{ route('instructor.create') }}" class="btn btn-primary mb-2">Add new instructor</a>
		</div>
		<div class="clearfix"></div>
		<table class="table table-bordered" id="instructor-table">
			<thead>
				<tr>
					<th>Fullname</th>
					<th>Contact No.</th>
					<th>Image</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				@foreach($instructors as $instructor)
					<tr>
						<td class="text-capitalize"> {{ $instructor->lastname  . ', ' . $instructor->firstname . ' ' . $instructor->middlename  }}</td>
						<td>{{ $instructor->contact_no }}</td>
						<td class="text-center"><a class="btn btn-sm btn-primary" href="{{ $instructor->image }}" target="_blank">Image</a></td>
						<td class="text-center">
							<button class="btn btn-sm btn-info">Assign course</button>
							<button class="btn btn-sm btn-primary">Edit</button>
							<button class="btn btn-sm btn-danger">Delete</button>
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
		
	</div>
</div>


@push('page-scripts')
<script src="https://cdn.jsdelivr.net/npm/startbootstrap-sb-admin-2@4.1.1/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/startbootstrap-sb-admin-2@4.1.1/vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script>
	$('#instructor-table').DataTable();
</script>
@endpush
@endsection