@extends('layouts.admin.app')
@section('title', 'Batch')
@section('content')
@prepend('page-css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/startbootstrap-sb-admin-2@4.1.1/vendor/datatables/dataTables.bootstrap4.min.css">
@endprepend
<div class="card shadow mb-4">
	<div class="card-header py-3">
		<h6 class="m-0 font-weight-bold text-primary">List of batch</h6>
	</div>
	
	<div class="card-body">
		<div class="float-right mb-1">
			<button data-toggle="modal" data-target="#addBatchModal" class="btn btn-primary btn-sm"> <i class="fas fa-plus"></i> New Batch</button>
		</div>
		<div class="clearfix"></div>
		<table class="table table-bordered table-inverse table-hover" id="batch-table" width="100%">
			<thead>
				<tr>
					<th>Name</th>
					<th>Batch Number</th>
					<th>Created At</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				<td colspan="4" class="text-center">
					<div class="spinner-border text-primary" role="status">
				  		<span class="sr-only">Loading...</span>
					</div>
				</td>
			</tbody>
		</table>
		
	</div>
</div>

 <!-- Create batch Modal-->
  <div class="modal fade" id="addBatchModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addModalLabel">Add new batch</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
       		<div class="alert alert-danger d-none" id="form-message" role="alert">
       		</div>
        	<form method="POST" id="newBatchForm">
        		<div class="form-group">
        			<label for="name">Name</label>
        			<input type="text" name="name" class="form-control" id="name">
        		</div>

        		<div class="form-group">
        			<label for="number">Batch number</label>
        			<input type="number" name="batch_number" class="form-control" id="number">
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

   <!-- Create batch Modal-->
  <div class="modal fade" id="editBatchModal" tabindex="-1" role="dialog" aria-labelledby="editModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editModal">Edit batch</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
       		<div class="alert alert-danger d-none" id="form-edit-message" role="alert">
       		</div>
        	<form method="POST" id="updateBatchForm">
        		<div class="form-group">
        			<label for="name">Name</label>
        			<input type="text" name="name" class="form-control" id="editName">
        		</div>

        		<div class="form-group">
        			<label for="number">Batch number</label>
        			<input type="number" name="batch_number" class="form-control" id="editNumber">
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


  <!-- Delete Modal-->
  <div class="modal fade" id="deleteBatchModal" tabindex="-1" role="dialog" aria-labelledby="deleteModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="deleteModal">You sure deleting this record?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body"><span class="text-danger">Please double check this record before hitting the "DELETE" button</span></div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <button class="btn btn-danger"  id="btnDeleteRecord">Delete</button>
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
		let record = {};
		// Change the data table to server side
		let batchTable = $('#batch-table').DataTable({
			    serverSide: true,
			    ajax: "/admin/batch/list",
			    columns: [
			        { name: 'name' },
			        { name : 'batch_no' },
			        { name: 'created_at' },
			        { name: 'action', orderable: false, searchable: false }
			    ],
			});

		$('#newBatchForm').submit(function (e) {
			e.preventDefault();
			let formData = $(this).serialize();
			$.ajax({
				type: 'POST',
	            url: '/admin/batch',
	            data: formData,
	            success: (response) => {
	            	$('#form-message').addClass('d-none');
	            	swal("Good job!", "Succesfully add new batch", "success");
	            	$('#addBatchModal').modal('toggle');
	            	batchTable.ajax.reload();
	            },
	            error : (response) => {
	            	if (response.status === 422) {
	            		$('#form-message').html('');
	        			$('#form-message').removeClass('d-none');
	            		// Display error message.
	            		let formErrorMessage = Object.values(response.responseJSON.errors);
	            		formErrorMessage.forEach((errMessage) => {
	            			$('#form-message').append(`<li>${errMessage[0]}</li>`)
	            		});
	            	}
	            },
			});
		});

		$(document).on('click', 'button.btnEditBatch', function (e) {
			record = {};
			record = JSON.parse($(e.target).attr('data-src'));
			$('#editBatchModal').modal('toggle');
			$('#editName').val(record.name);
			$('#editNumber').val(record.batch_no);
		});

		$(document).on('click', 'button.btnDeleteBatch', function (e) {
			record = {};
			record = JSON.parse($(e.target).attr('data-src'));
			$('#deleteBatchModal').modal('toggle');
		});

		$('#updateBatchForm').submit(function (e) {
			e.preventDefault();
			let formData = $(this).serialize();
			$.ajax({
				method : 'PUT',
				url : `/admin/batch/${record.id}`,
				data : formData,
				success : (response) => {
	            	swal("Good job!", "Succesfully update batch", "success");
	            	$('#editBatchModal').modal('toggle');
	            	batchTable.ajax.reload();
				},
	            error : (response) => {
	            	$('#form-edit-message').html('');
	            	if (response.status === 422) {
	        			$('#form-edit-message').removeClass('d-none');
	            		// Display error message.
	            		let formErrorMessage = Object.values(response.responseJSON.errors);
	            		formErrorMessage.forEach((errMessage) => {
	            			$('#form-edit-message').append(`<li>${errMessage[0]}</li>`)
	            		});
	            	}
	            },
			});
		});


		$('#btnDeleteRecord').click(function (e) {
			$.ajax({
				method : 'PUT',
				url : `/admin/batch/${record.id}/hide`,
				success : (response) => {
	            	swal("Good job!", "Succesfully delete batch", "success");
	            	$('#deleteBatchModal').modal('toggle');
	            	batchTable.ajax.reload();
				},
			});
		});


	});
</script>
@endpush
@endsection