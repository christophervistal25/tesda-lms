@extends('layouts.admin.app')
@section('title', 'Courses')
@section('content')
@prepend('page-css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/startbootstrap-sb-admin-2@4.1.1/vendor/datatables/dataTables.bootstrap4.min.css">
@endprepend
<div class="card shadow mb-4">
	<div class="card-header py-3">
		<h6 class="m-0 font-weight-bold text-primary">List of course</h6>
	</div>
	
	<div class="card-body">
		<div class="float-right mb-1">
			<a href="{{ route('course.create') }}" class="btn btn-primary btn-sm"> <i class="fas fa-plus"></i> New course</a>
		</div>
		<div class="clearfix"></div>
		<table class="table table-bordered table-inverse table-hover" id="course-table">
			<thead>
				<tr>
					<th>Name</th>
					<th>Description</th>
					<th>Design</th>
					<th>Program</th>
					<th>Batch</th>
					<th>Instructor</th>
					<th>Created At</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				@foreach($courses as $course)
				<tr>
					<td class="text-primary">{{ $course->name }}</td>
					<td>{{ $course->description }}</td>
					<td><a href="{{ route('course.design', $course) }}">Course Design</a></td>
					<td>{{ $course->program->name }}</td>
					<td>{{ $course->program->batch->name }} - Batch {{ $course->program->batch->batch_no }}</td>
					<td class="text-primary text-center text-capitalize">
						@foreach($course->instructors as $instructor)
						{{ $instructor->lastname  . ', ' . $instructor->firstname . ' ' . $instructor->middlename }}
						@endforeach
					</td>
					<td class="text-center">{{ $course->created_at->diffForHumans() }}</td>
					<td class="text-center">
						<a href="{{ route('course.add.module', $course) }}" title="Add module this" class="btn btn-success btn-sm"> <i class="fas fa-plus"></i> </a>
						<a href="{{ route('course.edit', $course) }}" title="Edit this course" class="btn btn-primary btn-sm"> <i class="fas fa-edit"></i> </a>
						<a data-src="{{ $course->id }}" title="Delete this course" class="text-white btn btn-danger btn-sm btn-delete-course"> <i class="fas fa-trash"></i> </a>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
		
	</div>
</div>

  <!-- Delete Modal-->
  <div class="modal fade" id="deleteRecordModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="deleteModalLabel">You sure deleting this record?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body"><span class="text-danger">Select "Yes" below if you are ready to delete this record.</span></div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <button class="btn btn-danger" type="button" id="btnDeleteRecord">Delete</button>
        </div>
      </div>
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
<script>
	$(document).ready(function () {
		let recordId  = 0;
		$('#course-table').DataTable();

		$('.btn-delete-course').click(function (e) {
			let data = $(this).attr('data-src');
			recordId = data;
			
			$('#deleteRecordModal').modal('toggle');
		});

		$('#btnDeleteRecord').click(function () {
			if (recordId === 0) {
				alert('Please refresh the page and try again.');
			}
			// Process to action.
			$.ajax({
				url : `/admin/course/${recordId}/hide`,
				method : 'PUT',
				success: (response) => {
					if (response.success) {
						$('#deleteRecordModal').modal('toggle');
						swal("Good job!", "You delete the record", "success");
						location.reload();
					} 
				}
			});
		});
	});
</script>
@endpush
@endsection