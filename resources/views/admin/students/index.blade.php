@extends('layouts.admin.app')
@section('title', 'Students')
@section('content')
@prepend('page-css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/startbootstrap-sb-admin-2@4.1.1/vendor/datatables/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
@endprepend
<div class="card shadow mb-4">
	<div class="card-header py-3">
		<h6 class="m-0 font-weight-bold text-primary">List of students & progress</h6>
	</div>

	
	<div class="card-body">
		<div class="float-right">
			{{-- <a href="{{ route('student.create') }}" class="btn btn-primary mb-2">Add new instructor</a> --}}
		</div>
		<div class="clearfix"></div>
		<table class="table table-bordered" id="students-table">
			<thead>
				<tr class="text-dark">
					<th>Fullname</th>
					<th>Username</th>
					<th>Email</th>
					<th>City/Town</th>
					<th>Country</th>
					<th>Profile</th>
					<th>Course</th>
					<th>Progress</th>
					<th>Module</th>
				</tr>
			</thead>
			<tbody class="text-center">
				<td colspan="8" class="border border-0">
					<div class="spinner-border text-primary" role="status">
				  		<span class="sr-only">Loading...</span>
					</div>
				</td>
			</tbody>
		</table>
		
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
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/startbootstrap-sb-admin-2@4.1.1/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/startbootstrap-sb-admin-2@4.1.1/vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
<script>
	let record = {};
		// Change the data table to server side
		let batchTable = $('#students-table').DataTable({
			    serverSide: true,
			    ajax: "/admin/student/list",
			    columns: [
			        { name: 'name' },
			        { name: 'username' },
			        { name : 'email' },
			        { name: 'city_town' },
			        { name: 'country' },
			        { name: 'profile' },
			        { name: 'course', orderable: false, searchable: false },
			        { name: 'progress', orderable: false, searchable: false },
			        { name: 'module', orderable: false, searchable: false },
			    ],
			});
</script>
@endpush
@endsection