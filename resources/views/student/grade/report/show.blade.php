@extends('layouts.student.app')
@section('title', '')
@section('content')
@prepend('page-css')
<style>
	.no-border {
		border : 0px solid transparent;
	}
</style>
@endprepend
<div class="card rounded-0 mb-4">
	<div class="card-body">
		<h1 class="text-dark">{{ $course->name }}</h1>
	</div>
</div>
<div class="row">
	<div class="col-lg-12">
		<div class="card rounded-0">
			<h3 class="card-title pt-3 pl-3 text-dark"><span id="dynamic-title" class="text-capitalize">User Report </span>- {{ Auth::user()->name }}</h3>
			<div class="card-body">
				<ul class="nav nav-tabs" role="tablist">
					<li class="nav-item">
						<a class="nav-link rounded-0 " id="overview-report-tab" data-toggle="tab" href="#overview-report" role="tab" aria-controls="overview-report" aria-selected="true">Overview Report</a>
					</li>
					<li class="nav-item">
						<a class="nav-link rounded-0 active" id="user-report-tab" data-toggle="tab" href="#user-report" role="tab" aria-controls="user-report" aria-selected="false">User Report</a>
					</li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane fade" id="overview-report" role="tabpanel" aria-labelledby="overview-report-tab">
						<table class="table table-striped table-hover">
							<thead>
								<tr class="text-dark">
									<th>Course name</th>
									<th>Grade</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td><a href="{{ route('student.grade.report', $currentCourse->id) }}">{{ $currentCourse->name }}</a></td>
									<td>{{ number_format((config('student_progress.max_percentage') / $noOfQuestions ) * $highestGrade, 2, '.', '') }}</td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="tab-pane fade show active" id="user-report" role="tabpanel" aria-labelledby="user-report-tab">
						<table class="table table-striped table-hover">
							<thead>
								<tr class="text-dark">
									<th colspan="4">Grade Item</th>
									<th>Calculated weight</th>
									<th>Grade</th>
									<th>Range</th>
									<th>Percentage</th>
									<th>Feedback</th>
									<th>Contribution to course total</th>
								</tr>
							</thead>
							<tbody>
								<tr>
										<td rowspan="5"></td>
										<td colspan="3" class="text-dark font-weight-bold"><i class="icon fa fa-folder fa-fw"></i> {{ $currentCourse->name }}</td>
										<td class="bg-faded"></td>
										<td class="bg-faded"></td>
										<td class="bg-faded"></td>
										<td class="bg-faded"></td>
										<td class="bg-faded"></td>
										<td class="bg-faded"></td>
									</tr>

									<tr>
										<td rowspan="3"></td>
										<td class="text-dark font-weight-bold"> <span class="ml-5"><i class="icon fa fa-folder fa-fw"></i> Exams</span></td>
										<td class="bg-faded"></td>
										<td class="bg-faded"></td>
										<td class="bg-faded"></td>
										<td class="bg-faded"></td>
										<td class="bg-faded"></td>
										<td class="bg-faded"></td>
										<td class="bg-faded"></td>
									</tr>
									<tr class="text-dark">
										<td colspan="1" class=""><span class="ml-5 pl-5"><a href="{{ route('view.final.exam', $module->id) }}"> <img class=" mr-1" src="https://res.cloudinary.com/dfm6cr1l9/image/upload/v1601889372/icons/final-exam_mdj9vl.png" alt="icon" width="18px">Final Exam</a></span></td>
										<td class="bg-faded"></td>
										<td class="bg-faded">{{ config('student_progress.max_percentage') }}%</td>
										<td class="bg-faded">{{ number_format((config('student_progress.max_percentage') / $noOfQuestions ) * $highestGrade, 2, '.', '') }}</td>
										<td class="bg-faded">0-{{ config('student_progress.max_percentage') }}</td>
										<td class="bg-faded">{{ number_format((config('student_progress.max_percentage') / $noOfQuestions ) * $highestGrade, 2, '.', '') }}%</td>
										<td class="bg-faded"></td>
										<td class="bg-faded">{{ number_format((config('student_progress.max_percentage') / $noOfQuestions ) * $highestGrade, 2, '.', '') }}%</td>
									</tr>

									<tr class="text-dark font-weight-bold">
										<td colspan="2"  class="">
											<span class="ml-5 pl-5 font-weight-bold">
												<img class=" mr-1" src="https://res.cloudinary.com/dfm6cr1l9/image/upload/v1603531691/icons/agg_mean_pzpz6d.svg" alt="icon" width="18px">
												Exams Total
											</span>
											<br>
											<span class="ml-5 pl-5 font-weight-light"><span class="ml-4 pl-2"></span>Simple weighted mean of grades.</span>
										</td>
										<td class="bg-faded">{{ config('student_progress.max_percentage') }}%</td>
										<td class="bg-faded">{{ number_format((config('student_progress.max_percentage') / $noOfQuestions ) * $highestGrade, 2, '.', '') }}</td>
										<td class="bg-faded">0-{{ config('student_progress.max_percentage') }}</td>
										<td class="bg-faded">{{ number_format((config('student_progress.max_percentage') / $noOfQuestions ) * $highestGrade, 2, '.', '') }}%</td>
										<td class="bg-faded"></td>
										<td class="bg-faded">-</td>
									</tr>

									<tr class="font-weight-bold text-dark">
										<td colspan="2"  class="">
											<span class="ml-5 pl-4 font-weight-bold">
												<img class=" mr-1" src="https://res.cloudinary.com/dfm6cr1l9/image/upload/v1603531691/icons/agg_mean_pzpz6d.svg" alt="icon" width="18px">
												Course Total
											</span>
											<br>
											<span class="ml-5 font-weight-light"><span class="ml-5 pl-1"></span>Weighted mean of grades.</span>
										</td>
										<td class="bg-faded"></td>
										<td class="bg-faded">-</td>
										<td class="bg-faded">{{ number_format((config('student_progress.max_percentage') / $noOfQuestions ) * $highestGrade, 2, '.', '') }}</td>
										<td class="bg-faded">0-100</td>
										<td class="bg-faded">{{ number_format((config('student_progress.max_percentage') / $noOfQuestions ) * $highestGrade, 2, '.', '') }}%</td>
										<td class="bg-faded"></td>
										<td class="bg-faded">-</td>
									</tr>
							</tbody>
						</table>

					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@push('page-scripts')
<script>
	$(document).ready(function () {
		$('.nav-link').click(function (e) {
			// check if data-toggle is tab.
			let element = $(this);
			if (element.attr('data-toggle') === 'tab') {
				// process the tab
				// get the id
				let tabId = element.attr('id');
				let paneTab = tabId.replace('-tab', '');
				$('#dynamic-title').text(`${paneTab.replace('-', ' ')} `);
			}
		});
	});
</script>
@endpush
@endsection