<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	 <link rel="icon" href="https://res.cloudinary.com/dfm6cr1l9/image/upload/v1604075788/icons/loder_h2qnck.webp">  
	  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/all.min.css" integrity="sha512-xA6Hp6oezhjd6LiLZynuukm80f8BoZ3OpcEYaqKoCV3HKQDrYjDE1Gu8ocxgxoXmwmSzM4iqPvCsOkQNiu41GA==" crossorigin="anonymous" />

	  <link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet">

	  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/startbootstrap-sb-admin-2/4.0.7/css/sb-admin-2.min.css" integrity="sha512-FXgL8f6gtCYx8PjODtilf5GCHlgTDdIVZKRcUT/smwfum7hr4M1ytewqTtNd9LK4/CzbW4czU6Tr3f3Xey6lRg==" crossorigin="anonymous" />
	   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/startbootstrap-sb-admin-2@4.1.1/vendor/datatables/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
	  <style>
	  	body { font-family : "Poppins", sans-serif; }
	  </style>
</head>
<body class="p-5">

			<div class="row">
			<div class="col-xl-3 col-md-6 mb-4">
				
					<div class="card border-left-primary  h-100 py-2">
						<div class="card-body">
							<div class="row no-gutters align-items-center">
								<div class="col mr-2">
									<div class="text-xs font-weight-bold text-primary text-uppercase mb-1"># Registered Students</div>
									<div class="h5 mb-0  text-gray-800"> {{ $registeredStudents->count() }}</div>
								</div>
								<div class="col-auto">
									<i class="fas fa-book-reader fa-2x text-gray-300"></i>
								</div>
							</div>
						</div>
					</div>
			</div>
			<div class="col-xl-3 col-md-6 mb-4">
					<div class="card border-left-success  h-100 py-2">
						<div class="card-body">
							<div class="row no-gutters align-items-center">
								<div class="col mr-2">
									<div class="text-xs font-weight-bold  text-success text-uppercase mb-1"># of Enrolled Students </div>
									<div class="h5 mb-0  text-gray-800">{{ $registeredWithCourse->count() }}</div>
								</div>
								<div class="col-auto">
									<i class="fas fa-book-reader fa-2x text-gray-300"></i>
								</div>
							</div>
						</div>
					</div>
			</div>
			<div class="col-xl-3 col-md-6 mb-4">
				<div class="card border-left-info  h-100 py-2">
					<div class="card-body">
						<div class="row no-gutters align-items-center">
							<div class="col mr-2">
								<div class="text-xs font-weight-bold text-info text-uppercase mb-1"># of Students take Final Exam</div>
								<div class="row no-gutters align-items-center">
									<div class="col-auto">
										<div class="h5 mb-0 mr-3 text-gray-800">{{ $registeredWithFinalExam->count() }}</div>
									</div>
								</div>
							</div>
							<div class="col-auto">
								<i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xl-3 col-md-6 mb-4">
				<div class="card border-left-warning  h-100 py-2">
					<div class="card-body">
						<div class="row no-gutters align-items-center">
							<div class="col mr-2">
								<div class="text-xs font-weight-bold text-warning text-uppercase mb-1"># of Activities</div>
								<div class="h5 mb-0 font-weight-bold text-gray-800"></div>
							</div>
							<div class="col-auto">
								<i class="fas fa-comments fa-2x text-gray-300"></i>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
			<div class="card rounded-0">
		        <!-- Card Header - Accordion -->
		        <a href="#collapseRegisteredStudents" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseRegisteredStudents">
		          <h6 class="m-0 font-weight-bold text-dark">Registered Students <span class="badge badge-pill badge-primary">{{ $registeredStudents->count() }}</span></h6>
		        </a>
		        <!-- Card Content - Collapse -->
		        <div class="collapse " id="collapseRegisteredStudents" style="">
		          <div class="card-body">
		            <table class="table table-bordered table-hover text-dark" id="registered-students" width="100%">
						<thead>
							<tr>
								<th>Fullname</th>
								<th>City/Town</th>
							</tr>
						</thead>
						<tbody class="text-dark">
							@foreach($registeredStudents as $student)
							<tr>
								<td>{{ $student->name }}</td>
								<td>{{ $student->city_town }}</td>
							</tr>
							@endforeach
						</tbody>
					</table>
		          </div>
		        </div>
	     	</div>

	     	<div class="card rounded-0 mt-2">
		        <!-- Card Header - Accordion -->
		        <a href="#registeredWithCourse" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="registeredWithCourse">
		          <h6 class="m-0 font-weight-bold text-dark">Registered Student With Enrolled Service <span class="badge badge-pill badge-primary">{{ $registeredWithCourse->count() }}</span></h6>
		        </a>
		        <!-- Card Content - Collapse -->
		        <div class="collapse " id="registeredWithCourse" style="">
		          <div class="card-body">
		            	<table class="table table-bordered table-hover text-dark" id="registered-with-course" width="100%">
							<thead>
								<tr>
									<th>Fullname</th>
									<th>City/Town</th>
									<th>Enrolled</th>
									<th class="text-center">Activity Logs</th>
									<th class="text-center">Module Progress</th>
								</tr>
							</thead>
							<tbody class="text-dark">
								@foreach($registeredWithCourse as $student)
								<tr>
									<td>{{ $student->name }}</td>
									<td>{{ $student->city_town }}</td>
									<td>{{ $student->courses->last()->course->acronym }}</td>
									<td class="text-center"><a data-toggle="modal" href='#' data-name="{{ $student->name }}" data-id="{{ $student->id }}" class="btn btn-primary btn-sm open-log-modal">View</a></td>
									<td class="text-center"><a href="{{ route('student.show.progress', $student->id) }}" class="btn btn-primary btn-sm">Module Progress</a></td>
								</tr>
								@endforeach
							</tbody>
						</table>
		          </div>
		        </div>
	     	</div>

	     	<div class="card rounded-0 mt-2">
		        <!-- Card Header - Accordion -->
		        <a href="#registeredWithFinalExam" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="registeredWithFinalExam">
		          <h6 class="m-0 font-weight-bold text-dark">Registered Student with Final Exam Passed <span class="badge badge-pill badge-primary">{{ $registeredWithFinalExam->count() }}</span></h6>
		        </a>
		        <!-- Card Content - Collapse -->
		        <div class="collapse " id="registeredWithFinalExam" style="">
		          <div class="card-body">
		            	<table class="table table-bordered table-hover text-dark" id="registered-with-exam">
							<thead>
								<tr>
									<th>Fullname</th>
									<th>City/Town</th>
									<th>Enrolled</th>
								</tr>
							</thead>
							<tbody class="text-dark">
								@foreach($registeredWithFinalExam as $student)
								<tr>
									<td>{{ $student->name }}</td>
									<td>{{ $student->city_town }}</td>
									<td>{{ $student->courses->last()->course->acronym }}</td>
								</tr>
								@endforeach
							</tbody>
						</table>
		          </div>
		        </div>
	     	</div>

	     	<div class="modal fade" id="logs-modal">
	     		<div class="modal-dialog modal-lg" role="document">
	     			<div class="modal-content rounded-0 border-0">
	     				<div class="modal-header">
	     					<h4 class="modal-title">Student Activity Logs</h4>
	     				</div>
	     				<div class="modal-body" id="modal-content">
	     					<div class="text-center">
	     						<div class="spinner-border text-primary" role="status" id="modal-log-spinner">
							  		<span class="sr-only">Loading...</span>
								</div>
	     					</div>
	     				</div>
	     				<div class="modal-footer">
	     					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
	     				</div>
	     			</div>
	     		</div>
	     	</div>
	

  <!-- Bootstrap core JavaScript-->
 <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
 
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>

  <!-- Core plugin JavaScript-->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js" integrity="sha512-0QbL0ph8Tc8g5bLhfVzSqxe9GERORsKhIn1IrpxDAgUsbBGz/V7iSav2zzW325XGd1OMLdL4UiqRJj702IeqnQ==" crossorigin="anonymous"></script>

  <!-- Custom scripts for all pages-->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/startbootstrap-sb-admin-2/4.0.7/js/sb-admin-2.min.js" integrity="sha512-tEHlevWV9EmBCnrR098uzR3j8T3x4wtGnNY6SdsZN39uxICadRZaxrRH90iHPqjsqZK5z76gw0uuAvlCoasOUQ==" crossorigin="anonymous"></script>

  <script>
	$.ajaxSetup({
		headers: { 	'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') 	}
	});
