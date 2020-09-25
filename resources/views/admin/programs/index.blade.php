@extends('layouts.admin.app')
@section('title', 'Programs')
@section('content')
@prepend('page-css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/startbootstrap-sb-admin-2@4.1.1/vendor/datatables/dataTables.bootstrap4.min.css">
@endprepend
<div class="card shadow mb-4">
	<div class="card-header py-3">
		<h6 class="m-0 font-weight-bold text-primary">List of programs</h6>
	</div>
	
	<div class="card-body">
		<div class="text-right mb-1">
			<a data-toggle="modal" data-target="#addNewProgram" class="btn btn-primary" href="">Create new program</a>
		</div>

		<table class="table table-bordered" id="programs-table">
			<thead>
				<tr>
					<th>Name</th>
					<th>Created At</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody class="text-center"></tbody>
		</table>
	</div>
</div>
 

  {{-- add --}}
  <div class="modal fade" id="addNewProgram" tabindex="-1" role="dialog" aria-labelledby="addModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addModal">Create new program form</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
        	<form id="newProgramForm">
        		<div class="form-group">
        			<label for="name">Program name</label>
        			<input class="form-control" type="text" name="program_name">
        		</div>

        	
        </div>
        <div class="modal-footer">
	          	<button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
	          	<button class="btn btn-primary" type="submit">Create</button>
          	</form>
        </div>
      </div>
    </div>
  </div>

{{-- edit --}}
  <div class="modal fade" id="editProgram" tabindex="-1" role="dialog" aria-labelledby="editModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editModal">Edit Program</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
        	<form id="editProgramForm">
        		<div class="form-group">
        			<label for="name">Program name</label>
        			<input class="form-control" type="text" id="programName" name="program_name">
        		</div>

        	
        </div>
        <div class="modal-footer">
	          	<button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
	          	<button class="btn btn-success" type="submit">Update</button>
          	</form>
        </div>
      </div>
    </div>
  </div>

  {{-- delete  --}}
  <div class="modal fade" id="deleteProgram" tabindex="-1" role="dialog" aria-labelledby="deleteProgram" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="deleteProgram">You sure to delete this program?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body"><span class="text-danger">Please double check this record beforing you hit the delete button.</span></div>
        <div class="modal-footer">
	          	<button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
	          	<button class="btn btn-danger" id="btnDeleteButton" type="button">Delete</button>
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
			let data = {};

			let programTable = $('#programs-table').DataTable({
			    serverSide: true,
			    ajax: "/admin/programs/list",
			    columns: [
			        { name: 'name' },
			        { name: 'created_at' },
			        { name: 'action', orderable: false, searchable: false }
			    ],
			});

			$('#newProgramForm').submit(function (e) {
				e.preventDefault();
				let formData = $(this).serialize();
				$.ajax({
					url : "{{ route('programs.store') }}",
					method : 'POST',
					data: formData,
					success : (response) => {
						if (response.success) {
							programTable.ajax.reload();
							$('#newProgramForm')[0].reset();
							swal("Good job!", "Succesfully add new program", "success");
							$('#addNewProgram').modal('toggle');
						}
					},
				});
			});

			$(document).on('click', 'button.btnEditProgram', function (e) {
				data = {};
				data = JSON.parse($(e.target).attr('data-src'));
				$('#programName').val(data.name);
				$('#editProgram').modal('toggle');
			});

			$(document).on('click', 'button.btnDeleteProgram', function (e) {
				data = {};
				data = JSON.parse($(e.target).attr('data-src'));
				$('#deleteProgram').modal('toggle');
			});


			$('#editProgramForm').submit(function (e) {
				e.preventDefault();
				$.ajax({
					url : `/admin/programs/${data.id}`,
					method : 'PUT',
					data : { id : data.id, name : $('#programName').val() },
					success : (response) => {
						if (response.success) {
							programTable.ajax.reload();
							$('#editProgramForm')[0].reset();
							swal("Good job!", "Succesfully update program", "success");
							$('#editProgram').modal('toggle');
						}
					},
				});
			});

			$('#btnDeleteButton').click(function (e) {
				e.preventDefault();
				$.ajax({
					url : `/admin/programs/${data.id}/hide`,
					method : 'PUT',
					success : (response) => {
						if (response.success) {
							programTable.ajax.reload();
							swal("Good job!", "Succesfully delete program", "success");
							$('#deleteProgram').modal('toggle');
						}
					},
				});
			});
		});

	</script>	
@endpush
@endsection