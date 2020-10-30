@extends('layouts.student.app')
@section('title', '')
@section('content')
<div class="card rounded-0 mb-4">
	<div class="card-body">
		<div class="row">
			<div class="col-lg-3">
				<div class="card rounded-0">
					<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
					</div>
					<!-- Card Body -->
					<div class="card-body text-center">
						@if(Str::contains(Auth::user()->profile , ['http', 'https']))
		                  <img class="img-profile rounded-circle" width="160px" src="{{ Auth::user()->profile }}">
		                  @else
		                  <img class="img-profile rounded-circle" width="160px" src="{{ asset('student_image/' . Auth::user()->profile) }}">
		                @endif
						<h4 class="text-dark mb-0">{{ $student->firstname }}  {{ $student->surname }}</h4>
						<hr>
					</div>
					<div class="card-footer"></div>
				</div>
			</div>
			<div class="col-lg-9">
				<div class="card rounded-0">
					<div class="card-body">
						<nav>
							<div class="nav nav-tabs" id="nav-tab" role="tablist">
								<a class="nav-item rounded-0 nav-link active" id="nav-courses-tab" data-toggle="tab" href="#nav-courses" role="tab" aria-controls="nav-courses" aria-selected="true">Courses</a>
								<a class="nav-item rounded-0 nav-link" id="nav-details-tab" data-toggle="tab" href="#nav-details" role="tab" aria-controls="nav-details" aria-selected="false">Details</a>
							</div>
						</nav>
						<div class="tab-content" id="nav-tabContent">
							<div class="tab-pane fade show active" id="nav-courses" role="tabpanel" aria-labelledby="nav-courses-tab">
								@if(!$currentCourse)
									<div class="text-center mt-2">
										<img src="https://res.cloudinary.com/dfm6cr1l9/image/upload/v1601806532/no-courses_rrzfqi.png" alt="">
										<br>
										<a href="{{ route('site.home') }}">Please enroll a course</a>
									</div>
									@else
									@foreach($studentCourses as $enroll)
											<div class="card rounded-0 mb-2 mt-2">
													<div class="card-body">
														<div class="row">
															<div class="col-lg-4">
																<img src="{{ $enroll->course->image }}" class="img-fluid" alt="">
															</div>
															<div class="col-lg-8 text-dark">
																<div class="mt-3">
																	<span>Program <span class="font-weight-bold text-uppercase">: {{ $enroll->course->program->name }}</span></span>
																	<hr>
																	<span>Course : <span class="font-weight-bold text-uppercase">{{ $enroll->course->name }}</span></span>
																	<hr>
																	<span>Started on : <span class="font-weight-bold"> {{ $enroll->created_at->format('l, j  F Y, h:i A') }}</span></span>
																	<hr>
																	<div class="progress rounded-0">
																  		<div class="progress-bar" role="progressbar" style="width: {{ $progress}}%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="{{ config('student_progress.max_percentage') }}">{{ $progress }}%</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
										@endforeach
								@endif
							</div>
							<div class="tab-pane fade" id="nav-details" role="tabpanel" aria-labelledby="nav-details-tab">
								<div class="row">
									<div class="col-lg-6">
										<div class="card rounded-0 mt-2">
											<div class="card-body text-dark">
												<h5 class="card-title">User details</h5>
												<div class="text-right">
													<a href="{{ route('student.profile.edit') }}">Edit profile</a>
												</div>
												<span class="font-weight-bold">Email address</span>
												<br>
												<span><a href="mailto:{{ $student->email }}">{{ $student->email }}</a></span>
												<br>
												<br>
												<span class="font-weight-bold">Username</span>
												<br>
												<span>{{ $student->username }}</span>
												<br>
												<br>
												<span class="font-weight-bold">City/Town</span>
												<br>
												<span>{{ $student->city_town }}</span>
											</div>
										</div>
									</div>
									<div class="col-lg-6">
										<div class="card rounded-0 mt-2">
											<div class="card-body text-dark">
												<h5 class="card-title">Course Details & Badges</h5>
												@if(!is_null($currentCourse))

												<span>Program <span class="font-weight-bold text-uppercase">: {{ $currentCourse->course->program->name  ?? '' }}</span></span>
												<hr>
												<span>Course : <span class="font-weight-bold text-uppercase">{{ $currentCourse->course->name ?? ''}}</span></span>
												<hr>
												<span>Started on : <span class="font-weight-bold"> {{ $currentCourse->created_at->format('l, j  F Y, h:i A') ?? '' }}</span></span>
												<hr>
												<div class="progress rounded-0">
													<div class="progress-bar" role="progressbar" style="width: {{ $progress}}%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="{{ config('student_progress.max_percentage') }}">{{ $progress }}%</div>
												</div>
												<hr>
													@foreach($currentCourse->badge as $badge)
														@if(in_array('BADGE_' . $badge->id, $userBadges))
															<img width="30px" src="{{ asset('badges/' . $badge->image) }}" alt=""> <span>{{ $badge->name }}</span>
														@endif
													@endforeach
												@endif
											</div>
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-lg-12 mt-2">
										<div class="card rounded-0">
											<div class="card-body text-dark">
												<h5 class="card-title">Reports</h5>
												@if(!is_null($currentCourse))
													<a href="{{ route('student.grade.report', $student->id) }}">Grade overview</a>
												@endif
											</div>
										</div>
									</div>
								</div>

							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@push('page-scripts')
@endpush
@endsection