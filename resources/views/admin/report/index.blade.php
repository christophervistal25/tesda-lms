@extends('layouts.admin.app')
@section('title', 'Students')
@section('content')
@prepend('page-css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/startbootstrap-sb-admin-2@4.1.1/vendor/datatables/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
@endprepend
{{ Breadcrumbs::render('reports') }}
@include('layouts.admin.error')
<div class="card shadow mb-4 rounded-0">
	<div class="card-header py-3">
		<h6 class="m-0 font-weight-bold text-primary">Generate Report</h6>
	</div>
	<div class="card-body text-dark">
		<form action="{{ route('report.store') }}" method="POST">
			@csrf
			<div class="row">
				<div class="col-lg-6">
					<label for="#startDate">Pick Start Date</label>
				</div>
				<div class="col-lg-6">
					<label for="#endDate">Pick End Date</label>
				</div>
				<div class="col-lg-6">
					<input type="date" id="startDate" class="form-control" value="{{ isset($generated) ? $from->format('Y-m-d') : '' }}" name="start_date">
				</div>
				<div class="col-lg-6">
					<input type="date" id="endDate" class="form-control" value="{{ isset($generated) ? $to->format('Y-m-d') : '' }}"  name="end_date">
				</div>
			</div>
			<br>
			<div class="float-right">
				<input type="submit" value="Generate Report" class="btn btn-primary">
			</div>
			<div class="clearfix"></div>
			<hr>
		</form>
		@isset($generated)
			<div class="row">
			<div class="col-xl-3 col-md-6 mb-4">
				<a href="{{ route('student.index') }}" class="text-decoration-none">
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
				</a>
			</div>
			<div class="col-xl-3 col-md-6 mb-4">
				<a href="{{ route('course.index') }}" class="text-decoration-none">
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
				</a>
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
		            <table class="table table-bordered table-hover text-dark" id="registered-students">
						<thead>
							<tr>
								<th>Fullname</th>
								<th>Email</th>
								<th>City/Town</th>
							</tr>
						</thead>
						<tbody class="text-dark">
							@foreach($registeredStudents as $student)
							<tr>
								<td>{{ $student->name }}</td>
								<td>{{ $student->email }}</td>
								<td>{{ $student->city_town }}</td>
							</tr>
							@endforeach
						</tbody>
					</table>
		          </div>
		        </div>
	     	</div>

	     	<div class="card rounded-0">
		        <!-- Card Header - Accordion -->
		        <a href="#registeredWithCourse" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="registeredWithCourse">
		          <h6 class="m-0 font-weight-bold text-dark">Registered Student With Enrolled Service <span class="badge badge-pill badge-primary">{{ $registeredWithCourse->count() }}</span></h6>
		        </a>
		        <!-- Card Content - Collapse -->
		        <div class="collapse " id="registeredWithCourse" style="">
		          <div class="card-body">
		            	<table class="table table-bordered table-hover text-dark" id="registered-with-course">
							<thead>
								<tr>
									<th>Fullname</th>
									<th>Email</th>
									<th>City/Town</th>
									<th>Enrolled</th>
								</tr>
							</thead>
							<tbody class="text-dark">
								@foreach($registeredWithCourse as $student)
								<tr>
									<td>{{ $student->name }}</td>
									<td>{{ $student->email }}</td>
									<td>{{ $student->city_town }}</td>
									<td>{{ $student->courses->last()->course->acronym }}</td>
								</tr>
								@endforeach
							</tbody>
						</table>
		          </div>
		        </div>
	     	</div>

	     	<div class="card rounded-0">
		        <!-- Card Header - Accordion -->
		        <a href="#registeredWithFinalExam" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="registeredWithFinalExam">
		          <h6 class="m-0 font-weight-bold text-dark">Registered Student with Final Exam Passed <span class="badge badge-pill badge-primary">{{ $registeredWithCourse->count() }}</span></h6>
		        </a>
		        <!-- Card Content - Collapse -->
		        <div class="collapse " id="registeredWithFinalExam" style="">
		          <div class="card-body">
		            	<table class="table table-bordered table-hover text-dark" id="registered-with-exam">
							<thead>
								<tr>
									<th>Fullname</th>
									<th>Email</th>
									<th>City/Town</th>
									<th>Enrolled</th>
								</tr>
							</thead>
							<tbody class="text-dark">
								@foreach($registeredWithFinalExam as $student)
								<tr>
									<td>{{ $student->name }}</td>
									<td>{{ $student->email }}</td>
									<td>{{ $student->city_town }}</td>
									<td>{{ $student->courses->last()->course->acronym }}</td>
								</tr>
								@endforeach
							</tbody>
						</table>
		          </div>
		        </div>
	     	</div>
		@endisset
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
	$('#registered-students, #registered-with-exam, #registered-with-course').DataTable();
</script>
@endpush
@endsection