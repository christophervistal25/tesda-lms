@extends('layouts.admin.app')
@section('title', 'Instructors section')
@section('content')
@prepend('page-css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/startbootstrap-sb-admin-2@4.1.1/vendor/datatables/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
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
						<td class="text-center">
							@if($instructor->image)
								<a class="btn btn-sm btn-primary" href="{{ $instructor->image }}" target="_blank">Image</a>
							@endif
						</td>
						<td class="text-center">
							<button data-src="{{ $instructor }}" class="btn btn-sm btn-success btn-assign-course">Assign course</button>
							<button data-src="{{ $instructor }}" class="btn btn-sm btn-info btn-course-handle">Handle Course</button>
							<a href="{{ route('instructor.edit', [$instructor]) }}" class="btn btn-sm btn-primary">Edit</a>
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
		
	</div>
</div>

   {{-- List of all course instructor handle --}}
  <div class="modal fade" id="courseHandleModal" tabindex="-1" role="dialog" aria-labelledby="courseHandleTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="courseHandleTitle"></h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body pb-0">
       		<div id="course-handle-items"></div>
        </div>
        <div class="modal-footer">
	          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
        </div>
      </div>
    </div>
  </div>

   {{-- assign course for instructor --}}
  <div class="modal fade" id="assignCourseModal" tabindex="-1" role="dialog" aria-labelledby="assignCourseTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="assignCourseTitle"></h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body pb-0">
       		<div id="assign-handle-items">
       		</div>
	        <div class="form-group">
	            <label class="col-md-auto  text-md-right">Courses</label>
	            <div class="col-md-12">
	             <select class="form-control selectpicker" multiple data-live-search="true" name="course" id="courseAssign">
	                @foreach($courses as $course)
	                  <option value="{{ $course->id }}" data-tokens="{{ $course->name }}">{{ $course->program->batch->name }} Batch / {{ $course->program->name }} / {{ $course->program->batch->batch_no}} {{ $course->name }}</option>
	                @endforeach
	            </select>
	            </div>
	        </div>

        </div>
        <div class="modal-footer">
	          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
	           <button class="btn btn-success" type="button" id="btnAssignCourse">Assign</button>
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
<script>
	let instructorId = null;

	$('#instructor-table').DataTable();
	

	$('.btn-course-handle').click(function (e) {
		let dataSrc = JSON.parse($(this).attr('data-src'));
		$('#course-handle-items').html('');
		$('#courseHandleModal').modal('toggle');
		$('#courseHandleTitle').html(`<span class="text-primary">${dataSrc.lastname}, ${dataSrc.firstname} ${dataSrc.middlename}</span> Courses handle`);
			dataSrc.courses.map((course) => {
				$('#course-handle-items').append(`
					<div class="alert alert-info" role="alert">
						${course.name} - ${course.description}
					</div>
				`);
			});
	});

	$('.btn-assign-course').click(function (e) {
		let dataSrc = JSON.parse($(this).attr('data-src'));
		let courseIds = [];
		instructorId = dataSrc.id;
		$('#assign-handle-items').html('');
		$('#assignCourseModal').modal('toggle');
		$('#assignCourseTitle').html(`<span class="text-primary">${dataSrc.lastname}, ${dataSrc.firstname} ${dataSrc.middlename}</span> assign course`);

		dataSrc.courses.forEach((course) => {
			courseIds.push(course.id);
		});

		$('.selectpicker').selectpicker('val', courseIds);
		if (dataSrc.courses.length != 0) {
			$('#assign-handle-items').append('<span>Handle Course</span>')
			dataSrc.courses.map((course) => {
				$('#assign-handle-items').append(`
					<div class="alert alert-info" role="alert">
						${course.name} - ${course.description}
					</div>
				`);
			});
		}
	});

	$('#btnAssignCourse').click(function () {
		$.ajax({
			url : `/admin/instructor/assign/course/${instructorId}`,
			method : 'POST',
			data : { course : $('#courseAssign').val() },
			success : (response) => {
				if (response.success) {
					$('#assignCourseModal').modal('toggle');
					swal({
					  title: "Good job!",
					  text: "Succesfully assign a course",
					  icon: "success",
					  buttons: true,
					})
					.then((okeyButton) => {
					  if (okeyButton) {
	            			location.reload();
					  } 
					});
	            	
				}
			},
		});
	});
</script>
@endpush
@endsection