</script>	
<script src="https://cdn.jsdelivr.net/npm/startbootstrap-sb-admin-2@4.1.1/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/startbootstrap-sb-admin-2@4.1.1/vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous"></script>
<script>
	let studentName = null;
	let studentId = null;

	$('#registered-students, #registered-with-exam, #registered-with-course').DataTable();
	
	$('.open-log-modal').click(function (e) {
		studentName = $(this).attr('data-name').split(' ')[0];
		studentId = $(this).attr('data-id');
		e.preventDefault();
		$('#logs-modal').modal('toggle');
	});

	$('#logs-modal').on('shown.bs.modal', function () {
	  	// Ajax request by id of the student.
	  	$.get({
	  		url : `/admin/student/${studentId}/activity/log`,
	  		success : function (response) {
	  			$('#modal-content').html('');
	  			let logs = response;
	  			if (logs.length != 0) {
	  				logs.forEach((log) => {
		  				let action = log.perform.charAt(0).toUpperCase() + log.perform.slice(1);
		  				$('#modal-content').append(`<li>${studentName} - <span class='text-primary'>${action}</span>  <span class="float-right mt-1 badge badge-sm badge-default font-weight-bold"><small>${moment(log.created_at).format('L h:mm A')}</small></span> </li><hr>`);
		  			});	
	  			} else {
	  				$('#modal-content').append('<div class="text-center"><span class="text-danger">No Available Logs</span></div>');
	  			}
	  			
	  		},
	  	});
	});

	$('#logs-modal').on('hidden.bs.modal', function () {
	  	$('#modal-content').html('').append(`
	  		<div class="text-center">
				<div class="spinner-border text-primary" role="status" id="modal-log-spinner">
		  			<span class="sr-only">Loading...</span>
				</div>
			</div>
	     `);
	});
</script>
</body>
</html>